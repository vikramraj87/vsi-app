<?php $catId = is_null($category) ? 0 : $category->id; ?>
<?php $title = is_null($category) ? 'Categories' : $category->category; ?>

@extends('app')

@section('title', $title)

@section('content')

        {{-- Breadcrumbs for categories --}}
            <ol class="breadcrumb">
                <li><a href="{{ route('category-index') }}">Categories</a></li>
            @foreach($parents as $cat)
                <li><a href="{{ route('category-index', $cat->id) }}">{{ $cat->category }}</a></li>
            @endforeach
            @if(isset($category))
                <li><a href="{{ route('category-index', $category->id) }}">{{ $category->category }}</a></li>
            @endif
            </ol>


        {{-- Table for displaying the categories --}}
        <table class="table" id="categories-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>{{-- Column for edit button --}}</th>

                </tr>
            </thead>
            <tbody>
            @foreach($subCategories as $cat)
                @if($edit != $cat->id)
                <tr>
                    <td><a href="{{ route('category-index', $cat->id) }}">{{ $cat->category }}</a></td>
                    <td><a href="{{ route('category-edit', [$catId, $cat->id]) }}" class="btn btn-primary">Edit</a></td>
                </tr>
                @else

                {{-- Display edit form when category id and edit id are same --}}
                <form role="form" class="form-inline" action="{{ route('category-update') }}" method="post">
                    <tr>
                        <td>
                            <?php
                                $categoryName = $cat->category;
                                $oldCategoryName = old('category');
                                if(!is_null($oldCategoryName)) {
                                    $categoryName = $oldCategoryName;
                                }
                            ?>
                            @if($errors->has('category'))
                            <div class="form-group has-error">
                                <input type="text" class="form-control" name="category" value="{{{ $categoryName }}}"/>
                                <span class="help-block">{{ $errors->first('category') }}</span>
                            </div>
                            @else
                            <div class="form-group">
                                <input type="text" class="form-control" name="category" value="{{{ $categoryName }}}"/>
                            </div>
                            @endif
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('category-index', $catId) }}">
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

            {{-- Display add category form only when there is no category to edit --}}
            @if($edit === 0)
                <form role="form" class="form-inline" action="{{ route('category-store') }}" method="post">
                <tr>
                    <td>
                        <input type="text" class="form-control" name="category"/>
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </td>
                    <td>
                        <input type="hidden" name="parent_id" value="{{ $catId }}"/>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </td>
                </tr>
                </form>
            @endif
            </tbody>
        </table>
@endsection