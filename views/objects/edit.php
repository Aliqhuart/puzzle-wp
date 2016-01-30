@extends('layouts.admin')

@section('body')
<h1>Obiect nou</h1>
@include("objects.nav")
<?php
if (session('create-success')):
    $message = 'Object created';
    ?>
@include('snipets.success')
    <?php
endif;
?>
<?php
if (session('update-success')):
    $message = 'Object updated';
    ?>
@include('snipets.success')
    <?php
endif;
?>
@include("layouts.errors")
@include('objects.form')
@stop