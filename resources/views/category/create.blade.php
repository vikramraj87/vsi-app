@extends('app')

@section('content')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">New category</div>
                    <div class="panel-body">
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

                            @if($errors->has('category'))
                            <div class="form-group has-error">
                                <label class="col-md-4 control-label">Category name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="category" value="{{ old('category')}}">
                                    <span class="help-block">{{ $errors->first('category') }}</span>
                                </div>
                            </div>
                            @else
                            <div class="form-group">
                                <label class="col-md-4 control-label">Category name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="category" value="{{ old('category')}}">
                                </div>
                            </div>
                            @endif

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