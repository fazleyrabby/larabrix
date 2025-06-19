@foreach ($menus as $menu)
    <div class="list-group-item" data-id="{{ $menu->id }}">
        {{ $menu->title }}

        {{-- Always render nested container for drop target --}}
        <div class="list-group nested-sortable" data-parent-id="{{ $menu->id }}">
            @includeWhen($menu->childrenRecursive->isNotEmpty(), 'admin.menus.menu-item', [
                'menus' => $menu->childrenRecursive,
                'parentId' => $menu->id
            ])
        </div>
    </div>
@endforeach
