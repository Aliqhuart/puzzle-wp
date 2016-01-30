<?php

use Models\Plant;

if (!isset($plant)) {
    $plant = new Plant;
}
?>
<form action="<?= $plant->exists ? $plugin->plants_url('update', ['id' => $plant->id]) : $plugin->plants_url('create') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="col-xs-12 form-group<?= $errors->has('name') ? ' has-error' : '' ?>">
        <label>Nume</label>
        <input name="name" type="text" value="<?= old('name', $plant->name) ?>" class="form-control">
    </div>
    <div class="col-xs-12 form-group<?= $errors->has('scientific') ? ' has-error' : '' ?>">
        <label>Denumire stiitifica</label>
        <input name="scientific" type="text" value="<?= old('scientific', $plant->scientific) ?>" class="form-control">
    </div>
    <div class="col-xs-12 form-group<?= $errors->has('price') ? ' has-error' : '' ?>">
        <label>Pret</label>
        <div class="input-group">
            <input name="price" type="number" step="0.01" value="<?= old('price', $plant->price) ?>" class="form-control">
            <div class="input-group-addon">RON/bucat&atilde;</div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 form-group<?= $errors->has('top_image') ? ' has-error' : '' ?>">
        <label>Vedere de sus (la plantare)</label>
        <input type="file" name="top_image_hash" class="form-control">
        <?php if ($plant->top_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $plant->top_image->url(['height'=>250]) ?>" />
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-sm-6 form-group<?= $errors->has('mature_top_image') ? ' has-error' : '' ?>">
        <label>Vedere de sus (la maturitate)</label>
        <input type="file" name="mature_top_image_hash" class="form-control">
        <?php if ($plant->mature_top_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $plant->mature_top_image->url(['height'=>250]) ?>"
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-sm-6 form-group<?= $errors->has('side_image') ? ' has-error' : '' ?>">
        <label>Vedere laterala (la plantare)</label>
        <input type="file" name="side_image_hash" class="form-control">
        <?php if ($plant->side_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $plant->side_image->url(['height'=>250]) ?>" />
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-sm-6 form-group<?= $errors->has('mature_side_image') ? ' has-error' : '' ?>">
        <label>Vedere laterala (la maturitate)</label>
        <input type="file" name="mature_side_image_hash" class="form-control">
        <?php if ($plant->mature_side_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $plant->mature_side_image->url(['height'=>250]) ?>" />
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12">
        <button type="submit" class="btn btn-primary">
            Salveaza
        </button>
    </div>
</form>