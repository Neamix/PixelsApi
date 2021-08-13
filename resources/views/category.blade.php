@extends('voyager::master')

@section('css')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@stop

@section('content')
<div class="page-content container-fluid mt-4">
    @php 
      print_r($musics);
    @endphp
</div>
@stop
