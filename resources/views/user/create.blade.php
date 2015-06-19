@extends('app')

@section('content')
<div id="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">New User</h3>
                    </div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form class="form" role="form" action="/user/store" method="post">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input class="form-control" type="text" name="name"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <input class="form-control" type="email" name="email"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Password</label>
                                <input class="form-control" type="password" name="password"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Confirm Password</label>
                                <input class="form-control" type="password" name="password_confirmation"/>
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary" type="submit">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

