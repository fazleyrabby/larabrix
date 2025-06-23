@extends('admin.layouts.app')
@section('title', 'Product Create')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    {{-- <div class="page-pretitle">
                        Overview
                    </div> --}}
                    <h2 class="page-title">
                        Products
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-danger">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
          <div class="row row-deck row-cards">
            <div class="col-12">
              <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Product preview</h3>
                    </div>
                    <div class="card-body">
                        @if(isset($product->image) && filled($product->image))
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Product Image</label>
                            <div class="col">
                                <img width="200" src="{{ asset($product->image) }}" alt="" class="border">
                            </div>
                        </div>
                        @endif
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Product title</label>
                            <div class="col">
                                {{ $product->title }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Product sku</label>
                            <div class="col">
                                {{ $product->sku }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Product price</label>
                            <div class="col">
                                {{ $product->price }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Product category</label>
                            <div class="col">
                                {{ $product->category->title }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Descripion</label>
                            <div class="col">
                                {{ $product->description }}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                            Edit
                        </a>
                    </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection
