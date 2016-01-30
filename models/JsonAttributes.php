<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace App\Models\Traits;

/**
 * JsonAttributes
 *
 * @author Cornel Borina <cornel@borina.ro>
 */
trait JsonAttributes {

    private $json_cache_fields = [];

    /**
     * Generic method to set JSONed attributes
     * @param string $attribute
     * @param mixed $value
     */
    protected function setJsonAttribute($attribute, $value) {
        try {
            if (is_string($value)) {
                // try to decode the fields, to be sure it's valid JSON
                $decoded = json_decode($value);
                if (is_null($decoded)) {
                    // invalid JSON
                    throw new \BadMethodCallException;
                }
                $this->attributes[$attribute]        = $value;
                $this->json_cache_fields[$attribute] = $decoded;
            } else {
                $encoded = json_encode($value);
                if (FALSE === $encoded) {
                    // Could not be encoded
                    throw new \BadMethodCallException;
                }
                $this->attributes[$attribute]        = $encoded;
                $this->json_cache_fields[$attribute] = $value;
            }
        } catch (\Exception $ex) {
            // Another
            $this->attributes[$attribute]        = '{}';
            $this->json_cache_fields[$attribute] = [];
        }
    }

    /**
     * Generic method to get a JSONed attribute
     * @param string $attribute
     * @return mixed
     */
    protected function getJsonAttribute($attribute) {
        if (!isset($this->json_cache_fields[$attribute])) {
            $this->json_cache_fields[$attribute] = json_decode(array_get($this->attributes, $attribute, '{}'), true);
        }
        if (is_null($this->json_cache_fields[$attribute])) {
            return [];
        }
        return $this->json_cache_fields[$attribute];
    }

}
