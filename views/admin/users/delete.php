@extends('layouts.wordpress-admin')
@section('body')
@include("admin.users.nav")

<form action="<?= $plugin->users_url('delete', ['id' => $user->id]) ?>" method="POST">

    Esti sigur ca vrei sa stergi aceasta usera?

    <button type="submit" class="btn-link">Da</button>
    <a href="<?= $plugin->users_url() ?>">Nu</a>
    <br />
    <?php
    $imgUrl = $user->getPrefferedUrl(['width' => 400]);
    ?>
    <?php if ($imgUrl): ?>
        <img src="<?= $imgUrl ?>" />
    <?php endif; ?>
</form>

@stop