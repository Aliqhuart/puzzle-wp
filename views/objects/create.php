@extends('layouts.admin')

@section('body')
<h1>Obiect nou</h1>
@include("objects.nav")
@include("layouts.errors")
<?php $gardenObject = new \App\GardenObject(); ?>
@include('objects.form')
@stop