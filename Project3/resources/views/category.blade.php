@extends('layouts.master')
@section('title','Category')
@section('category','active')
@section('content')
<category :token = "{value : '{{csrf_token()}}' }"></category>
@endsection