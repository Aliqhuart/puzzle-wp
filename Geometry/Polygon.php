<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace \Geometry;

/**
 * Description of Polygon
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Polygon {

    public $points = [];

    public function __construct($points = null) {
        if (!is_null($points)) {
            foreach ($points as $point) {
                $this->points[] = new Point($point);
            }
        }
    }

    public function addPoint() {
        $point = call_user_func_array([new Point(), 'init'], func_get_args());

        $this->points[] = $point;
    }

    /**
     * Calculate and return polygon area, in m2 (assuming points are defined in cm2)
     * @return double
     */
    public function getArea() {
        $nrPoints = count($this->points);
        if ($nrPoints < 3) {
            return 0;
        }

        $doubleArea = 0;

        $j = $nrPoints - 1;

        for ($i = 0; $i < $nrPoints; $i ++) {
            $p1 = $this->points[$i];
            $p2 = $this->points[$j];

            $doubleArea+= ($p1->x + $p2->x) * ($p2->y - $p1->y);
            $j = $i;
        }

        return abs($doubleArea / 2.0) / 10000;
    }

    public function toArray() {
        $out = [];

        foreach ($this->points as $point) {
            $out[] = $point->toArray();
        }
        return $out;
    }

    public function toString() {
        return json_encode($this->toArray());
    }
}
