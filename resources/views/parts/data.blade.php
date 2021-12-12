{{--@if($posts->total() > 0)--}}
    @foreach($posts as $k => $post)

        <div class="card mb-5" data-post="{{ $k }}">
            <img src="{{ $post->getImage() }}"
                 class="card-img-top" alt="{{ $post->title }}">
            <div class="card-body">
                <span class="post-date">{{ $post->dateAsCarbon }}</span>
                <h5 class="card-title">{{ $post->title }}</h5>
                @include('parts.likes')
                <a href="{{ route('show.post', $post->slug) }}" class="btn btn-primary">Далее</a>
                <p><i class="far fa-eye"></i> <span class="badge bg-primary">{{ $post->view_count }}</span></p>
            </div>
        </div>
    @endforeach
{{--@endif--}}