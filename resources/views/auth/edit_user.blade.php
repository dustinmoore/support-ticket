@extends('layouts.app')

@section('title', 'Create New User')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit User</div>

                    <div class="panel-body">
                        @include('includes.flash')
                        {{ Form::open(array('url' => '/admin/user/' . $user->id)) }}
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                {{ Form::label('name', 'Name', ['class' => 'col-md-4 control-label extra-padding']) }}
                                <div class="col-md-6">
                                    {{ Form::text('name', $user->name, ['class' => 'form-control extra-padding', 'required' => 'required']) }}
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {{ Form::label('email', 'Email', ['class' => 'col-md-4 control-label extra-padding']) }}
                                <div class="col-md-6">
                                    {{ Form::text('email', $user->email, ['class' => 'form-control extra-padding', 'required' => 'required']) }}
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                {{ Form::label('password', 'Password', ['class' => 'col-md-4 control-label extra-padding']) }}
                                <div class="col-md-6">
                                    {{ Form::text('password', null, ['class' => 'form-control extra-padding']) }}

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('password-confirm', 'Confirm Password', ['class' => 'col-md-4 control-label extra-padding']) }}
                                <div class="col-md-6">
                                    {{ Form::text('password-confirm', null, ['class' => 'form-control extra-padding']) }}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('is_admin') ? ' has-error' : '' }}">
                                {{ Form::label('is_admin', 'Is Admin?', ['class' => 'col-md-4 control-label extra-padding']) }}
                                <div class="col-md-6">
                                    {{ Form::checkbox('is_admin', 1, ($user->is_admin ? true : false), ['class' => 'form-control extra-padding']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-warning">
                                        Update
                                    </button>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
