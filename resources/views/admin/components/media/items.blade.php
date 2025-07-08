
@php $ajax = request()->ajax() @endphp
<form class="delete_form row g-2 media-container"
    action="{{ route('admin.media.delete') }}"
    method="post">
    @csrf
@foreach ($media as $index => $item)
<div class="col-md-2 mb-3 image-container">
        <label class="form-imagecheck" style="
            @if ($ajax)
                height: 200px;
            @else
                height: 100%;
            @endif">
            <input name="ids[]"
                type="checkbox" value="{{ $item->id }}"
                class="form-imagecheck-input"
                data-url="{{ Storage::url($item->url) }}"
            />
            <span class="form-imagecheck-figure h-100">
                <img src="{{ Storage::url($item->url) }}"
                        alt="A visit to the bookstore"
                        class="form-imagecheck-image h-100 object-fit-cover" @if($ajax) width="350" @endif/>
            </span>

        </label>

        @if (!$ajax)
        <span class="view btn btn-primary"
            data-created-at="{{ Carbon\Carbon::parse($item->created_at)->isoFormat('LLL') }}"
            data-preview-url="{{ Storage::url($item->url) }}"
            data-url="{{ $item->url }}">View
        </span>
        @endif

        {{-- <a data-fslightbox="gallery" href="{{ asset('storage/'. $value) }}">

        </a> --}}


</div>
@endforeach

</form>
