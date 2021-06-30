@extends('layouts.master')
@section('title','Home')
@section('home','active')
@section('content')
    <home :use = "{{$user_count}}" :pro = "{{$count_product}}" :cate = "{{$count_category}}":ord = {{$count_order}}></home>
@endsection
