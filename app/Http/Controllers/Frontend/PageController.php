<?php

namespace App\Http\Controllers\Frontend;

use App\Builders\PageBlocks;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function show(Request $request, $slug){
        $page = Page::where('slug', $slug)->firstOrFail();
        $builder = json_decode($page->builder, true);

        $blocks = collect($builder ?? [])->map(function ($block) {
            if ($block['type'] === 'blogs') {
                $limit = $block['props']['limit'] ?? 3;

                $block['props']['posts'] = Blog::latest()
                    ->take($limit)
                    ->get()
                    ->map(function ($blog) {
                        return [
                            'title' => $blog->title,
                            'excerpt' => Str::limit(strip_tags(Markdown::parse($blog->content ?? '')), 100),
                            'url' => "",// route('blog.show', $blog->slug),
                            'published_at' => optional($blog->published_at)->format('M d, Y'),
                        ];
                    })
                    ->toArray();
            }

            return PageBlocks::make($block);
        })->filter();

        return view('frontend.pages.show', compact('page', 'blocks'));
    }
}
