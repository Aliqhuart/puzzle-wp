<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace \Geometry;

/**
 * Description of Point
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Point {

    public $x = 0;
    public $y = 0;

    public function __construct() {
        $callback = [$this, 'init'];
        call_user_func_array($callback, func_get_args());
    }

    public function init() {
        $args = func_get_args();
        if (func_num_args() >= 2) {
            $this->x = $args[0];
            $this->y = $args[1];
        } else
        if (func_num_args() == 1) {
            $p = $args[0];
            if (is_object($p)) {
                $this->x = $p->x;
                $this->y = $p->y;
            } else if (is_array($p)) {
                $this->x = array_get($p, 'x', array_get($p, 0, 0));
                $this->y = array_get($p, 'y', array_get($p, 1, 0));
            }
        }

        return $this;
    }

    public function toArray() {
        return [
            'x' => $this->x,
            'y' => $this->y,
        ];
    }

}
