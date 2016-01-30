@extends('layouts.wordpress-admin')
@section('body')
@include("admin.soil.nav")


<form action="<?= $plugin->soil_url('delete', ['id' => $soil_type->id]) ?>" method="POST">

    Esti sigur ca vrei sa stergi acest tip sol?
    
    <button type="submit" class="btn-link">Da</button>
    <a href="<?= $plugin->soil_url() ?>">Nu</a>

    <?php if ($soil_type->top_image) : ?>
        <div class="soil-demo" style="background-image: url('<?= $soil_type->top_image->url() ?>')"></div>
    <?php endif; ?>
</form>

@stop