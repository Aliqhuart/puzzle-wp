<table class="details-grid table">
    <thead>
        <tr>
            <th></th>
            <th>Descriere</th>
            <th>Cantitate</th>
            <th>Preț</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalPrice = 0;
        foreach ($user_order->modules as $m):
            $module = $m->module;
            $totalPrice+=$module->price;
            ?>
            <tr class="template" data-template>
                <td data-field="image">
                    <?php if ($module->preferedImage): ?>
                        <img src="<?= $module->preferedImage->url(['height' => 100]) ?>" />
                    <?php endif; ?>
                </td>
                <td data-field="name">Modul</td>
                <td>
                    <span data-field="quantity"><?= count($m->centers) ?></span>
                    <span data-field="unit">buc.</span>
                </td>
                <td><span data-field="price"><?= $module->price ?></span> RON</td>
            </tr>
            <?php
        endforeach;
        ?>
        <?php
        foreach ($user_order->soils as $perimeter):
            /* @var $soil App\Models\Soil */
            $soil = $perimeter->soil;

            if (!$soil):
                continue;
            endif;
            $totalPrice+=$soil->price;
            ?>
            <tr class="template" data-template>
                <td data-field="image">
                    <?php if ($soil->top_image_hash): ?>
                        <img src="<?= $soil->top_image->url(['height' => 100]) ?>" />
                    <?php endif; ?>
                </td>
                <td data-field="name"><?= $soil->name ?></td>
                <td>
                    <span data-field="quantity"><?= $perimeter->area ?></span>
                    <span data-field="unit">m<sup>2</sup></span>
                </td>
                <td><span data-field="price"><?= $soil->price ?></span> RON</td>
            </tr>
            <?php
        endforeach;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Total</th>
            <th><span data-field="totalPrice"><?= $totalPrice ?></span> RON</th>
        </tr>
    </tfoot>
</table>