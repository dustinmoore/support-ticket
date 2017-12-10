@extends('layouts.app')

@section('title', 'All Tickets')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-ticket"> Tickets</i>
                </div>

                <div class="panel-body">
                    @if ($tickets->isEmpty())
                        <p>There are currently no tickets.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Category</th>
                                <th>Ticket #</th>
                                <th>Title</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>
                                        {{ $ticket->category->name }}
                                    </td>
                                    <td>
                                        #{{ $ticket->ticket_id }}
                                    </td>
                                    <td>
                                        <a href="{{ url('tickets/'. $ticket->ticket_id) }}">
                                            {{ $ticket->title }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($ticket->priority === 'low')
                                            <span class="label label-info">{{ $ticket->priority }}</span>
                                        @elseif ($ticket->priority === 'medium')
                                            <span class="label label-warning">{{ $ticket->priority }}</span>
                                        @elseif ($ticket->priority === 'high')
                                            <span class="label label-danger">{{ $ticket->priority }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($ticket->status === 'Open')
                                            <span class="label label-success">{{ $ticket->status }}</span>
                                        @else
                                            <span class="label label-danger">{{ $ticket->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->updated_at }}</td>

                                    <td>
                                        <form action="{{ url('admin/open_ticket/' . $ticket->ticket_id) }}"
                                              method="POST">
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn btn-success">Re-Open</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $tickets->render() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection