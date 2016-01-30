@extends('layouts.wordpress-admin')
@section('body')
@include("admin.modules.nav")
@include("layouts.errors")
<?php $module = new \Models\Module(); ?>
@include('admin.modules.form')
@stop