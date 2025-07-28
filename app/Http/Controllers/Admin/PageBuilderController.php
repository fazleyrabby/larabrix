<?php

namespace App\Http\Controllers\Admin;

use App\Builders\PageBlocks;
use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Page;
use Illuminate\Http\Request;

class PageBuilderController extends Controller
{
    public function index(Request $request, $id)
    {
        $page = Page::find($id);
        $pageBlocks = PageBlocks::all();
        $forms = Form::toBase()->pluck('name', 'id');
        return view('admin.pages.builder', [
            'hideSidebar' => true,
            'hideNavbar' => true,
            'hideFooter' => true,
            'page' => $page,
            'pageBlocks' => $pageBlocks,
            'forms' => $forms
        ]);
    }

    public function store(Request $request, $id)
    {
        $page = Page::find($id);
        $page->builder = json_encode($request->builder);
        $page->save();
        return response()->json([
            'success' => 'success',
            'message' => 'Builder updated!'
        ]);
    }

    public function addBlock(Request $request, Page $page)
    {
        $blockType = $request->input('type');
        $position = $request->input('position');
        $targetIndex = $request->input('targetIndex');

        $existingBlocks = json_decode($page->builder, true) ?? [];

        // Get block definition
        $newBlock = PageBlocks::get($blockType);

        if (!$newBlock) {
            return response()->json(['error' => 'Invalid block type'], 400);
        }

        // Ensure block has type and props
        $newBlock['type'] ??= $blockType;
        $newBlock['props'] ??= [];

        // Determine insertion index
        $insertIndex = (int) $targetIndex;
        if ($position === 'after') {
            $insertIndex++;
        }

        // Insert the new block
        array_splice($existingBlocks, $insertIndex, 0, [$newBlock]);

        // Save updated builder JSON
        $page->builder = json_encode($existingBlocks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $page->save();

        // Render the block preview HTML
        $block = (object) $newBlock;
        $index = $insertIndex;

        $html = view('frontend.page-partials.block-wrapper', compact('block', 'index'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'insertIndex' => $insertIndex
        ]);
    }

    public function save(Request $request,Page $page)
    {
        $request->validate([
            'page_id' => 'required|integer|exists:pages,id',
            'blocks' => 'required|array',
        ]);
        
        $page->builder = json_encode($request->blocks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $page->save();

        return response()->json([
            'success' => true,
            'message' => 'Page builder saved successfully',
        ]);
    }
}
