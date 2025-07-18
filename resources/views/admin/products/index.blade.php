@extends('admin.layouts.app')
@section('title', 'Product List')
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
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new product
                        </a>
                        {{-- <button data-route="{{ route('admin.products.bulk_delete') }}" type="button" id="bulk-delete-btn" class="btn btn-danger" disabled>Delete Selected</button> --}}
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
                <div class="card-body border-bottom py-3">
                  <div class="d-flex">
                    <div class="text-secondary">
                      Show
                      <div class="mx-2 d-inline-block">
                        <select name="limit" onchange="updateData(this)" data-route="{{ route('admin.products.index') }}">
                          <option value="5" @selected((request()->limit ?? 10) == 5)>5</option>
                          <option value="10" @selected((request()->limit ?? 10) == 10)>10</option>
                          <option value="20" @selected((request()->limit ?? 10) == 20)>20</option>
                        </select>
                      </div>
                      products
                    </div>
                    <div class="ms-auto text-secondary">
                      Search:
                      <div class="ms-2 d-inline-block">
                        <form action="">
                          <input type="text" class="form-control form-control-sm" aria-label="Search Products" name="q" value="{{ request()->q }}">
                          <input type="hidden" name="limit" id="limitInput" value="{{ request()->limit }}">
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                      <tr>
                        <th class="w-1"><input class="form-check-input m-0 align-middle" id="select-all-items" type="checkbox" aria-label="Select all invoices"></th>
                        <th class="w-1">ID
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" /></svg>
                        </th>
                        <th>Name</th>
                        <th>Sku</th>
                        <th>Category</th>
                        <th>Type</th>
                        {{-- <th>Description</th> --}}
                        {{-- <th>Purchase Price</th>
                        <th>Sale Price</th> --}}
                        {{-- <th>Quantity</th> --}}
                        <th>Created at</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td><input class="form-check-input m-0 align-middle selected-item" type="checkbox" value="{{ $product->id }}" aria-label="Select invoice"></td>
                        <td><span class="text-secondary">{{ $product->id }}</span></td>
                        <td><a href="{{ route('admin.products.show', $product->id) }}" class="text-reset" tabindex="-1">{{ $product->title }}</a></td>
                        <td><span class="text-secondary">{{ $product->sku }}</span></td>
                        <td><span class="text-secondary">{{ $product->category->title }}</span></td>
                        <td><span class="text-secondary">{{ $product->type }}</span></td>
                        {{-- <td>{{ $product->description }}</td> --}}
                        {{-- <td>{{ $product->purchase_price }}</td>
                        <td>{{ $product->sale_price }}</td> --}}
                        {{-- <td>{{ $product->quantity }}</td> --}}
                        <td>{{ $product->created_at->diffForHumans() }}</td>
                        <td class="text-end">
                          <span class="dropdown">
                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="{{ route('admin.products.edit', $product->id) }}">
                                Edit
                              </a>
                              <form onsubmit="return confirmDelete(event, this)"
                                  action="{{ route('admin.products.destroy', $product->id) }}"
                                  method="post">
                                  @csrf
                                  @method('delete')
                                  <button type="submit" class="text-danger dropdown-item delete-btn">Delete</button>
                              </form>
                            </div>
                          </span>
                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="card-footer">
                  {{ $products->links('pagination::bootstrap-5') }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection


