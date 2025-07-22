@extends('frontend.app')

@section('content')
    @foreach($blocks as $block)
        @includeIf('frontend.blocks.' . $block->type, ['data' => $block->props])
    @endforeach
@endsection