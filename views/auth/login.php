@extends('layouts.public')

@section('body')
<?php if (session('login-reason')): ?>
<div class="alert alert-warning"><?= session('login-reason') ?></div>
<?php endif; ?>
<div class="row">
    <div class="col-md-6">
        @include('auth.login-form')
    </div>
    <div class="col-md-6">
        @include('auth.register-form')
    </div>
</div>
@stop