@push('styles')

<style>
    .modal-backdrop {
    position: fixed;
    top: 0; left: 0;
    width: 100vw; height: 100vh;
    background-color: rgba(0,0,0,0.5);
    z-index: 1040; /* should be lower than modal's z-index but above page content */
    }

    .modal.show {
    z-index: 1050; /* make sure modal is above backdrop */
    }
</style>
    
@endpush

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="{{ $id }}Label">{{ $title ?? '' }}</h5>
        <button type="button" class="btn-close" data-modal-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        {!! $slot ?? '' !!}
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-modal-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>

    </div>
  </div>
</div>