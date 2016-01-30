<?php

namespace Models;

use Model;

/**
 * App\Models\Plant
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $scientific
 * @property float $price
 * @property string $top_image_hash
 * @property string $side_image_hash
 * @property string $mature_top_image_hash
 * @property string $mature_side_image_hash
 * @property-read App\Image $top_image
 * @property-read App\Image $side_image
 * @property-read App\Image $mature_top_image
 * @property-read App\Image $mature_side_image
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Plant whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Plant whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Plant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Plant whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Plant whereScientific($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Plant wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Plant whereTopImageHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Plant whereSideImageHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Plant whereMatureTopImageHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Plant whereMatureSideImageHash($value)
 */
class Plant extends Model
{
    protected static $validationRules = [
        'name'=> [
            'required'
        ],
        'scientific'=> [
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
        'scientific',
        'price',
    ];
    
    protected static $imageFields = [
        'top_image_hash',
        'side_image_hash',
        'mature_top_image_hash',
        'mature_side_image_hash',
    ];
    
    public function top_image() {
        return $this->belongsTo(\images::class, 'top_image_hash', 'hash');
    }
    
    public function side_image() {
        return $this->belongsTo(\images::class, 'side_image_hash', 'hash');
    }
    
    public function mature_top_image() {
        return $this->belongsTo(\images::class, 'mature_top_image_hash', 'hash');
    }
    
    public function mature_side_image() {
        return $this->belongsTo(\images::class, 'mature_side_image_hash', 'hash');
    }
    
    public function getPrefferedUrl($imgOptions = []) {
        $imgUrl = false;
        if ($this->mature_side_image_hash) {
            $imgUrl = $this->mature_side_image->url($imgOptions);
        } elseif ($this->side_image_hash) {
            $imgUrl = $this->side_image->url($imgOptions);
        } elseif ($this->mature_top_image_hash) {
            $imgUrl = $this->mature_top_image->url($imgOptions);
        } elseif ($this->top_image_hash) {
            $imgUrl = $this->top_image->url($imgOptions);
        }
        
        return $imgUrl;
    }
}
