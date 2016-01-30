@extends('layouts.wordpress-admin')
@section('body')
@include("admin.soil.nav")
@include("layouts.errors")
<?php $soil_type = new \Models\Soil(); ?>
@include('admin.soil.form')
@stop