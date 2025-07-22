<section class="py-5">
    <div class="container">
        @if (!empty($data['heading']))
            <h2 class="text-center mb-5">{{ $data['heading'] }}</h2>
        @endif

        <div class="row g-4 row-cols-1 row-cols-lg-3 justify-content-center text-center">
            @foreach ($data['items'] ?? [] as $item)
                <div class="col d-flex flex-column align-items-center">
                    <div>
                        <h3 class="fs-4 text-body-emphasis">{{ $item['title'] ?? 'Featured title' }}</h3>
                        <p>{{ $item['description'] ?? 'No description available.' }}</p>
                        <a href="#" class="btn btn-primary">Primary button</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
