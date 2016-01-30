@extends('layouts.wordpress-admin')
@section('body')
@include("admin.plants.nav")

<form action="<?= $plugin->plants_url('delete', ['id' => $plant->id]) ?>" method="POST">

    Esti sigur ca vrei sa stergi aceasta planta?
    
    <button type="submit" class="btn-link">Da</button>
    <a href="<?= $plugin->plants_url() ?>">Nu</a>
    <br />
    <?php
    $imgUrl = $plant->getPrefferedUrl(['width' => 400]);
    ?>
    <?php if ($imgUrl): ?>
        <img src="<?= $imgUrl ?>" />
    <?php endif; ?>
</form>

@stop