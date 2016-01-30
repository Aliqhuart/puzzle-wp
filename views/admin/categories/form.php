<?php

use Models\Category;

if (!isset($category)) {
    $category = new Category;
}
// var_dump(Category::getTree());
?>
<form action="<?=
$category->exists
        ? $plugin->categories_url('update', ['id' => $category->id])
        : $plugin->categories_url('create')
?>" method="POST" enctype="multipart/form-data">
          <?= csrf_field() ?>
    <div class="form-group<?=
    $errors->has('name')
            ? ' has-error'
            : ''
    ?>">
        <label>Nume</label>
        <input name="name" value="<?= old('name', $category->name) ?>" class="form-control">
    </div>

    <div class="form-group<?=
    $errors->has('slug')
            ? ' has-error'
            : ''
    ?>">
        <label>Slug</label>
        <input name="slug" value="<?= old('slug', $category->slug) ?>" class="form-control">
    </div>

    <div class="form-group<?=
    $errors->has('parent_id')
            ? ' has-error'
            : ''
    ?>">
        <label>Părinte</label>
        <select name="parent_id">
            <option value="0"></option>
            <?php
            $displayParents = function($displayParents, $list, $level = 0) use($category) {
                foreach ($list as $cat):
                    if ($cat->id == $category->id) {
                        continue;
                    }
                    ?>
            <option value="<?= $cat->id ?>"<?= $category->parent_id == $cat->id?' selected':'' ?>><?= str_pad("", $level*2, '|-'), e($cat->name) ?></option>
                    <?php
                    $displayParents($displayParents, $cat->children, $level + 1);
                endforeach;
            };

            $displayParents($displayParents, Category::getTree());
            ?></select>
    </div>
    <div class="col-xs-12 col-md-6 form-group<?= $errors->has('image_hash') ? ' has-error' : '' ?>">
        <label>Imagine</label>
        <input type="file" name="image_hash" class="form-control">
        <?php if ($category->image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $category->image->url(['width' => 200]) ?>" />
            </p>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">
        Salveaza
    </button>
</form>