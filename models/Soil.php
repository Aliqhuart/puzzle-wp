<?php

namespace Models;

/**
 * App\Models\Soil
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $top_image_hash
 * @property boolean $can_plant
 * @property-read App\Image $top_image
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Soil whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Soil whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Soil whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Soil whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Soil whereTopImageHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Soil whereCanPlant($value)
 * @property float $price
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Soil wherePrice($value)
 */
class Soil extends \Model
{
    protected $table = 'soil_types';
    protected $guarded = [];

    protected static $validationRules = [
        'name'=> [
            'required'
        ],
        'price'=> [
            'required',
            'numeric'
        ],
    ];
    protected static $validationMessages = [
        'name'=> [
            'required'=> 'Name required'
        ],
    ];

    protected static $availableFields = [
        'name',
        'price',
    ];

    protected static $imageFields = [
        'top_image_hash',
    ];

    public function top_image() {
        return $this->belongsTo(\images::class, 'top_image_hash', 'hash');
    }
}
