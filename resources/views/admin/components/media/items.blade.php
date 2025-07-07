
<form class="delete_form row g-2 media-container"
    action="{{ route('admin.media.delete') }}"
    method="post">
    @csrf
@foreach ($media as $index => $item)
<div class="col-md-3 mb-3 image-container">
        <label class="form-imagecheck w-100">
            <input name="ids[]"
                type="checkbox" value="{{ $item->id }}"
                class="form-imagecheck-input"
                data-url="{{ Storage::url($item->url) }}"
            />
            <span class="form-imagecheck-figure">
                <img src="{{ Storage::url($item->url) }}"
                        alt="A visit to the bookstore"
                        class="form-imagecheck-image"
                        width="400" />
            </span>

        </label>
        <span class="view btn btn-primary"
            data-created-at="{{ Carbon\Carbon::parse($item->created_at)->isoFormat('LLL') }}"
            data-preview-url="{{ Storage::url($item->url) }}"
            data-url="{{ $item->url }}">View
        </span>
        {{-- <a data-fslightbox="gallery" href="{{ asset('storage/'. $value) }}">

        </a> --}}


</div>
@endforeach

</form>
