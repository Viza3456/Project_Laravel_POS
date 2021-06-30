@extends('layouts.master')
@section('title','Order Product')
@section('orderproduct','active')
@section('content')
<orderproduct :token = "{value : '{{csrf_token()}}'}" :category = "{{$select}}"></orderproduct>
@endsection