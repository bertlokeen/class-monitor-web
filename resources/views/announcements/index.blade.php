@extends('layouts.master')

@section('header', 'Faculties')

@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-warning">
      <h4 class="card-title mt-0">Announcements </h4>
      <p class="card-category"> </p>
    </div>
    <div class="card-body">
      <div class="col-md-10 m-auto">
        @if($errors->any())
            <div class="alert alert-danger">
              <div class="container">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true"><i class="material-icons">clear</i></span>
                </button>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </div>
            </div>
          @endif

        @if(session('status'))
          <div class="alert alert-success text-default">
            <div class="container">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="material-icons">clear</i></span>
              </button>
              <b>Announcement posted successfully!</b>
            </div>
          </div>
          @endif
        <div class="card">
          <div class="card-body">
            <h4 class="card-title text-primary">Post Announcement</h4>
            <form method="POST" action="{{ route('announcements.store') }}">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group bmd-form-group {{ $errors->has('title') ? ' has-danger' : '' }}">
                  <label class="bmd-label-floating">Title *</label>
                  <input type="text" class="form-control" name="title" value="{{ old('title') }}" required/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating"> Content *</label>
                    <textarea class="form-control" rows="2" name="content" value="{{ old('content') }}" required></textarea>
                </div>
              </div>
            </div>
            <div class="col-md-12 text-right">
              <button type="submit" class="btn btn-sm btn-warning">Post </button>
            </div>
            </form>
          </div>
        </div>

        <div class="col-md-12 padding p-1"></div>

        @foreach($announcements as $announcement)
        <div class="bd-example">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">{{ $announcement->title }}</h4>
              <i class="material-icons" style="float: right; margin-top: -30px; font-size: 16px;">settings</i>
            </div>
            <div class="card-body">
              <p>{{ $announcement->content }}</p>
              <div class="card-stats">
                <div class="author">
                    <a href="#">
                      <span class="text-warning">{{ $announcement->user->fullname() }}, {{ ucfirst(request()->user()->roles->first()->name) }}  ·  {{ $announcement->created_at->diffForHumans() }}</span>
                    </a>
                </div>
                <div class="stats ml-auto">
                  <form id="like-form{{ $announcement->id }}" action="{{ route('announcements.likes.store', $announcement->id) }}" method="POST" onsubmit="return confirm('?');" style="display: none;">
                    @csrf
                  </form>
                  <a class="pr-1" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('like-form{{ $announcement->id }}').submit();">
                    <i class="material-icons pr-1 {{ $announcement->liked() ? 'text-primary' : 'text-warning' }}">favorite</i>{{ $announcement->likes->count() }}
                  </a> ·
                  <a data-toggle="collapse" href="#comments{{ $announcement->id }}" role="button" aria-expanded="false" aria-controls="comments">
                      <i class="material-icons pr-1 {{ $announcement->commented() ? 'text-primary' : 'text-warning' }}">comment</i>{{ $announcement->comments->count() }}
                  </a>
                </div>
              </div>
              <div class="row collapse" id="comments{{ $announcement->id }}">
                <div class="col-md-12 comments pt-4 mt-4" style="border: 1px solid #962eaf; border-radius: 4px;">
                  @foreach($announcement->comments as $comment)
                  <div class="comment p-1 m-1">
                    <p class="text-primary">{{ $comment->user->fullname() }}, {{ ucfirst($comment->user->roles->first()->name) }} · {{ $comment->created_at->diffForHumans() }}</p>
                    <p>{{ $comment->body }}</p>
                  </div>
                  @endforeach
                </div>
              </div>
              <div class="write-comment">
                <form method="POST" action="{{ route('announcements.comment.store', $announcement->id) }}">
                  @csrf
                  <div class="row">
                    <div class="col-md-10">
                      <div class="form-group bmd-form-group {{ $errors->has('comment') ? ' has-danger' : '' }}">
                        <label class="bmd-label-floating">Write a comment </label>
                        <input type="text" class="form-control" name="comment" value="{{ old('title') }}" required/>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group bmd-form-group">
                        <button type="submit" class="btn btn-sm btn-warning">Submit</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
           </div>
        </div>
        @endforeach
      </div>
      <div class="row" style="float: right">
        {{ $announcements->links() }}
      </div>
    </div>  
  </div>
</div>
@endsection
