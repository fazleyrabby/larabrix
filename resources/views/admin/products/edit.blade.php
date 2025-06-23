@extends('admin.layouts.app')
@section('title', 'Product Edit')
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
                    <form class="card" action="{{ route('admin.products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h3 class="card-title">Edit form</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Product title</label>
                                <div class="col">
                                    <input type="text" class="form-control" aria-describedby="emailHelp"
                                        placeholder="Product Name" name="title" value="{{ $product->title }}">
                                    <small class="form-hint">
                                        @error('title')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-3 col-form-label required">Product Image</div>
                                <div class="col">
                                    <input type="file" class="form-control" name="image"/>
                                    <small class="form-hint">
                                        @error('image')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </small>
                                    <div>Previous Image:</div>
                                    @if(isset($product->image) && filled($product->image))
                                    <img width="100" src="{{ asset($product->image) }}" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Product Sku</label>
                                <div class="col">
                                    <input type="text" class="form-control" aria-describedby=""
                                        placeholder="Product Sku" name="sku" value="{{ $product->sku }}">
                                    <small class="form-hint">
                                        @error('sku')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Price</label>
                                <div class="col">
                                    <input type="text" class="form-control" name="price" placeholder="price" value="{{ $product->price }}">
                                    <small class="form-hint">
                                    </small>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Category</label>
                                <div class="col">
                                <select type="text" class="form-select" id="categories" name="category_id" value="">
                                    @foreach ($categories as $index => $value)
                                        <option value="{{ $index }}" @selected($index == $product->category_id)>{{ $value }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Descripion</label>
                                <div class="col">
                                    <textarea name="description" class="form-control" id="" cols="30" rows="10">{{ $product->description }}</textarea>
                                    <small class="form-hint">
                                        @error('description')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

<script>
    document.addEventListener("DOMContentLoaded", function () {
    	var el;
    	window.TomSelect && (new TomSelect(el = document.getElementById('categories'), {
            allowEmptyOption: true,
            create: true
    	}));
    });
  </script>

@endpush
