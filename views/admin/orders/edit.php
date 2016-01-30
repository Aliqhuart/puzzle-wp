@extends('layouts.wordpress-admin')
@section('body')
@include("admin.orders.nav")
<?php
if (isset($create_success) && $create_success):
    $message = 'Comanda creata';
    ?>
@include('snipets.success')
    <?php
endif;
?>
<?php
if (isset($update_success) && $update_success):
    $message = 'Comanda modificata';
    ?>
@include('snipets.success')
    <?php
endif;
?>
@include("layouts.errors")
@include('admin.orders.view-grid')
@include('admin.orders.form')
@stop