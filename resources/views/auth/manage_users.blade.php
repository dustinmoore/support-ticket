@extends('layouts.app')

@section('title', 'All Users')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="{{ url('/admin/create_user') }}" class="btn btn-success">Create User</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-ticket"> Users</i>
                </div>

                <div class="panel-body">
                    @include('includes.flash')
                    @if ($users->isEmpty())
                        <p>There are currently no active users.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>User</th>
                                <th>User Type</th>
                                <th>Email</th>
                                <th>Created</th>
                                <th>Last Updated</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <a href="{{ url('/admin/user/'. $user->id) }}">
                                           {{ $user->name }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($user->is_admin == 1)
                                            Admin
                                        @else
                                            Standard User
                                        @endif
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        {{ $user->created_at }}
                                    </td>
                                    <td>
                                        {{ $user->updated_at }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $users->render() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection