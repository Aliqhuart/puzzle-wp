@extends('layouts.wordpress-admin')
@section('body')
@include("admin.categories.nav")

<?= session('delete-error');?>
<?php var_dump($errors) ?>

<form action="<?= $plugin->categories_url('delete', ['id' => $category->id]) ?>" method="POST">

    Esti sigur ca vrei sa stergi acest tip sol?

    <button type="submit" class="btn-link">Da</button>
    <a href="<?= $plugin->categories_url() ?>">Nu</a>

    <?php if ($category->top_image) : ?>
        <div class="category-demo" style="background-image: url('<?= $category->top_image->url() ?>')"></div>
    <?php endif; ?>
</form>

@stop