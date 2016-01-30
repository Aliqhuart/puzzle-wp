@extends('layouts.wordpress-admin')
@section('body')
@include("admin.users.nav")
@include("layouts.errors")
<?php $user = new \App\User(); ?>
@include('admin.users.form')
@stop