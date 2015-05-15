<?php
    $providerId   = old('virtual_slide_provider_id') ?: $case->provider->id;
    $clinicalData = old('clinical_data') ?: $case->clinical_data;

    $slides = $case->slides;

    $oldUrls     = old('url');
    $oldStains   = old('stain');
    $oldSlideIds = old('slide_id');
    if(!is_null($oldUrls)) {
        $slides = [];
        for($i = 0; $i < count($oldUrls); $i++) {
            $slides[] = [
                'id'    => $oldSlideIds[$i],
                'url'   => $oldUrls[$i],
                'stain' => $oldStains[$i]
            ];
        }
    }

?>
@extends('app')

@section('title', $case->category->category . ' case')

@section('content')

{{-- Update form --}}
<form role="form" action="{{ route('case-update') }}" method="post">
    <h3>Edit {{ $case->category->category }} case</h3>

    <div class="row">
        {{-- Column for case details --}}
        <div class="col-md-6">
            <fieldset>
                <legend>Case details</legend>

                {{-- Select box for virtual slide provider --}}
                <div class="form-group">
                    <label class="control-label" for="virtual_slide_provider_id">Virtual slide provider</label>
                    <select name="virtual_slide_provider_id" id="" class="form-control">
                    @foreach($providers as $provider)
                        @if($providerId == $provider->id)
                        <option value="{{ $provider->id }}" selected>{{ $provider->name }}</option>
                        @else
                        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                        @endif
                    @endforeach
                    </select>
                </div>

                {{-- Display the Hierarchy --}}
                <div class="form-group">
                    <label class="control-label">Diagnosis</label>
                    <p>{{ implode(' &rArr; ', $parentIds) }}<p>
                    <input name="category_id" type="hidden" value="{{ $case->category->id }}"/>
                </div>

                {{-- Clinical data textfield --}}
                <div class="form-group">
                    <label class="control-label" for="clinical_data">Clinical data</label>
                    <input name="clinical_data" class="form-control" type="text" value="{{ $clinicalData }}"/>
                </div>

                {{-- Case id hidden field --}}
                <input name="id" type="hidden" value="{{ $case->id }}"/>

                {{-- Method spoofing for PUT request --}}
                <input name="_method" type="hidden" value="PUT"/>

                {{-- CSRF token --}}
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            </fieldset>
        </div> <!-- col-md-6 -->

        {{-- Column for slide details --}}
        <div class="col-md-6">
            <div id="slides">
            <?php $firstSlide = true; ?>
            @foreach($slides as $key => $slide)
                <fieldset>
                    <legend>Virtual slide</legend>

                    {{-- Url of the slide --}}
                    @if($errors->has('url.' . $key))
                    <div class="form-group has-error">
                        <label class="control-label" for="url[]">Url</label>
                        <input type="url" name="url[]" class="form-control" value="{{{ $slide['url'] }}}"/>
                        <span class="help-block">{{ $errors->first('url.' . $key) }}</span>
                    </div>
                    @else
                    <div class="form-group">
                        <label class="control-label" for="url[]">Url</label>
                        <input type="url" name="url[]" class="form-control" value="{{{ $slide['url'] }}}"/>
                    </div>
                    @endif

                    {{-- Stain of the slide --}}
                    @if($errors->has('stain.' . $key))
                    <div class="form-group has-error">
                        <label class="control-label" for="stain">Stain</label>
                        <input name="stain[]" class="form-control" type="text" value="{{{ $slide['stain'] }}}"/>
                        <span class="help-block">{{ $errors->first('stain.' . $key) }}</span>
                    </div>
                    @else
                    <div class="form-group">
                        <label class="control-label" for="stain">Stain</label>
                        <input name="stain[]" class="form-control" type="text" value="{{ $slide['stain'] }}"/>
                    </div>
                    @endif

                    <input name="slide_id[]" type="hidden" value="{{ $slide['id'] }}"/>

                    {{-- Display remove slide from second slide onwards --}}
                    @if($firstSlide == false)
                    <div class="form-group">
                        <a class="btn btn-primary remove-slide" href="#">Remove slide</a>
                    </div>
                    @endif
                    <?php $firstSlide = false; ?>
                </fieldset>
            @endforeach
            </div> <!-- .slides -->
        </div> <!-- .col-md-6 -->
    </div> <!-- .row -->

    {{-- Buttons row --}}
    <div class ="row">
        <div class="col-md-12">
            <div class="form-group">
                {{-- Button to add more slides through JS --}}
                <button id="add-slide" class="btn btn-primary">Add Slide</button>

                {{-- Submit button --}}
                <button type="submit" class="btn btn-primary">Update case</button>

                {{-- Button to cancel and go back to the case category page --}}
                <a class="btn btn-primary" href="{{ route('case-category', $case->category->id) }}">Cancel</a>
            </div> <!-- .form-group -->
        </div> <!-- .col-md-12 -->
    </div> <!-- .row -->
</form>

{{-- Delete form --}}
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('case-destroy', $case->id) }}" method="post">
            <input name="_method"     value="DELETE" type="hidden"/>
            <input name="category_id" value="{{ $case->category->id }}" type="hidden"/>
            <input name="_token"      value="{{ csrf_token() }}" type="hidden"/>
            <button type="submit" class="btn btn-primary">Delete case</button>
        </form>
    </div>
</div>

{{-- Handlebars template for adding elements by JS --}}
@include('handlebars.virtual-slide-edit')
@endsection
