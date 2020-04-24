@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Posts Vue.js</div>

                <div class="card-body">
                    @foreach($posts as $post)
                        <div class="card mb-3">
                            <div class="card-header">{{ $post->title }}</div>
                            <div class="card-body">
                                <p class="card-text">{{ $post->full_text }}</p>
                                <hr />
                                <ratings
                                    :post-id="{{ $post->id }}"
                                    status="{{ auth()->check() && $post->ratings->count() ? $post->ratings->first()->pivot->type : '' }}"
                                    :likes="{{ $post->likes_count }}"
                                    :dislikes="{{ $post->dislikes_count }}"
                                ></ratings>
                            </div>
                        </div>
                    @endforeach
                </div>
            </hr>
        </div>
    </div>
</div>
@endsection
