@extends('layouts.uw')

@section('title', 'Item')

@section('content')

<div class="passport row">
    <div class="col-sm-8 col-sm-offset-2">
    <h1 class="page-header">Item</h1>
    
    @if($passport)
    <h2 class="name">{{$passport->name}}</h2>
    <div class="desc">
        {!! $passport->description !!}
    </div>
    
    {!! Form::open(['method' => 'post', 'route' => 'uw.purchase_passport']) !!}
    
    {!! Form::hidden('pass_id', $passport->id) !!}
    <div class="row text-center">
        <div class="col-sm-6">
            <a href="{{ URL::previous() }}" class="btn btn-default">Back</a>
        </div>
        <div class="col-sm-6">
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </div>
    
    {!! Form::close() !!}
    @else
    <p>Null</p>
    @endif
    </div>
</div>

@stop