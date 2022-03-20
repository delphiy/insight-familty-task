@extends('layouts.app')

@section('content')
    <section class="news pt-0">
        <div class="container mt-md-5">
            <h2 class="mx-4 my-0 text-center mb-3">Useful Articles</h2>
            <ul class="row list-unstyled">
                @foreach($data['articles'] as $article)
                        <li class="col-12">
                            <div class="image-block-inner">
                                <img src="{{ $article->image_url }}" class="w-50">
                                <span class="hp-posts-cat d-block">{{ $article->date }}</span>
                                <h4 class="mt-3">{{ $article->title }}</h4>
                                <a href="{{ $article->original_url }}" class="read-more" target="_blank">Read more ></a>
                            </div>
                        </li>
                @endforeach
            </ul>
            {{ $data['links'] }}
        </div>
    </section>
@endsection


