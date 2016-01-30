@extends('layouts.wordpress-admin')
@section('body')
@include("admin.categories.nav")
@include("layouts.errors")
<?php $category = new \Models\Category(); ?>
@include('admin.categories.form')
@stop