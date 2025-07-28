@extends('admin.layouts.app')
@section('title', 'Payment Gateway Edit')
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
                        Payment Gateway Edit
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-danger">
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
                    <form action="{{ route('admin.payment-gateways.update', $paymentGateway->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h3 class="card-title">Update Payment Gateway</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Name</label>
                                <div class="col">
                                    <input type="text" class="form-control" aria-describedby="name"
                                        placeholder="Name" name="name" value="{{ $paymentGateway->name }}">
                                    <small class="form-hint">
                                        @error('title')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </small>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Slug</label>
                                <div class="col">
                                    <input type="text" class="form-control" aria-describedby="slug"
                                        placeholder="Slug" name="slug" value="{{ $paymentGateway->slug }}">
                                    <small class="form-hint">
                                        @error('slug')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </small>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Namespace</label>
                                <div class="col">
                                    <input type="text" class="form-control" aria-describedby="namespace"
                                        placeholder="Namespace" name="namespace" value="{{ $paymentGateway->namespace }}">
                                    <small class="form-hint">
                                        @error('namespace')
                                            <div class="text-danger mt-2">{{ $message }}</div>
                                        @enderror
                                    </small>
                                </div>
                            </div>

                            @foreach ($paymentGateway->config ?? [] as $key => $value)
                                <div class="mb-3 row">
                                <label class="col-3 col-form-label required">{{ ucfirst(str_replace('_', " ", $key)) }}</label>
                                    <div class="col">
                                        <input type="text" class="form-control" aria-describedby="{{ $key }}"
                                            placeholder="{{ $key }}" name="config[{{ $key }}]" value="{{ $value }}">
                                        <small class="form-hint">
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Media File Input</label>
                                <div class="col">
                                    <button 
                                        type="button" 
                                        class="btn btn-primary" 
                                        id="gateway-offcanvas-btn" 
                                        data-bs-toggle="offcanvas" 
                                        data-bs-target="#gateway-offcanvas" 
                                        aria-controls="gateway-offcanvas"
                                        aria-expanded="false"
                                    >
                                        Upload File
                                    </button>

                                    <div id="gateway-offcanvas-wrapper">
                                        @if ($paymentGateway->photo)
                                            <div class="my-3">Image Preview:</div>
                                            <div class="image-wrapper">
                                                <img src="{{ asset($paymentGateway->photo) }}" />
                                                <input type="hidden" name="photo" value="{{ $paymentGateway->photo }}">
                                                <span type="button" class="remove-image">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M18 6l-12 12"></path><path d="M6 6l12 12"></path></svg>
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-3 col-form-label required">Enabled</label>
                                <div class="col">
                                    <select type="text" class="form-select" name="enabled" id="select-users">
                                        <option value="1" @selected($paymentGateway->enabled == 1)>Yes</option>
                                        <option value="0" @selected($paymentGateway->enabled == 0)>No</option>
                                    </select>
                                    <small class="form-hint">
                                        @error('enabled')
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
    </div>

    @include('admin.components.media.popup', [
        'modalId' => 'gateway-offcanvas',
        'inputType' => 'single',
        'imageInputName' => 'photo'
    ])

@endsection

