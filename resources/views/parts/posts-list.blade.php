<h2>{{ $title }}</h2>

@isset($category)
<div class="cat-desc mb-5">
    <img class="w-25 h-25 float-start d-block me-3 mb-3" src="{{ $category->getImage() ?? '' }}" alt="{{ $category->title ?? '' }}">
    <p class="card-text">{{ $category->description ?? '' }}</p>
</div>
@endisset

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
    </ol>
</nav>
@foreach($posts as $post)
    <div class="card mb-5">
        <img
            src="{{ $post->getImage() }}"
            class="card-img-top" alt="{{ $post->title }}">
        <div class="card-body">
            {{--                                <a href="#"><span class="badge bg-primary">{{ $post->category->title ?? '' }}</span></a>--}}
            <span class="post-date">{{ $post->dateAsCarbon }}</span>
            <h5 class="card-title">{{ $post->title }}</h5>
            @include('parts.likes')
            <a href="{{ route('show.post', $post->slug) }}" class="btn btn-primary">Далее</a>
            <p><i class="far fa-eye"></i> <span class="badge bg-primary">{{ $post->view_count }}</span></p>
        </div>
    </div>
@endforeach
