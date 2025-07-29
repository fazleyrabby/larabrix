<section
    id="hero-section-{{ $index }}"
    class="relative lg:grid lg:h-[400px] h-screen place-content-center bg-center bg-cover bg-no-repeat"
    style="background-image: url('{{ asset($data['background_image']['value'] ?? '') }}');"
>
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50"></div>

    <!-- Content -->
    <div class="relative z-10 mx-auto w-screen max-w-screen-xl px-4 h-[100px] sm:px-6 lg:px-8 text-center text-white">
        <h1 class="text-4xl font-bold sm:text-5xl">
            {{ $data['title']['value'] ?? '' }}
        </h1>

        <p class="mt-4 text-base text-pretty sm:text-lg/relaxed">
            {!! $data['subtitle']['value'] ?? '' !!}
        </p>

        <div class="mt-4 flex justify-center gap-4 sm:mt-6">
            <a
                class="inline-block rounded border border-indigo-600 bg-indigo-600 px-5 py-3 font-medium text-white shadow-sm transition-colors hover:bg-indigo-700"
                href="{{ $data['button_url']['value'] ?? '' }}"
            >
                {{ $data['button_text']['value'] ?? '' }}
            </a>
        </div>
    </div>
</section>