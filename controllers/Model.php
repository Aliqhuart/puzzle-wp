<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * App\Model
 *
 */
class Model extends EloquentModel {

    protected static $validationRules = [];
    protected static $validationMessages = [];
    protected static $availableFields = [];
    protected static $imageFields = [];

    /**
     * Create an object from the provided array or object
     * @param array|object $arrIn
     * @return static
     */
    public static function createFromArray($arrIn) {
        $out = new static();

        foreach ($arrIn as $key=>$value) {
            if (method_exists($out, $key)) {
                // probably a relation
                continue;
            }
            $out->{$key} = $value;
        }

        if ($out->id) {
            $out->exists = true;
        }

        return $out;
    }

    /**
     *
     * @param \Request $input
     * @return static
     */
    public static function createFromInput(Request $input, $id = null, $save = true) {
        $validator = \Validator::make($input->all(), static::$validationRules, static::$validationMessages);
        if ($validator->fails()) {
            throw new \App\Exceptions\Validation($validator);
        }

        $obj = static::findOrNew($id);

        foreach (static::$availableFields as $fieldName) {
            if ($input->has($fieldName)) {
                $obj->setAttribute($fieldName, $input->get($fieldName));
            }
        }

        $imageFields = static::$imageFields;
        foreach ($imageFields as $fieldName) {
            if ($input->hasFile($fieldName)) {
                try {
                    $file = $input->file($fieldName);
                    if (!$file->isValid()) {
                        $validator->errors()->add($fieldName, "Invalid Image");
                        continue;
                    }
                    $dbFile = Image::createFromInput($file);
                    $obj->setAttribute($fieldName, $dbFile->hash);
                } catch (\Exception $ex) {
                    $validator->errors()->add($fieldName, "Invalid Image");
                }
            }
        }

        if ($validator->fails()) {
            throw new \App\Exceptions\Validation($validator);
        }

        if ($save) {
            $obj->save();
        }

        return $obj;
    }

    /**
     * Transform the input collection to associative array where the key is the model PK
     * @param \Iterator $objects
     * @return array
     */
    public static function byId($objects) {
        if (    $objects instanceof \Illuminate\Database\Eloquent\Builder ||
                $objects instanceof \Illuminate\Database\Query\Builder
            ) {
            $objects = $objects->get();
        }
        $results = [];
        foreach ($objects as $obj) {
            if ($obj instanceof EloquentModel) {
                $results[$obj->getKey()] = $obj;
            } else if (is_object($obj) && isset($obj->id)) {
                $results[$obj->id] = $obj;
            } else {
                throw new \BadMethodCallException();
            }
        }

        return $results;
    }

}
