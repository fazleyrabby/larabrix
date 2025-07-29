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
        $incomingBlock = $request->input('block'); // Optional

        $existingBlocks = json_decode($page->builder, true) ?? [];

        // Use client-provided block if available (with unique ID), fallback to default
        $newBlock = $incomingBlock ?: PageBlocks::get($blockType);

        if (!$newBlock) {
            return response()->json(['error' => 'Invalid block type'], 400);
        }

        // Ensure type and props
        $newBlock['type'] ??= $blockType;
        $newBlock['props'] ??= [];

        // If no ID (somehow), generate one here (failsafe)
        $newBlock['id'] ??= $blockType . '-' . now()->timestamp . '-' . rand(100, 999);

        // Determine insertion index
        $insertIndex = (int) $targetIndex;
        if ($position === 'after') {
            $insertIndex++;
        }

        // Insert the new block
        array_splice($existingBlocks, $insertIndex, 0, [$newBlock]);

        // Save
        $page->builder = json_encode($existingBlocks);
        $page->save();

        $block = (object) $newBlock;
        $index = $insertIndex;

        $html = view('frontend.page-partials.block-wrapper', compact('block', 'index'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'insertIndex' => $insertIndex
        ]);
    }

    public function save(Request $request, Page $page)
    {
        $request->validate([
            'page_id' => 'required|integer|exists:pages,id',
            'blocks' => 'nullable|array',
        ]);

        $page->builder = json_encode($request->blocks);
        $page->save();

        return response()->json([
            'success' => true,
            'message' => 'Page builder saved successfully',
        ]);
    }
}
