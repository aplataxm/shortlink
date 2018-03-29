@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Links</div>

                    <div class="panel-body">
                        @include('flash::message')
                        <form class="form-horizontal" method="POST" action="{{ route('shortened_link.create') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('original_url') ? ' has-error' : '' }}">
                                <label for="original_url" class="col-md-4 control-label">Original URL</label>

                                <div class="col-md-6">
                                    <input id="original_url" type="text" class="form-control" name="original_url"
                                           value="{{ old('original_url') }}" required autofocus>

                                    @if ($errors->has('original_url'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('original_url') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Shorten link
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if (count($links) > 0)
                        <div class="panel-body">
                            <h2>Your shortened links</h2>
                            <div>
                                <ul class="list-group">
                                    @foreach ($links as $key => $link)
                                        <li class="list-group-item">
                                            <span class="text-muted">  #{{ $key + 1 }}: </span>

                                            <span>
                                                <a href="{{ $link->shortened_url }}"
                                                   target="_blank">{{ $link->shortened_url }}</a>
                                            </span>

                                            <small class="text-muted text-center" style="margin-left: 10px">
                                                Leads to <a
                                                        href="{{ $link->original_url }}"
                                                        style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;"
                                                        target="_blank">{{  str_limit($link->original_url, 40) }}</a>
                                            </small>

                                            <button class="btn btn-xs btn-danger pull-right" style="margin-left: 10px"
                                                    onclick="event.preventDefault();
                                                            document.getElementById('delete-link-{{ $link->id }}').submit();">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>

                                            <small class="text-muted pull-right">
                                                Followed {{ $link->views_count }} times
                                            </small>

                                            <form id="delete-link-{{ $link->id }}"
                                                  action="{{ route('shortened_link.delete', ['link_id' => $link->id]) }}"
                                                  method="POST" class="hidden">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
