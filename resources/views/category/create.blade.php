@extends('app')

@section('content')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">New category</div>
                    <div class="panel-body">
                        @include('errors.form');

                        <form class="form-horizontal" role="form" method="post" action="{{ url('categories')  }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Parent</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="parent_id">

                                        @foreach($categories as $id => $category)
                                        <option value="{{ $id }}">{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Category name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="category" value="{{ old('category')}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection