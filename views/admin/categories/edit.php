@extends('layouts.wordpress-admin')
@section('body')
@include("admin.categories.nav")
<?php
if (isset($create_success) && $create_success):
    $message = 'Categorie creată';
    ?>
@include('snipets.success')
    <?php
endif;
?>
<?php
if (isset($update_success) && $update_success):
    $message = 'categorie modificată';
    ?>
@include('snipets.success')
    <?php
endif;
?>
@include("layouts.errors")
@include('admin.categories.form')
@stop