@extends('layouts.master')

@section('title', 'Page Title')
@section('content')
	<form method="post" action="{{route('twitter')}}">
		<input type="text" name="search" placeholder="by City"/>
		<input type="submit" value="Search">
	</form>
@endsection
