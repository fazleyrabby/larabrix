@extends('frontend.app')

@section('content')
    @foreach($blocks as $index => $block)
        @includeIf('frontend.blocks.' . $block->type, ['data' => $block->props, 'index' => $block->type.$index])
    @endforeach
@endsection