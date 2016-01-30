@extends('layouts.wordpress-admin')
@section('body')
@include("admin.modules.nav")


<form action="<?= $plugin->modules_url('delete', ['id' => $module->id]) ?>" method="POST">

    Esti sigur ca vrei sa stergi acest tip sol?
    
    <button type="submit" class="btn-link">Da</button>
    <a href="<?= $plugin->modules_url() ?>">Nu</a>

    <?php if ($module->top_image_hash) : ?>
        <br />
        <img src="<?= $module->top_image->url() ?>" />
    <?php endif; ?>
</form>

@stop