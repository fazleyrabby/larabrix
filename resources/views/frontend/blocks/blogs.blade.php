<section class="py-5 bg-white">
    <div class="container">
        <h2 class="h3 fw-bold mb-4">{{ $data['heading'] ?? 'Latest Posts' }}</h2>
        <div class="row g-4">
            @foreach($data['posts'] ?? [] as $post)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="{{ $post['url'] }}" class="text-decoration-none text-primary">{{ $post['title'] }}</a>
                            </h5>
                            <p class="card-text text-body-secondary mb-2">{{ $post['excerpt'] }}</p>
                            <p class="mt-auto text-muted small">{{ $post['published_at'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>