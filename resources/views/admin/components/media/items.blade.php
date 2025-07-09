
@php $isModal = request()->get('type') == 'modal'; @endphp
<form class="delete_form media-container row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-2"
    action="{{ route('admin.media.delete') }}"
    method="post">
    @csrf
@foreach ($media as $index => $item)
        <div class="col image-container">
            <label class="form-imagecheck d-block position-relative w-100 h-100">
                <input name="ids[]"
                    type="checkbox"
                    value="{{ $item->id }}"
                    class="form-imagecheck-input position-absolute top-0 start-0 z-2"
                    data-url="{{ Storage::disk('public')->url($item->url) }}"
                />
                <span class="form-imagecheck-figure d-block overflow-hidden rounded shadow-sm w-100 h-100">
                    <img
                        src="{{ Storage::disk('public')->url($item->url) }}"
                        alt="Media Item"
                        class="form-imagecheck-image w-100 h-100 object-fit-cover"
                        style="max-height: 240px;"
                    />
                </span>
            </label>

            @if (!$isModal)
                <span class="view btn btn-sm btn-primary mt-2"
                    data-created-at="{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('LLL') }}"
                    data-preview-url="{{ Storage::disk('public')->url($item->url) }}"
                    data-url="{{ $item->url }}">
                    View
                </span>
            @endif
        </div>
    @endforeach

</form>
