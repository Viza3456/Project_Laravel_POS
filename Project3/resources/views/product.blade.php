@extends('layouts.master')
@section('title','Product')
@section('product','active')
@section('content')
<product :token = "{value : '{{csrf_token()}}'}" :category = "{{$select}}"></product>
@endsection