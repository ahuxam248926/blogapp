@extends('layouts.app')
<style>
    .display-comment .display-comment {
        margin-left: 40px
    }
</style>
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <img class="card-img-top" src="{{ url('storage/cover_images/'.$post->cover_image) }}"  alt="" style="width:300px;height:300px;">
                    <p><b>{{ $post->title }}</b></p>
                    <p>
                        {{ $post->body }}
                    </p>
                    <p> Created BY: <b>{{$post->user->name}}</b></p>
  
                        

                    <hr />
                    @if(!Auth::guest())
                    @if(Auth::user()->id == $post->user_id)
                    <form action="{{ route('post.destroy', $post->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                       </form>
                    @endif
                    @endif
                    @if(!Auth::guest())
                    <br>
                    <h4>Comments</h4>
                    @include('partials._comment_replies', ['comments' => $post->comments, 'post_id' => $post->id])
                    <hr />
                    <h4>Add comment</h4>
                    <form method="post" action="{{ route('comment.add') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="comment_body" class="form-control" />
                            <input type="hidden" name="post_id" value="{{ $post->id }}" />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-warning" value="Add Comment" />
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection