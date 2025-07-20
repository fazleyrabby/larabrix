@extends('admin.layouts.app')
@section('title', 'Crud Sort')
@push('styles')
    <style>
    .nested-sortable {
        /* padding-left: 25px; */
        /* min-height: 40px; */
        border-left: 2px dashed transparent;
        /* margin-bottom: 5px; */
        background-color: #fafafa;
        transition: background 0.2s ease;
    }

    .nested-sortable.drop-target {
        border-left-color: #1890ff;
        background-color: #e6f7ff;
    }

    .drop-target {
        background-color: #e6f7ff !important;
        border-left-color: #1890ff !important;
    }
    </style>
@endpush
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Menu Tree
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('admin.menus.index', ['type' => request()->get('type')]) }}" class="btn btn-danger">
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
                    <h3 class="card-title">Re-order Menu</h3>
                </div>
                <div class="card-body">
                    <div class="list-group nested-sortable" data-parent-id="0">
                        @include('admin.menus.menu-item', ['menus' => $menus, 'parentId' => 0])
                    </div>
                </div>
                <div class="card-footer">
                    <form id="menuForm" action="{{ route('admin.menus.save') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ json_encode($menuWithoutChildren) }}" name="menu_structure" id="menuStructureInput">
                        <button type="submit" class="btn btn-primary" id="save">Save</button>
                    </form>
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
    function getNestedMenuStructure(container) {
        const items = [];
        // const children = Array.from(container.children).filter(el => el.classList.contains('list-group-item'));
        Array.from(container.children).forEach((child, index) => {
            if (!child.classList.contains('list-group-item')) return;
            const id = parseInt(child.dataset.id);
            const parentId = parseInt(container.dataset.parentId || 0);

            items.push({
                id: id,
                parent_id: parentId,
                position: index,
            });

            // Find direct nested sortable container
            const nestedContainer = child.querySelector(':scope > .nested-sortable');
            if (nestedContainer) {
                items.push(...getNestedMenuStructure(nestedContainer));
            }
        });
        return items;
    }

    function clearDropTargets() {
        document.querySelectorAll('.drop-target').forEach(el => el.classList.remove('drop-target'));
    }

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll('.nested-sortable').forEach(initSortable);
    });

    function initSortable(container){
        new Sortable(container, {
            group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.5,
            fallbackTolerance: 10,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            onStart: clearDropTargets(),
            onMove: evt => {
                clearDropTargets()
                const hoveredSortable = evt.to;
                if (hoveredSortable && hoveredSortable.classList.contains('nested-sortable')) {
                    hoveredSortable.classList.add('drop-target');
                }
            },
            onEnd: () => {
                clearDropTargets();
                const rootContainer = document.querySelector('[data-parent-id]');
                const structure = getNestedMenuStructure(rootContainer);
                structure.map((item, idx) => {
                    item.position = idx
                    return item
                })
                document.getElementById('menuStructureInput').value = JSON.stringify(structure);
            }
        });
    }
</script>
@endpush
