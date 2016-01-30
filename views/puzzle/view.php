<?php
$title = 'Comandă';
?>
@extends('layouts.public')

@section('body')
<h1>Plasează comanda</h1>
@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="row">
    <div class="col-md-6">
        @include('puzzle.order-grid')
    </div>
    <div class="col-md-6">
        @include('puzzle.form')
    </div>
</div>
@stop