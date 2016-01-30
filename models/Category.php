<?php

namespace Models;

use Model;

/**
 * App\Models\Category
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property string $slug
 * @property integer $parent_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereParentId($value)
 */
class Category
        extends Model {
    protected $fillable = ['*'];

    protected static $validationRules    = [
        'name'      => [
            'required'
        ],
        'slug'      => [
            'required'
        ],
        'parent_id' => [
        ],
    ];
    protected static $validationMessages = [
        'name' => [
            'required' => 'Name required'
        ],
    ];
    protected static $availableFields    = [
        'name',
        'slug',
        'parent_id',
    ];
    protected static $imageFields        = [
        'image_hash'
    ];

    protected static function boot() {
        parent::boot();

        static::saving(function($category) {
            if (!$category->parent_id) {
                $category->parent_id = NULL;
            }

            if ($category->image) {
                $category->image_type = 'image';
            } else {
                $category->image_type = 'font';
            }
        });
    }

    //////////////////////////////////////////////////////////////////////////////////////////////
    // Images
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'modules_categories', 'category_id', 'module_id');
    }

    //////////////////////////////////////////////////////////////////////////////////////////////
    // Images

    public function image() {
        return $this->belongsTo(\App\Image::class, 'image_hash', 'hash');
    }

    //////////////////////////////////////////////////////////////////////////////////////////////
    // Static
    public static function getTree() {
        $flat = static::orderBy('name')->get();

        $categories = [
            0 => (object) [
                'id'=>0,
                'children'=>[],
            ]
        ];

        foreach ($flat as $category) {
            $category->children = [];
            $categories[$category->id] = (object) $category->toArray();
        }

        foreach ($categories as $id => $category) {
            if (0 == $id) {
                continue;
            }
            if (isset($category->parent_id) && $category->parent_id && isset($categories[$category->parent_id])) {
                $parent_id = $category->parent_id;
            } else {
                $parent_id = 0;
            }
            $categories[$parent_id]->children[]= $category;
        }

        // var_dump($categories);exit;

        return $categories[0]->children;
    }

    public static function getTreeLeafs($divider = ' - ') {
        $tree = static::getTree();

        $leafs = [];

        $detector = function($detector, $branches, $prefix = '') use (&$leafs, $divider) {
            foreach ($branches as $branch) {
                $name = ($prefix == ''?'': ($prefix.$divider)).$branch->name;
                if (count($branch->children) < 1) {
                    $leafs[$name] = $branch;
                    continue;
                }

                $detector($detector, $branch->children, $name);
            }
        };

        $detector($detector, $tree);

        return $leafs;
    }

}
