@extends('app')

@section('content')
        @if(isset($parents))
            <ol class="breadcrumb">
                <li><a href="/cases">Categories</a></li>
            @foreach($parents as $cat)
                <li><a href="/cases/{{ $cat['id'] }}">{{ $cat['category'] }}</a></li>
            @endforeach
                <li><a href="/cases/{{ $category->id }}">{{ $category->category }}</a></li>
            </ol>
        @endif
        <div class="row">
            <div class="col-md-3">
                <ul class="nav">
                @forelse($subCategories as $cat)
                    <li><a href="/cases/{{ $cat->id }}">{{ $cat->category }}</a></li>
                @empty
                    <h3>Add new case</h3>
                    <form role="form" action="{{ url('cases') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Clinical data" name="clinical_data"/>
                        </div>
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
                        <input name="category_id" type="hidden" value="{{ $category->id }}"/>
                        <div id="slides">
                            <fieldset>
                                <legend>Virtual slide</legend>
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
                        @if(count(old('url')) > 1)
                            @for($i = 1; $i < count(old('url')); $i++)
                            <fieldset>
                                <legend>Virtual slide</legend>
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

                                <div class="form-group">
                                    <a class="btn btn-primary remove-slide" href="#">Remove slide</a>
                                </div>
                            </fieldset>

                            @endfor
                        @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create case</button>
                            <button id="add-slide" class="btn btn-primary">Add Slide</button>
                        </div>
                    </form>
                @endforelse
                </ul>
            </div>
            <div class="col-md-9">
                <table id="cases-table" class="table">
                    <thead>
                        <tr>
                            <th>Diagnosis</th>
                            <th>Provider</th>
                            <th>Slides</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($cases as $case)
                        <tr>
                            <td>{{ $case->category->category }}</td>
                            <td><a href="{{ $case->provider->url }}" target="_blank">{{ $case->provider->name }}</a></td>
                            <td>
                            @foreach($case->slides as $slide)
                                <a class="btn btn-primary" href="{{ $slide->url }}" target="_blank">{{ $slide->stain }}</a>
                            @endforeach
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @include('handlebars.virtual-slide')
@endsection