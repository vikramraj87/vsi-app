@extends('app')

@section('content')
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">New case</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post" action="{{ url('cases')  }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Virtual slide provider</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="virtual_slide_provider_id">
                                    @foreach($providers as $provider)
                                        @if(old('virtual_slide_provider_id') == $provider->id)
                                            <option value="{{ $provider->id }}" selected>{{ $provider->name }}</option>
                                        @else
                                            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-md-4 control-label">Clinical data</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="clinical_data">{{ old('clinical_data') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Diagnosis</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="category_id">
                                    @foreach($categories as $id => $name)
                                        @if(old('category_id') == $id)
                                            <option value="{{ $id }}" selected>{{ $name }}</option>
                                        @else
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endif
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <div id="virtual-slides">
                            <?php $numberOfSlides = count(old('url')) ?: 1; ?>
                                @for($i=0; $i<$numberOfSlides; $i++)
                                <fieldset>
                                    <legend>Virtual slide</legend>
                                    <!-- Url[0] -->
                                    @if($errors->has('url.' . $i))
                                    <div class="form-group has-error">
                                        <label class="col-md-4 control-label">Virtual slide url</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="url[]" value="{{ old('url.' . $i) }}"/>
                                            <span class="help-block">{{ $errors->first('url.' . $i) }}</span>
                                        </div>

                                    </div>
                                    @else
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Virtual slide url</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="url[]" value="{{ old('url.' . $i) }}"/>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Stain[0] -->
                                    @if($errors->has('stain.' . $i))
                                    <div class="form-group has-error">
                                        <label class="col-md-4 control-label" for="">Stain</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="stain[]" value="{{ old('stain.' . $i) }}"/>
                                            <span class="help-block">{{ $errors->first('stain.' . $i) }}</span>
                                        </div>
                                    </div>
                                    @else
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="">Stain</label>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="stain[]" value="{{ old('stain.' . $i) }}"/>
                                        </div>
                                    </div>
                                    @endif

                                    @if($i > 0)
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <a class="btn btn-primary remove-slide" href="#">Remove slide</a>
                                        </div>
                                    </div>
                                    @endif
                                </fieldset>
                                @endfor
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <a class="btn btn-primary" id="add-slide" href="#">Add another slide</a>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection