<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Term;
use App\Services\CommonBusinessService;
use App\Services\PhotoService;
use App\Services\ProductService;
use App\Traits\UploadPhotos;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use AuthorizesRequests, UploadPhotos;
    protected ProductService $service;
    public function __construct(){
        $this->service = new ProductService;
    }
    public function index(Request $request, ProductService $productService)
    {
        $products = $productService->getPaginatedItems($request->all());
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::toBase()->pluck('title', 'id');
        $brands = Term::where('type','brand')->toBase()->pluck('value', 'id');
        $attributes = Attribute::with('values')->get();
        return view('admin.products.create', compact('categories','attributes','brands'));
    }

    public function edit(Product $product)
    {
        // $this->authorize('create', Product::class);
        $categories = Category::toBase()->pluck('title', 'id');
        $brands = Term::where('type','brand')->toBase()->pluck('value', 'id');
        $attributes = Attribute::with('values')->get();
        $combinations = $this->service->variantCombinations($product);
        $attrRows = $this->service->attributeRows($combinations);
        return view('admin.products.edit', compact('product', 'categories','attributes','combinations','attrRows','brands'));
    }

    public function store(ProductRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $additionalInfo = $this->formatAdditionalInfo(
                    $request->input('detail_key', []),
                    $request->input('detail_value', [])
                );
                $data['additional_info'] = $additionalInfo;
                $data['is_pc_component'] = $request->is_pc_component == 'yes';
                $data = $request->validated();
                // if ($request->hasFile('image')) {
                //     $data['image'] = $this->uploadPhoto($request->file('image'));
                // }
                $product = Product::create($data);
                $this->service->storeCombinations($request, $product);
            });
            return redirect()->route('admin.products.create')->with('success', 'Successfully created!');
        } catch (\Throwable $e) {
            Log::error('Product creation failed', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->withErrors('Failed to create the product. Please try again.');
        }
    }
    public function show($id)
    {
        $product = Product::with('category:id,title')->find($id);
        return view('admin.products.show', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            DB::transaction(function () use ($request, $product) {
                $data = $request->validated();
                $additionalInfo = $this->formatAdditionalInfo(
                    $request->input('detail_key', []),
                    $request->input('detail_value', [])
                );
                $data['is_pc_component'] = $request->is_pc_component == 'yes';
                $data['additional_info'] = $additionalInfo;
                $product->update($data);
                $oldVariants = $product->variants->keyBy('id');
                $this->service->storeCombinations($request, $product, $oldVariants);
            });
            
            return redirect()->route('admin.products.index')->with('success','Successfully updated!');
        } catch (\Throwable $e) {
            Log::error('Product update failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('success', 'Failed to update the product. Please try again.');
        }
    }


    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $this->deleteImage($product->image);
            $product->delete();
            return redirect()->route('admin.products.index')->with('success','Successfully deleted!');
        } catch (\Throwable $e) {
            Log::error('Product update failed', [
                'product_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Successfully updated!');
        }
    }

    private function formatAdditionalInfo(array $keys, array $values): ?string
    {
        $details = [];
        foreach ($keys as $index => $key) {
            $key = trim($key);
            $value = trim($values[$index] ?? '');
            if ($key !== '' && $value !== '') {
                $details[$key] = $value;
            }
        }
        return !empty($details) ? json_encode($details) : null;
    }

    // public function bulkDelete(Request $request, CommonBusinessService $commonBusinessService)
    // {
    //     $ids = $request->input('ids');
    //     $files = Product::whereIn('id',$ids)->pluck('image');
    //     foreach($files as $file){
    //         $this->deleteImage($file);
    //     }
    //     $response = $commonBusinessService->bulkDelete($ids, 'App\Models\Product');
    //     return redirect()->route('admin.products.index')->with($response);
    // }
}
