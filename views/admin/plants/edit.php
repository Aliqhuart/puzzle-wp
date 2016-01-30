@extends('layouts.wordpress-admin')
@section('body')
@include("admin.plants.nav")
<?php
if (isset($create_success) && $create_success):
    $message = 'Planta creata';
    ?>
@include('snipets.success')
    <?php
endif;
?>
<?php
if (isset($update_success) && $update_success):
    $message = 'Planta modificata';
    ?>
@include('snipets.success')
    <?php
endif;
?>
@include("layouts.errors")
@include('admin.plants.form')
@stop