@extends('layouts.wordpress-admin')
@section('body')
@include("admin.orders.nav")
@include("layouts.errors")
<?php $order = new \Models\Order(); ?>
@include('admin.orders.form')
@stop