<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <title>Gr&atilde;dina Puzzle</title>

        <link rel="stylesheet" type="text/css" href="<?= elixir("css/app.css") ?>">
    </head>
    <body>
        @include('navbar')
        <div id="garden-background">
            <svg>
                <rect x="0" y="0" width="200%" height="200%" fill="url(#gridPattern)" id="bgRectangle" />
            </svg>
        </div>
        <div id="garden-container">
            <svg>
            </svg>
            <div id="garden-select"></div>
        </div>
        <div id="garden-price">
            <span class="total-label">Preț Execuție: <span class="total-number">0</span></span>
            <button type="button" class="details-btn">Detalii</button>
            <div class="details-container hidden">
                <div class="details-content">
                    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <table class="details-grid">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Descriere</th>
                                <th>Cantitate</th>
                                <th>Preț</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="template" data-template>
                                <td data-field="image"></td>
                                <td data-field="name"></td>
                                <td>
                                    <span data-field="quantity"></span>
                                    <span data-field="unit"></span>
                                </td>
                                <td><span data-field="price">0</span> RON</td>
                            </tr>
                        </tbody>
                    </table>
                    <form class="order-form" action="<?= App\Http\Controllers\PuzzleController::action('postOrderView') ?>" method="POST">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-primary">
                            Cumpără
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div id="garden-toolbox">
            <div id="module-buttons">

            </div>
            <a href="javascript:;" class="toggle-contents">
                <i class="glyphicon glyphicon-menu-hamburger"></i>
            </a>
            <div class="contents">
                <div id="module-categories">
                    <ul>
                    <?php
            $displayCategories = function($displayCategories, $list, $level = 0) {
                foreach ($list as $cat):
                    $hasChildren = !! count($cat->children);

                    $model = new \App\Models\Category((array) $cat);
                    ?>
                        <li class="">
                            <?php
                            if ($level == 0):
                                echo '<i class="icon-category icon-category-', $cat->slug, '"></i>';
                            endif;

                            if ($hasChildren):
                            $id = 'categoryChildren'.$cat->id;
                            ?>
                            <a href="javascript:;" role="button" data-target="#<?= $id ?>" data-level="<?= $level ?>"
                               class="expand-category"><?php
                                if ($level > 0 && $cat->image_hash):
                                ?><img src="<?= \App\Image::hash_url($cat->image_hash, ['width' => 150])?>"/><?php
                                else:
                                    echo $cat->name;
                                endif
                                ?></a>
                            <ul id="<?= $id ?>" class="subcategories">
                                <?php $displayCategories($displayCategories, $cat->children, $level + 1); ?>
                            </ul>
                        <?php else: ?>
                            <button type="button" class="fetch-modules" data-category_id="<?= $cat->id ?>"><?php
                                if ($level > 0 && $cat->image_hash):
                                ?><img src="<?= \App\Image::hash_url($cat->image_hash, ['width' => 150])?>"/><?php
                                else:
                                    echo $cat->name;
                                endif
                                ?></button>
                        <?php endif;?>
                    </li>
                    <?php
                endforeach;
            };

            $displayCategories($displayCategories, \App\Models\Category::getTree());
            ?>
                    </ul>
                </div>
                <div id="center-stage-backdrop"></div>
                <div id="tool-container">
                </div>
            </div>
        </div>
        <div id="garden-zoom" class="btn-group">
            <button type="button" data-zoom="in" class="btn btn-default btn-lg">
                <i class="glyphicon glyphicon-zoom-in"></i>
            </button>
            <button type="button" data-zoom="out" class="btn btn-default btn-lg">
                <i class="glyphicon glyphicon-zoom-out"></i>

            </button>
        </div>
        <svg>
            <defs>
            <?php
            $soilTypes = \App\Models\Soil::all();
            /** @var \App\Models\Soil $soil */
            foreach ($soilTypes as $soil):
                ?>
                <pattern id="materialPattern<?= $soil->id ?>" x="0" y="0" patternUnits="userSpaceOnUse" height="<?= $soil->top_image->height ?>" width="<?= $soil->top_image->width ?>">
                    <image x="0" y="0" width="<?= $soil->top_image->width ?>" height="<?= $soil->top_image->height ?>" xlink:href="<?= $soil->top_image->url() ?>"></image>
                </pattern>
                <?php
            endforeach;
            ?>
                <pattern id="gridPattern" x="0" y="0" patternUnits="userSpaceOnUse" height="100" width="100">
                    <?php for ($i = 0; $i < 10; $i ++):?>
                        <path d="M<?=10*$i?> 0L<?=10*$i?> 100" class="path10cm" />
                        <path d="M0 <?=10*$i?>L100 <?=10*$i?>" class="path10cm" />
                    <?php endfor ?>
                    <rect x="0" y="0" width="100" height="100" class="rect1m" />
                </pattern>
            </defs>
        </svg>
        <script type="text/javascript">
            var IMAGES_URL = '<?= \Controllers\ImagesController::action('getIndex') ?>';
            var PUZZLE_URL = '<?= \Controllers\PuzzleController::action('getIndex') ?>';
            var SoilTypes = <?= $soilTypes->toJson() ?>;
        </script>
        <script type="text/javascript" src="<?= asset("js/main.js") ?>"></script>
    </body>
</html>
