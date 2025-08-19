@extends('admin.layouts.app')
@section('title', 'Form Submissions')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Form Submissions
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.forms.index') }}" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M15 6l-6 6l6 6"></path>
                            </svg>
                            Back
                        </a>
                        {{-- <button data-route="{{ route('admin.forms.bulk_delete') }}" type="button" id="bulk-delete-btn" class="btn btn-danger" disabled>Delete Selected</button> --}}
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
                                        <select name="limit" onchange="updateData(this)" data-route="">
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
                                            <input type="text" class="form-control form-control-sm"
                                                aria-label="Search Forms" name="q" value="{{ request()->q }}">
                                            <input type="hidden" name="limit" id="limitInput"
                                                value="{{ request()->limit }}">
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="table-responsive">
                            @php
                                // Collect unique keys from all submissions for the headers
                                $keys = collect($submissions->items())
                                    ->filter(fn($submission) => is_array($submission->data))
                                    ->flatMap(fn($submission) => array_keys($submission->data))
                                    ->unique();
                            @endphp
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        @foreach ($keys as $key)
                                            <th>{{ ucfirst($key) }}</th>
                                        @endforeach
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($submissions as $submission)
                                        <tr>
                                            @foreach ($keys as $key)
                                                <td>{{ $submission->data[$key] ?? '' }}</td>
                                            @endforeach
                                            <td>
                                                
                                                <!-- Example action buttons -->
                                                {{-- <a href="{{ route('admin.forms.submissions.show', ['form' => $submission->form_id, 'submission' => $submission->id]) }}"
                                                    class="btn btn-sm btn-primary">View</a> --}}
                                                <form onsubmit="return confirmDelete(event, this)" action="{{ route('admin.forms.submissions.destroy', ['form' => $submission->form_id, 'submission' => $submission->id]) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td class="text-center">No Submissions!</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $submissions->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
