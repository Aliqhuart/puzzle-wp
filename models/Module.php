<?php

namespace Models;

/**
 * App\GardenObject
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $scientific
 * @property string $top_image
 * @property string $side_image
 * @property string $mature_top_image
 * @property string $mature_side_image
 * @property integer $top_image_width
 * @property integer $side_image_width
 * @property integer $mature_top_image_width
 * @property integer $mature_side_image_width
 * @property-read Image $top
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereTopImageWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereSideImageWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereMatureTopImageWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereMatureSideImageWidth($value)
 * @property string $top_image_hash
 * @property string $front_image_hash
 * @property string $back_image_hash
 * @property string $left_image_hash
 * @property string $right_image_hash
 * @property string $mature_front_image_hash
 * @property string $mature_back_image_hash
 * @property string $mature_left_image_hash
 * @property string $mature_right_image_hash
 * @property-read App\Image $front_image
 * @property-read App\Image $left_image
 * @property-read App\Image $right_image
 * @property-read App\Image $mature_front_image
 * @property-read App\Image $mature_left_image
 * @property-read App\Image $mature_right_image
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereMatureTopImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereMatureSideImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereTopImageHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereFrontImageHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereBackImageHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereLeftImageHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereRightImageHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereMatureFrontImageHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereMatureBackImageHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereMatureLeftImageHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Module whereMatureRightImageHash($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|Plant[] $plants
 * @property-read mixed $preffered_image
 * @property-read mixed $price
 * @property-read App\Image $preferedImage
 * @property-read App\Image $mature_back_image
 */
class Module
        extends \Model {

    protected $fillable = ['*'];
    protected $guarded = [];

    protected $appends = [
        'height',
        'width',
        ];

    protected static $validationRules    = [
        'name' => [
            'required'
        ],
        'top_image_width' => [
            'required',
            'min:1',
        ],
    ];
    protected static $validationMessages = [
        'name' => [
            'required' => 'Name required'
        ],
    ];
    protected static $availableFields    = [
        'name',
        'top_image_width',
        'category_id',
    ];
    protected static $imageFields        = [
        'top_image_hash',
        'front_image_hash',
        'back_image_hash',
        'left_image_hash',
        'right_image_hash',
        'mature_top_image',
        'mature_front_image_hash',
        'mature_back_image_hash',
        'mature_left_image_hash',
        'mature_right_image_hash',
    ];
    protected static $imagePreferedOrder = [
        'mature_front_image_hash' => 'mature_front_image',
        'front_image_hash'        => 'front_image',
        'mature_back_image_hash'  => 'mature_back_image',
        'back_image_hash'         => 'back_image',
        'mature_left_image_hash'  => 'mature_left_image',
        'left_image_hash'         => 'left_image',
        'mature_right_image_hash' => 'mature_rignt_image',
        'right_image_hash'        => 'right_image',
        'mature_top_image'        => 'mature_top',
        'top_image_hash'          => 'top_image',
    ];

    public static function createFromInput(\Illuminate\Http\Request $input, $id = null, $save = true) {

        $module = parent::createFromInput($input, $id, $save);

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Register plants
        ////
        $inputPlants = $input->get('plant', []);
        $plantsById  = [];

        foreach ($inputPlants as $plantId => $inPlant) {
            $plantsById[$plantId] = [
                'input' => $inPlant,
                'model' => null
            ];
        }

        $currentPlants = $module->plants;
        $module->plants()->detach();

        foreach ($currentPlants as $plant) {
            if (isset($plantsById[$plant->id])) {
                // plant updated
                $plantsById[$plant->id]['model'] = $plant;
            } else {
                $plant->delete();
            }
        }

        foreach ($plantsById as $plantId => $arrPlant) {
            if (is_null($arrPlant['model'])) {
                $arrPlant['model'] = Plant::find($plantId);
            }

            if (!$arrPlant['model']) {
                continue;
            }

            $module->plants()->save($arrPlant['model'], [
                'amount' => $arrPlant['input']['amount']
            ]);
        }


        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Register categories
        ////
        $inputCategories = $input->get('category', []);
        $categoriesById = [];

        foreach ($inputCategories as $categoryId => $inCategory) {
            $categoriesById[$categoryId] = [
                'input' => $inCategory,
                'model' => null
            ];
        }

        $currentCategories = $module->categories;

        foreach ($currentCategories as $category) {
            if (isset($categoriesById[$category->id])) {
                // category updated
                $categoriesById[$category->id]['model'] = $category;
            } else {
                $module->categories()->detach($category->id);
            }
        }

        foreach ($categoriesById as $categoryId => $arrCategory) {
            if (!is_null($arrCategory['model'])) {
                continue;
            }

            $arrCategory['model'] = Category::find($categoryId);
            if (!$arrCategory['model']) {
                continue;
            }
            $module->categories()->attach($arrCategory['model']);
        }

        return $module;
    }

    ////////////////////////////////////////////////////////////////////////////
    // Getters/Setters

    public function getPrefferedImageAttribute() {

    }

    /**
     *
     * @return type
     */
    public function getPriceAttribute() {
        return \DB::table('module_plants AS mp')
                        ->leftJoin('plants AS p', 'mp.plant_id', '=', 'p.id')
                        ->select([\DB::raw('SUM(mp.amount * p.price) AS price')])
                        ->where('mp.module_id', $this->id)
                        ->groupBy('mp.module_id')
                        ->value('price');
    }

    public function getHeightAttribute() {
        if (!$this->top_image) {
            return 0;
        }

        $imgWidth = $this->top_image->width;
        $imgRatio = $this->top_image->height / (double) $this->top_image->width;

        return $imgRatio * $this->getWidthAttribute();
    }

    public function getWidthAttribute() {
        $ownWidth = $this->top_image_width;
        if ($ownWidth > 0) {
            return $ownWidth;
        }

        if (!$this->top_image) {
            return 0;
        }

        return $this->top_image->width;
    }

    ////////////////////////////////////////////////////////////////////////////
    // DB relationships
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'modules_categories', 'module_id', 'category_id');
    }

    public function plants()
    {
        return $this->belongsToMany(Plant::class, 'module_plants', 'module_id', 'plant_id')->withPivot('amount');
    }

    ////////////////////////////////////////////////////////////////////////////
    // Image relationships

    public function preferedImage() {
        foreach (static::$imagePreferedOrder as $hashFieldName => $image_name) {
            if ($this->getAttribute($hashFieldName)) {
                return $this->belongsTo(\images::class, $hashFieldName, 'hash');
            }
        }

        return $this->belongsTo(\images::class, array_keys(static::$imagePreferedOrder)[0], 'hash');
    }

    public function top_image() {
        return $this->belongsTo(\images::class, 'top_image_hash', 'hash');
    }

    public function front_image() {
        return $this->belongsTo(\images::class, 'front_image_hash', 'hash');
    }

    public function left_image() {
        return $this->belongsTo(\images::class, 'left_image_hash', 'hash');
    }

    public function right_image() {
        return $this->belongsTo(\images::class, 'right_image_hash', 'hash');
    }

    public function mature_top_image() {
        return $this->belongsTo(\images::class, 'mature_top_image_hash', 'hash');
    }

    public function mature_back_image() {
        return $this->belongsTo(\images::class, 'mature_back_image_hash', 'hash');
    }

    public function mature_front_image() {
        return $this->belongsTo(\images::class, 'mature_front_image_hash', 'hash');
    }

    public function mature_left_image() {
        return $this->belongsTo(\images::class, 'mature_left_image_hash', 'hash');
    }

    public function mature_right_image() {
        return $this->belongsTo(\images::class, 'mature_right_image_hash', 'hash');
    }

}
