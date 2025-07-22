{{-- <section class="hero" style="background-image: url('{{ $data['background_image'] }}')">
    <h1>{{ $data['title'] }}</h1>
    <p>{{ $data['subtitle'] }}</p>
    <a href="{{ $data['button_url'] }}" class="btn">
        {{ $data['button_text'] }}
    </a>
</section> --}}


<div class="px-4 py-5 my-5 text-center"> 
    <h1 class="display-5 fw-bold text-body-emphasis">{{ $data['title'] }}</h1>
    <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">{{ $data['subtitle'] }}</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center"> 
            <a href="{{ $data['button_url'] }}" class="btn btn-primary btn-lg px-4 gap-3">{{ $data['button_text'] }}</a> 
                {{-- <button type="button"  class="btn btn-outline-secondary btn-lg px-4">Secondary</button> </div>  --}}
    </div>
</div>
