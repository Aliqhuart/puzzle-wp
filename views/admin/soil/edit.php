@extends('layouts.wordpress-admin')
@section('body')
@include("admin.soil.nav")
<?php
if (isset($create_success) && $create_success):
    $message = 'Sol creat';
    ?>
@include('snipets.success')
    <?php
endif;
?>
<?php
if (isset($update_success) && $update_success):
    $message = 'Sol modificat';
    ?>
@include('snipets.success')
    <?php
endif;
?>
@include("layouts.errors")
@include('admin.soil.form')
@stop