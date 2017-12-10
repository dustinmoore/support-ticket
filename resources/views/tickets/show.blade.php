@extends('layouts.app')

@section('title', $ticket->title)

@section('content')
    @if ($ticket->status == 'Open')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="{{ url('/close_ticket/' . $ticket->ticket_id) }}"
                          method="POST">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-danger">Close Ticket</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if (Auth::user()->is_admin == 1 && $ticket->status == 'Closed')
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="{{ url('admin/open_ticket/' . $ticket->ticket_id) }}"
                              method="POST">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-success">Re-Open</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                     <h4>{{ $ticket->title }}</h4>
                </div>

                <div class="panel-body">
                    @include('includes.flash')

                    <div class="ticket-info">
                        <p><b>Ticket #:</b> {{ $ticket->ticket_id }}</p>
                        <p>Category: {{ $category->name }}</p>
                        <p>
                            @if ($ticket->priority === 'low')
                               Priority: <span class="label label-info">{{ $ticket->priority }}</span>
                            @elseif ($ticket->priority === 'medium')
                                Priority: <span class="label label-warning">{{ $ticket->priority }}</span>
                            @elseif ($ticket->priority === 'high')
                                Priority: <span class="label label-danger">{{ $ticket->priority }}</span>
                            @endif
                        </p>
                        <p>
                            @if ($ticket->status === 'Open')
                                Status: <span class="label label-success">{{ $ticket->status }}</span>
                            @else
                                Status: <span class="label label-danger">{{ $ticket->status }}</span>
                            @endif
                        </p>
                        <p>Created: {{ $ticket->created_at->diffForHumans() }}</p>
                        <hr>
                        <p>{{ $ticket->message }}</p>
                    </div>

                    <hr>

                    <div class="comments">
                        @foreach ($comments as $comment)
                            <div class="panel panel-@if($ticket->user->id === $comment->user_id) {{"default"}}@else{{"success"}}@endif">
                                <div class="panel panel-heading">
                                    {{ $comment->user->name }}
                                    <span class="pull-right">{{ $comment->created_at->format('Y-m-d') }}</span>
                                </div>

                                <div class="panel panel-body">
                                    {{ $comment->comment }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <h4>Reply to ticket</h4>
                    <div class="comment-form">
                        <form action="{{ url('comment') }}" method="POST" class="form">
                            {!! csrf_field() !!}

                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                            <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                <textarea rows="10" id="comment" class="form-control" name="comment"></textarea>

                                @if ($errors->has('comment'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Reply</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection