@extends('layouts.master') 
@section('breadcrumbs')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item" aria-current="page">Announcements</li>
  </ol>
</nav>
@endsection
 
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header card-header-primary">
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
                </button> @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </div>
        </div>
        @endif @if(session('status'))
        <div class="alert alert-success text-default">
          <div class="container">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="material-icons">clear</i></span>
              </button>
            <b>{{ session()->get('status') }}!</b>
          </div>
        </div>
        @endif @if(auth()->user()->hasRole(['admin', 'faculty']))
        <div class="card">
          <div class="card-body">
            <h4 class="card-title text-primary">Post Announcement</h4>
            <form method="POST" action="{{ route('announcements.store') }}">
              @csrf
              <div class="row">
                <div class="col-md-12">
                  <input type="hidden" name="announcement_id" value="{{ $announcement ? $announcement->id : '' }}">
                  <div class="form-group bmd-form-group {{ $errors->has('title') ? ' has-danger' : '' }}">
                    <label class="bmd-label-floating">Title *</label>
                    <input type="text" class="form-control" name="title" value="{{ $announcement ? $announcement->title : old('title') }}" required/>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">Content *</label>
                    <textarea class="form-control" rows="2" name="content" required>{{ $announcement ? $announcement->content : '' }}</textarea>
                  </div>
                </div>
              </div>
              <div class="col-md-12 text-right">
                @if($announcement) <a href="{{ route('announcements.index') }}" class="btn btn-sm btn-warning">Cancel </a>                @endif
                <button type="submit" class="btn btn-sm btn-warning">Submit </button>
              </div>
            </form>
          </div>
        </div>

        <div class="col-md-12 padding p-1"></div>
        @endif @foreach($announcements as $announcement)
        <div class="bd-example">
          <div class="card">
            <div class="card-header card-header-primary">
              @if(auth()->user()->hasRole(['admin', 'faculty']))
              <span class="actions float-right pt-2">
                @if($announcement->isOwner() || auth()->user()->hasRole('admin'))
                <a href="{{ route('announcements.destroy', $announcement->id) }}" class="text-white" onclick="event.preventDefault(); confirm('Are you sure you want to delete?') ? document.getElementById('delete-form').submit() : '' ">
                    <i class="material-icons" style="font-size: 18px;">delete</i>
                  </a>
                  <form id="delete-form" action="{{ route('announcements.destroy', $announcement->id) }}" method="POST"  style="display: none;">
                      @csrf
                      {{ method_field('DELETE') }}
                  </form>
                @endif
                @if($announcement && $announcement->isOwner())
                  <a href="{{ route('announcements.edit', $announcement->id) }}" class="text-white">
                    <i class="material-icons" style="font-size: 18px;">edit</i>
                  </a>
                @endif
              </span> @endif
              <h4 class="card-title">{{ $announcement->title }}</h4>
            </div>
            <div class="card-body">
              <div class="card-stats">
                <div class="author">
                  <a href="#">
                      <span class="text-warning">{{ $announcement->user->fullname() }}, {{ ucfirst( $announcement->user->roles->first()->name) }}  ·  {{ $announcement->created_at->diffForHumans() }}</span>
                    </a>
                </div>
                <div class="stats ml-auto">
                  <form id="like-form{{ $announcement->id }}" action="{{ route('announcements.likes.store', $announcement->id) }}" method="POST"
                    onsubmit="return confirm('?');" style="display: none;">
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
                    <p class="text-primary">{{ $comment->user->fullname() }}, {{ ucfirst($comment->user->roles->first()->name) }} · {{ $comment->created_at->diffForHumans()
                      }}
                    </p>
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