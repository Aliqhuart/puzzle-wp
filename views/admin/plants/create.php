@extends('layouts.wordpress-admin')
@section('body')
@include("admin.plants.nav")
@include("layouts.errors")
<?php $plant = new \Models\Plant(); ?>
@include('admin.plants.form')
@stop