<?php $catId = is_null($category) ? 0 : $category->id; ?>
<?php $title = is_null($category) ? 'Cases' : $category->category . ' cases'; ?>
@extends('app')

@section('title', $title)

@section('content')
        {{-- Breadcrumbs for categories --}}
            <ol class="breadcrumb">
                <li><a href="{{ route('case-index') }}">Cases</a></li>
            @foreach($parents as $cat)
                <li><a href="{{ route('case-category', $cat->id) }}">{{ $cat->category }}</a></li>
            @endforeach
            @if(isset($category))
                <li><a href="{{ route('case-category', $category->id) }}">{{ $category->category }}</a></li>
            @endif
            </ol>

        <div class="row">
            {{-- Side navigation for sub-categories --}}
            <div class="col-md-3">
                <ul class="nav">
                @forelse($subCategories as $cat)
                    <li><a href="{{ route('case-category', $cat->id) }}">{{ $cat->category }}</a></li>
                @empty
                {{-- Display form for adding a case if no subcategories exist --}}
                    <h3>Add new case</h3>
                    <form role="form" action="{{ url('cases') }}" method="post">
                        {{-- CSRF token --}}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        {{-- Clinical data text field --}}
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Clinical data" name="clinical_data"/>
                        </div>

                        {{-- Virtual slide providers select field --}}
                        <div class="form-group">
                            <select class="form-control" name="virtual_slide_provider_id">
                            @foreach($providers as $provider)
                                @if($provider->id == old('provider_id'))
                                <option value="{{ $provider->id }}" selected>{{ $provider->name }}</option>
                                @else
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>

                        {{-- Hidden field for current category id --}}
                        <input name="category_id" type="hidden" value="{{ $category->id }}"/>

                        {{-- Fieldset to add slides  --}}
                        <div id="slides">
                            <fieldset>
                                <legend>Virtual slide</legend>

                                {{-- Url of the virtual slide --}}
                                @if($errors->has('url.0'))
                                <div class="form-group has-error">
                                    <input type="text" class="form-control" placeholder="Url" name="url[]" value="{{ old('url.0') }}"/>
                                    <span class="help-block">{{ $errors->first('url.0') }}</span>
                                </div>
                                @else
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Url" name="url[]" value="{{ old('url.0') }}"/>
                                </div>
                                @endif

                                {{-- Stain of the virtual slide --}}
                                @if($errors->has('stain.0'))
                                <div class="form-group has-error">
                                    <input class="form-control" type="text" placeholder="Stain" name="stain[]" value='{{ old('stain.0') }}'/>
                                    <span class="help-block">{{ $errors->first('stain.0') }}</span>
                                </div>
                                @else
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Stain" name="stain[]" value='{{ old('stain.0') }}'/>
                                </div>
                                @endif
                            </fieldset>
                        {{-- Display form for more slides if more slides exist --}}
                        @if(count(old('url')) > 1)
                            @for($i = 1; $i < count(old('url')); $i++)
                            <fieldset>
                                <legend>Virtual slide</legend>

                                {{-- Url of the virtual slide --}}
                                @if($errors->has('url.' .$i))
                                <div class="form-group has-error">
                                    <input type="text" class="form-control" placeholder="Url" name="url[]" value="{{ old('url.' . $i) }}"/>
                                    <span class="help-block">{{ $errors->first('url.' . $i) }}</span>
                                </div>
                                @else
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Url" name="url[]" value="{{ old('url.' . $i) }}"/>
                                </div>
                                @endif

                                {{-- Stain of the virtual slide --}}
                                @if($errors->has('stain.' . $i))
                                <div class="form-group has-error">
                                    <input class="form-control" type="text" placeholder="Stain" name="stain[]" value='{{ old('stain.' . $i) }}'/>
                                    <span class="help-block">{{ $errors->first('stain.' . $i) }}</span>
                                </div>
                                @else
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Stain" name="stain[]" value='{{ old('stain.' . $i) }}'/>
                                </div>
                                @endif

                                {{-- Remove additional slides button --}}
                                <div class="form-group">
                                    <a class="btn btn-primary remove-slide" href="#">Remove slide</a>
                                </div>
                            </fieldset>

                            @endfor
                        @endif
                        </div>
                        <div class="form-group">
                            {{-- Submit button --}}
                            <button type="submit" class="btn btn-primary">Create case</button>

                            {{-- Button to add more slides through JS --}}
                            <button id="add-slide" class="btn btn-primary">Add Slide</button>
                        </div>
                    </form>
                @endforelse
                </ul>
            </div>

            {{-- Table for cases of the descendants of the selected category and the category itself --}}
            <div class="col-md-9">
                <table id="cases-table" class="table">
                    <thead>
                        <tr>
                            <th>Clinical Data</th>
                            <th>Provider</th>
                            <th>Slides</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($cases as $case)
                        <tr>
                            <td><b>{{ $case->category->category }}</b><br/>{{ $case->clinical_data }}</td>
                            <td><a href="{{ $case->provider->url }}" target="_blank">{{ $case->provider->name }}</a></td>
                            <td>
                            @foreach($case->slides as $slide)
                                <a class="btn btn-primary" href="{{ $slide->url }}" target="_blank">{{ $slide->stain }}</a>
                            @endforeach
                            </td>
                            <td><a class="btn btn-primary" href="{{ route('case-show', $case->id) }}">Edit</a></td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- JS template for adding more slides --}}
        @include('handlebars.virtual-slide')
@endsection