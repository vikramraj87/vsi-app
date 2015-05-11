@extends('app')

@section('content')
        @if(isset($parents))
            <ol class="breadcrumb">
                <li><a href="/categories">Categories</a></li>
            @foreach($parents as $cat)
                <li><a href="/categories/{{ $cat['id'] }}">{{ $cat['category'] }}</a></li>
            @endforeach
                <li><a href="/categories/{{ $category->id }}">{{ $category->category }}</a></li>
            </ol>
        @endif
        <table class="table" id="categories-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($subCategories as $cat)
                @if($edit != $cat->id)
                <tr>
                    <td><a href="/categories/{{ $cat->id }}">{{ $cat->category }}</a></td>
                    <td><a href="?edit={{ $cat->id }}">Edit</a></td>
                    <td>
                        <a href="/categories/delete/{{ $cat->id }}" class="category-remove" data-id="{{ $cat->id }}">Remove</a>
                    </td>
                </tr>
                @else
                <form role="form" class="form-inline" action="/categories" method="post">
                    <tr>
                        <td>
                            <input type="text" class="form-control" name="category" value="{{ $cat->category }}"/>
                        </td>
                        <td>
                            <button type="submit" class="form-control btn btn-primary">
                                Update
                            </button>
                        </td>
                        <td>
                            <a class="btn btn-primary" href="?edit=0">
                                Cancel
                            </a>
                            <input type="hidden" name="parent_id" value="{{ $category->id or 0 }}"/>
                            <input type="hidden" name="id" value="{{ $cat->id }}"/>
                            <input type="hidden" name="_method" value="PUT"/>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </td>
                    </tr>
                </form>
                @endif
            @endforeach
            @if($edit === 0)
                <form role="form" class="form-inline" action="/categories" method="post">
                <tr>
                    <td>
                        <input type="text" class="form-control" name="category"/>
                    </td>
                    <td>
                        <button type="submit" class="form-control btn btn-primary">
                            Add
                        </button>
                    </td>
                    <td>
                        <input type="hidden" name="parent_id" value="{{ $category->id or 0 }}"/>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </td>
                </tr>
                </form>
            @endif
            </tbody>
        </table>
@endsection