<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\CommonBusinessService;
use App\Services\PhotoService;
use App\Services\ProductService;
use App\Traits\UploadPhotos;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

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
        $attributes = Attribute::with('values')->get();
        return view('admin.products.create', compact('categories','attributes'));
    }

    public function edit(Product $product)
    {
        // $this->authorize('create', Product::class);
        $categories = Category::toBase()->pluck('title', 'id');
        $attributes = Attribute::with('values')->get();
        $combinations = $this->service->variantCombinations($product);
        $attrRows = $this->service->attributeRows($combinations);
        return view('admin.products.edit', compact('product', 'categories','attributes','combinations','attrRows'));
    }

    public function store(ProductRequest $request)
    {
        // dd($request->all());
        // $this->authorize('create', Product::class);
        $data = $request->validated(); // Get validated data
        // Check if there's an image file and upload it
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadPhoto($request->file('image'));
        }
        $product = Product::create($data);
        $this->storeCombinations($request, $product);
        return redirect()->route('admin.products.create')->with(['success' => 'Successfully created!']);
    }


    public function show($id)
    {
        $product = Product::with('category:id,title')->find($id);
        return view('admin.products.show', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        // $this->authorize('create', Product::class);
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadPhoto($request->file('image'), $product->image);
        }
        $product->update($data);
        $oldVariants = $product->variants->keyBy('id');
        foreach ($product->variants as $oldVariant) {
            $oldVariant->attributeValues()->detach();
            $oldVariant->delete();
        }
        $this->storeCombinations($request, $product, $oldVariants);
        return redirect()->route('admin.products.index')->with(['success' => 'Successfully updated!']);
    }


    public function destroy($id)
    {
        // $this->authorize('delete', Product::class);
        $product = Product::findOrFail($id);
        $this->deleteImage($product->image);
        $product->delete();
        return redirect()->route('admin.products.index')->with(['success' => 'Successfully deleted!']);
    }

    private function storeCombinations($request, $product, $oldVariants=[])
    {
        $combinations = $request->combinations ?? [];
        foreach ($combinations as $combination) {
            $image = null;

            if (isset($combination['image']) && $combination['image'] instanceof \Illuminate\Http\UploadedFile) {
                $image = $this->uploadPhoto($combination['image']);
            }
            if (!$image && $oldVariants && isset($combination['variant_id'])) {
                $image = $oldVariants[$combination['variant_id']]->image ?? null;
            }
            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'sku' => $combination['sku'],
                'price' => $combination['price'],
                'image' => $image,
            ]);
            $variant->attributeValues()->attach($combination['ids']);
        }
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
