@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        @foreach($posts as $post)
    <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="{{ url('storage/cover_images/'.$post->cover_image) }}"  alt="" style="width:128px;height:128px;">
        <div class="card-body">
          <h5 class="card-title">{{ $post->title }}</h5>
          <p class="card-text">{{ $post->body }}</p>
          <a href="{{ route('post.show', $post->id) }}" class="btn btn-primary">ReadMore</a>
        </div>
      </div>
      @endforeach
    </div>
    
</div>


@endsection

