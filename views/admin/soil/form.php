<?php

use Models\Soil;

if (!isset($soil_type)) {
    $soil_type = new Soil;
}
?>
<form action="<?= $soil_type->exists ? $plugin->soil_url('update', ['id' => $soil_type->id]) : $plugin->soil_url('create') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="form-group<?= $errors->has('name') ? ' has-error' : '' ?>">
        <label>Nume</label>
        <input name="name" value="<?= old('name', $soil_type->name) ?>" class="form-control">
    </div>
    <div class="form-group<?= $errors->has('price') ? ' has-error' : '' ?>">
        <label>Pret</label>
        <div class="input-group">
            <input type="number" name="price" min="0" step="0.01" value="<?= old('price', $soil_type->price) ?>" class="form-control">
            <div class="input-group-addon">RON/m<sup>2</sup></div>
        </div>
    </div>
    <div class="form-group<?= $errors->has('top_image') ? ' has-error' : '' ?>">
        <label>Vedere de sus</label>
        <input type="file" name="top_image_hash" class="form-control">
        <?php if ($soil_type->top_image) : ?>
            <div class="soil-demo" style="background-image: url('<?= $soil_type->top_image->url() ?>')"></div>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">
        Salveaza
    </button>
</form>