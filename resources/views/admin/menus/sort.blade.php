@extends('admin.layouts.app')
@section('title', 'Crud Sort')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Crud
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ url()->previous() }}" class="btn btn-danger">
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
                        <h3 class="card-title">Menu Sorting</h3>
                    </div>
                    <div class="card-body">
                        @php
                        function renderNestedMenu($menus, $level = 1)
                        {
                            echo '<div class="list-group nested-sortable">';
                            foreach ($menus as $menu) {
                                echo '<div class="list-group-item">' . e($menu->title);
                                if ($menu->childrenRecursive->isNotEmpty()) {
                                    renderNestedMenu($menu->childrenRecursive);
                                }
                                echo '</div>';
                            }

                            echo '</div>';
                        }
                        @endphp
                        <div id="nestedDemo" class="list-group col nested-sortable">
                            {!! renderNestedMenu($menus) !!}
                        </div>
                    </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.6/Sortable.min.js" integrity="sha512-csIng5zcB+XpulRUa+ev1zKo7zRNGpEaVfNB9On1no9KYTEY/rLGAEEpvgdw6nim1WdTuihZY1eqZ31K7/fZjw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const nestedSortables = document.querySelectorAll('.nested-sortable');
        nestedSortables.forEach(el => {
            new Sortable(el, {
                group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.5
            });
        });
    });
</script>
@endpush
