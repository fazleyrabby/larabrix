@push('styles')
{{-- <style>
    /* Optional: override backdrop or modal styles */
    .modal-backdrop {
        z-index: 1040 !important;
    }
    .modal.show {
        z-index: 1050 !important;
    }
</style> --}}
@endpush

@php $backdrop = $backdrop ?? 'true' @endphp
@php $showFooter = $showFooter ?? 'false' @endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true" data-bs-backdrop="{{ $backdrop }}">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="{{ $id }}Label">{{ $title ?? '' }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        {!! $slot ?? '' !!}
      </div>

      @if ($showFooter == 'true')
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      @endif
      

    </div>
  </div>
</div>