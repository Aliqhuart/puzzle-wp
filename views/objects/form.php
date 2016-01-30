<?php

use App\GardenObject;

if (!isset($gardenObject)) {
    $gardenObject = new GardenObject;
}
?>
<form action="<?= $gardenObject->exists ? route('admin.objects.update', $gardenObject->id) : route('admin.objects.store') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <?php if ($gardenObject->exists): ?>
        <input type="hidden" name="_method" value="PUT">
<?php endif; ?>
    <div class="form-group<?= $errors->has('name') ? ' has-error' : '' ?>">
        <label>Nume</label>
        <input name="name" value="<?= old('name', $gardenObject->name) ?>" class="form-control">
    </div>
    <div class="form-group<?= $errors->has('scientific') ? ' has-error' : '' ?>">
        <label>Denumire stiintifica</label>
        <input name="scientific" value="<?= old('scientific', $gardenObject->scientific) ?>" class="form-control">
    </div>
    <div class="form-group<?= $errors->has('top_image') ? ' has-error' : '' ?>">
        <label>Vedere de sus (la plantare)</label>
        <input type="file" name="top_image" class="form-control">
<?php if ($gardenObject->top_image) : ?>
            <p class="form-control-static">
                <img src="<?= $gardenObject->top->url() ?>"
            </p>
<?php endif; ?>
    </div>
    <div class="form-group<?= $errors->has('side_image') ? ' has-error' : '' ?>">
        <label>Vedere laterala (la plantare)</label>
        <input disabled type="file" name="side_image" class="form-control">
    </div>
    <div class="form-group<?= $errors->has('mature_top_image') ? ' has-error' : '' ?>">
        <label>Vedere de sus (la maturitate)</label>
        <input disabled type="file" name="mature_top_image" class="form-control">
    </div>
    <div class="form-group<?= $errors->has('mature_side_image') ? ' has-error' : '' ?>">
        <label>Vedere laterala (la maturitate)</label>
        <input disabled type="file" name="mature_side_image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">
        Salveaza
    </button>
</form>