@extends('layouts.master')

@section('title', 'Page Title')
@section('content')
    <div id="map"></div>
    <form method="post" action="">
        <input type="text" name="search" placeholder="by City"/>
        <input type="submit" value="Search">
        <input type="submit" value="">History
    </form>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBd84SRSI_zX3M86W7SXWhf4KL8pS0NFdU
        &libraries=visualization&callback=initMap">
    </script>
    <script type="text/javascript" src="{{ URL::asset('js/map.js') }}"></script>
@endsection
