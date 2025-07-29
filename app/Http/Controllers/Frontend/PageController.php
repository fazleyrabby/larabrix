<?php

namespace App\Http\Controllers\Frontend;

use App\Builders\PageBlocks;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Form;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function show(Request $request, $slug){
        $pageData = $this->getPage($request, $slug);
        $page = $pageData['page'];
        $blocks = $pageData['blocks'];
        return view('frontend.pages.show', compact('page', 'blocks'));
    }

    public function preview(Request $request, $slug){
        $pageData = $this->getPage($request, $slug);
        $page = $pageData['page'];
        $blocks = $pageData['blocks'];
        $availableBlocks = PageBlocks::all();
        return view('frontend.pages.preview', compact('page', 'blocks','availableBlocks'));
    }

    private function getPage($request, $slug){
        $data['page'] = Page::where('slug', $slug)->firstOrFail();
        $builder = json_decode($data['page']->builder, true);
        $data['blocks'] = collect($builder ?? [])->map(function ($block) use ($slug) {
            if ($block['type'] === 'blogs') {
                $limit = $block['props']['limit']['value'] ?? 6;

                $block['props']['posts'] = Blog::latest()
                    ->take($limit)
                    ->get()
                    ->map(function ($blog) use ($slug) {
                        return [
                            'title' => $blog->title,
                            'excerpt' => Str::limit(strip_tags(Markdown::parse($blog->content ?? '')), 100),
                            'url' => route('frontend.blog.show', $blog->slug) . "?pageSlug=". $slug,
                            'published_at' => optional($blog->created_at)->format('M d, Y'),
                        ];
                    })
                    ->toArray();
            }

            if($block['type'] === 'form'){
                $block['props']['form'] = Form::with('formFields')->find($block['props']['form_id']);
            }
            return PageBlocks::make($block);
        })->filter();
        return $data;
    }

    public function blog($slug){
        $pageSlug = request()->get('pageSlug');
        $blog = Blog::toBase()->where('slug', $slug)->first();
        return view('frontend.pages.blog', compact('blog','pageSlug'));
    }
}
