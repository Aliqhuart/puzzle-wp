<?php

use Models\Module;

if (!isset($module)) {
    $module = new Module;
}
?>
<form action="<?= $module->exists ? $plugin->modules_url('update', ['id' => $module->id]) : $plugin->modules_url('create') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="col-xs-12 form-group<?= $errors->has('name') ? ' has-error' : '' ?>">
        <label>Nume</label>
        <input name="name" value="<?= old('name', $module->name) ?>" class="form-control">
    </div>

    <div class="col-xs-12 form-group<?= $errors->has('category_id') ? ' has-error' : '' ?>">
        <label>Categorie</label>
        <ul id="module-categories">
            <?php
            $moduleCategories = [];
            foreach ($module->categories as $category) {
                $moduleCategories[$category->id] = true;
            }
            $displayCategories = function($displayCategories, $list, $level = 0) use ($moduleCategories) {
            foreach ($list as $cat):
            $hasChildren = !!count($cat->children);

            ?>
            <li class="">
                <?php
                if ($level == 0):
                    echo '<i class="icon-category icon-category-', $cat->slug, '"></i>';
                endif;

                if ($hasChildren):
                $id = 'categoryChildren' . $cat->id;
                echo $cat->name;
                ?>
                <ul id="<?= $id ?>" class="subcategories">
                    <?php $displayCategories($displayCategories, $cat->children, $level + 1); ?>
                </ul>
                <?php
                else:
                $sel = isset($moduleCategories[$cat->id]);
                ?>
                <input type="checkbox" name="category[<?= $cat->id ?>]"
                       value="<?= $cat->id ?>"<?= $sel ? ' checked' : '' ?>><?php
                echo $cat->name;
                ?>
                <?php endif;?>
            </li>
            <?php
            endforeach;
            };

            $displayCategories($displayCategories, \App\Models\Category::getTree());
            ?>
        </ul>
    </div>
    <div class="col-xs-12 form-group">
        <label>Plante</label>
        <input type="search" id="plantSearchIn" list="plantSearchSuggest" class="form-control">
        <datalist id="plantSearchSuggest"></datalist>
        <ul id="plantSearchOut"><?php
            $modulePrice = 0;
            foreach ($module->plants as $plant) :
                $modulePrice+= $plant->price * $plant->pivot->amount;
                ?><li>
                    <input type="checkbox" checked="1" name="plant[<?= $plant->id ?>][selected]" value="<?= $plant->id ?>" class="plant-check" data-plant="<?= $plant->id ?>" />
                    <input type="number" min="0" step="1" name="plant[<?= $plant->id ?>][amount]" value="<?= $plant->pivot->amount ?>" class="amount" data-plant="<?= $plant->id ?>" />
                    <span><?= $plant->name ?>(<?= $plant->scientific ?>) - <?= $plant->price ?>RON</span>
                </li><?php
            endforeach;
            ?></ul>
        <div class="input-group">
            <div class="input-group-addon">Pret total: </div>
            <input type="number" name="price" id="modulePrice" value="<?= $modulePrice ?>" readonly="1" class="form-control" />
            <div class="input-group-addon">RON</div>
        </div>
    </div>
    <div class="col-xs-12 form-group<?= $errors->has('top_image_hash') ? ' has-error' : '' ?>">
        <label>Vedere de sus (la plantare)</label>
        <input type="file" name="top_image_hash" class="form-control">
        <?php if ($module->top_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $module->top_image->url(['width' => 400]) ?>" />
            </p>
        <?php endif; ?>
    </div>

    <div class="col-xs-12 form-group<?= $errors->has('top_image_width') ? ' has-error' : '' ?>">
        <label>Lățime modul(<i class="glyphicon glyphicon-resize-horizontal"></i> cm)</label>
        <input type="number" min="1" name="top_image_width" value="<?= old('top_image_width', data_get($module,'top_image_width', 1)) ?>" class="form-control">
    </div>
    <div class="col-xs-12 col-md-6 form-group<?= $errors->has('front_image_hash') ? ' has-error' : '' ?>">
        <label>Vedere din fata (la plantare)</label>
        <input type="file" name="front_image_hash" class="form-control">
        <?php if ($module->front_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $module->front_image->url(['width' => 200]) ?>" />
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-md-6 form-group<?= $errors->has('mature_front_image_hash') ? ' has-error' : '' ?>">
        <label>Vedere din fata (la maturitate)</label>
        <input type="file" name="mature_front_image_hash" class="form-control">
        <?php if ($module->mature_front_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $module->mature_front_image->url(['width' => 200]) ?>" />
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 form-group<?= $errors->has('mature_top_image_hash') ? ' has-error' : '' ?>">
        <label>Vedere de sus (la maturitate)</label>
        <input type="file" name="mature_top_image_hash" class="form-control">
        <?php if ($module->mature_top_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $module->mature_top_image->url(['width' => 400]) ?>" />
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-md-6 form-group<?= $errors->has('back_image_hash') ? ' has-error' : '' ?>">
        <label>Vedere din spate (la plantare)</label>
        <input type="file" name="back_image_hash" class="form-control">
        <?php if ($module->back_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $module->back_image->url(['width' => 200]) ?>" />
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-md-6 form-group<?= $errors->has('right_image_hash') ? ' has-error' : '' ?>">
        <label>Vedere din dreapta (la plantare)</label>
        <input type="file" name="right_image_hash" class="form-control">
        <?php if ($module->right_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $module->right_image->url(['width' => 200]) ?>" />
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-md-6 form-group<?= $errors->has('left_image_hash') ? ' has-error' : '' ?>">
        <label>Vedere din stanga (la plantare)</label>
        <input type="file" name="left_image_hash" class="form-control">
        <?php if ($module->left_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $module->left_image->url(['width' => 200]) ?>" />
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-md-6 form-group<?= $errors->has('mature_back_image_hash') ? ' has-error' : '' ?>">
        <label>Vedere din spate (la maturitate)</label>
        <input type="file" name="mature_back_image_hash" class="form-control">
        <?php if ($module->mature_back_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $module->mature_back_image->url(['width' => 200]) ?>" />
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-md-6 form-group<?= $errors->has('mature_right_image_hash') ? ' has-error' : '' ?>">
        <label>Vedere din dreapta (la maturitate)</label>
        <input type="file" name="mature_right_image_hash" class="form-control">
        <?php if ($module->mature_right_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $module->mature_right_image->url(['width' => 200]) ?>" />
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-md-6 form-group<?= $errors->has('left_image_hash') ? ' has-error' : '' ?>">
        <label>Vedere din stanga (la maturitate)</label>
        <input type="file" name="mature_left_image_hash" class="form-control">
        <?php if ($module->mature_left_image_hash) : ?>
            <p class="form-control-static">
                <img src="<?= $module->mature_left_image->url(['width' => 200]) ?>" />
            </p>
        <?php endif; ?>
    </div>
    <div class="col-xs-12">
        <button type="submit" class="btn btn-primary">
            Salveaza
        </button>
    </div>
</form>