{{-- <section class="hero" style="background-image: url('{{ $data['background_image'] }}')">
    <h1>{{ $data['title'] }}</h1>
    <p>{{ $data['subtitle'] }}</p>
    <a href="{{ $data['button_url'] }}" class="btn">
        {{ $data['button_text'] }}
    </a>
</section> --}}


{{-- <div class="px-4 py-5 my-5 text-center"> 
    <h1 class="display-5 fw-bold text-body-emphasis">{{ $data['title'] }}</h1>
    <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">{{ $data['subtitle'] }}</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center"> 
            <a href="{{ $data['button_url'] }}" class="btn btn-primary btn-lg px-4 gap-3">{{ $data['button_text'] }}</a> 
                <button type="button"  class="btn btn-outline-secondary btn-lg px-4">Secondary</button> </div> 
    </div>
</div> --}}


<section class="bg-white lg:grid lg:h-[400px] lg:place-content-center">
  <div class="mx-auto w-screen max-w-screen-xl px-4 h-[100px] sm:px-6 lg:px-8">
    <div class="mx-auto max-w-prose text-center">
      <h1 class="text-4xl font-bold text-gray-900 sm:text-5xl">
        {{ $data['title'] }}
        {{-- <strong class="text-indigo-600"> increase </strong> --}}
        
      </h1>

      <p class="mt-4 text-base text-pretty text-gray-700 sm:text-lg/relaxed">
        {{ $data['subtitle'] }}
      </p>

      <div class="mt-4 flex justify-center gap-4 sm:mt-6">
        <a
          class="inline-block rounded border border-indigo-600 bg-indigo-600 px-5 py-3 font-medium text-white shadow-sm transition-colors hover:bg-indigo-700"
          href="{{ $data['button_url'] }}"
        >
          {{ $data['button_text'] }}
        </a>
      </div>
    </div>
  </div>
</section>