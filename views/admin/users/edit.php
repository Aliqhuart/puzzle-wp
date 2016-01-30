@extends('layouts.wordpress-admin')
@section('body')
@include("admin.users.nav")
<?php
if (isset($create_success) && $create_success):
    $message = 'User creat';
    ?>
@include('snipets.success')
    <?php
endif;
?>
<?php
if (isset($update_success) && $update_success):
    $message = 'User modificat';
    ?>
@include('snipets.success')
    <?php
endif;
?>
@include("layouts.errors")
@include('admin.users.form')
@stop