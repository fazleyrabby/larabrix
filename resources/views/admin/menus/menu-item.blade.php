<div class="list-group nested-sortable" data-parent-id="{{ $parentId ?? 0 }}">
    @foreach ($menus as $menu)
        <div class="list-group-item" data-id="{{ $menu->id }}">
            {{ $menu->title }} - Parent: {{ $parentId ?? 0 }} - ID: {{ $menu->id }} - Position: {{ $menu->position }}

            {{-- Always render nested container for drop target --}}
            <div class="list-group nested-sortable" data-parent-id="{{ $menu->id }}">
                @includeWhen($menu->childrenRecursive->isNotEmpty(), 'admin.menus.menu-item', [
                    'menus' => $menu->childrenRecursive,
                    'parentId' => $menu->id
                ])
            </div>
        </div>
    @endforeach
</div>
