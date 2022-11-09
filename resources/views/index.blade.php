@extends('layouts.main_layout')

@section('content')
    @include('partials.header')
    @include('partials.index_first')
    @include('partials.index_about')
    @include('partials.index_plan')
    @include('partials.index_merit') 
    @include('partials.footer')
@endsection