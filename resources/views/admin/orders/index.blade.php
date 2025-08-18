@extends('admin.layouts.app')
@section('title', 'Order List')
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
                        Orders
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.products.categories.create') }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Create new order
                        </a>
                        {{-- <button data-route="{{ route('admin.categories.bulk_delete') }}" type="button" id="bulk-delete-btn" class="btn btn-danger" disabled>Delete Selected</button> --}}
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
                        <select name="limit" onchange="updateData(this)" data-route="{{ route('admin.orders.index') }}">
                          <option value="5" @selected((request()->limit ?? 10) == 5)>5</option>
                          <option value="10" @selected((request()->limit ?? 10) == 10)>10</option>
                          <option value="20" @selected((request()->limit ?? 10) == 20)>20</option>
                        </select>
                      </div>
                      items
                    </div>
                    <div class="ms-auto text-secondary">
                      Search:
                      <div class="ms-2 d-inline-block">
                        <form action="">
                          <input type="text" class="form-control form-control-sm" aria-label="Search Categories" name="q" value="{{ request()->q }}" placeholder="ID, Order No., Gateway....">
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
                        <th>Order No.</th>
                        {{-- <th>Trx ID</th> --}}
                        <th>Currency</th>
                        <th>Gateway</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Created at</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td><input class="form-check-input m-0 align-middle selected-item" type="checkbox" value="{{ $order->id }}" aria-label="Select invoice"></td>
                        <td><span class="text-secondary">{{ $order->id }}</span></td>
                        <td><a href="{{ route('admin.orders.show', $order->id) }}" class="text-reset" tabindex="-1">{{ $order->order_number }}</a></td>
                        {{-- <td>{{ $order->transaction->transaction_id }}</td> --}}
                        <td>{{ $order->currency }}</td>
                        <td>{{ $order->payment_gateway }}</td>
                        <td>
                          <table class="table border">
                            <tbody>
                              @foreach ($order->items as $item)
                                <tr>
                                    <td class="border">{{ $item->quantity ?? 1 }} x {{ $item->product->title }}</td>
                                    <td class="border">{{ number_format($item->price ?? 0, 2) }}</td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </td>
                        <td>{{ $order->total }}</td>
                        <td>{{ $order->created_at->diffForHumans() }}</td>
                        <td class="text-end">
                          <span class="dropdown">
                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="{{ route('admin.orders.edit', $order->id) }}">
                                Edit
                              </a>
                              <form onsubmit="return confirmDelete(event, this)"
                                  action="{{ route('admin.orders.destroy', $order->id) }}"
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
                  {{ $orders->links('pagination::bootstrap-5') }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection


