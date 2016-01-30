<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace App\Models;

/**
 * Description of Order
 *
 * @author Cornel Borina <cornel.borina.ro>
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $user_id
 * @property integer $status
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $phone
 * @property string $details
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereDetails($value)
 */
class Order
        extends \Model {

    use \Models\JsonAttributes;

    const STATUS_CREATED  = 0b001;
    const STATUS_APPROVED = 0b010;
    const STATUS_PAYED    = 0b100;
    const STATUS_CANCELED = 0b000;

    protected static $validationRules    = [
        'firstname' => [
            'required'
        ],
        'lastname'  => [
            'required'
        ],
        'email'     => [
            'required'
        ],
        'phone'     => [
            'required'
        ],
    ];
    protected static $validationMessages = [
        'firstname.required' => 'Te rugăm să introduci numele complet (lipsește prenume)',
        'lastname.required'  => 'Te rugăm să introduci numele complet (lipsește numele de familie)',
        'email.required'     => 'Avem nevoie de adresa de e-mail pentru a confirma comanda',
        'phone.required'     => 'Avem nevoie de telefon pentru a confirma comanda',
    ];
    protected static $availableFields    = [
        'email',
        'firstname',
        'lastname',
        'phone',
        'status',
    ];
    protected static $imageFields        = [
    ];

    public static function boot() {
        parent::boot();
        static::creating(function(Order $order) {
            if (!$order->user_id && \Auth::check()) {
                $order->user_id = \Auth::user()->id;
            }
        });
    }

    public static function createFromInput(\Illuminate\Http\Request $input, $id = null, $save = true) {

        $order = parent::createFromInput($input, $id, false);

        if (\Session::has('user_order')):
            $user_order     = session('user_order');
            $order->details = $user_order;
        endif;

        if ($save) {
            $order->save();
        }

        return $order;
    }

    ////////////////////////////////////////////////////////////////////////////
    // Getters/Setters
    public function getDetailsAttribute() {
        return $this->getJsonAttribute('details');
    }

    public function setDetailsAttribute($value) {
        return $this->setJsonAttribute('details', $value);
    }


    ////////////////////////////////////////////////////////////////////////////
    // Methods

    public function parseDetails() {
        $arrDetails = $this->details;

        $out = (object) [
                    'modules' => [],
                    'soils'   => [],
        ];

        foreach ($arrDetails['modules'] as $id => $jModule) {
            $module            = Module::createFromArray($jModule['module']);
            $out->modules[$id] = (object) [
                        'module'  => $module,
                        'centers' => []
            ];

            foreach ($jModule['centers'] as $rawPoint) {
                $out->modules[$id]->centers[] = new \App\Geometry\Point($rawPoint);
            }
        }

        foreach ($arrDetails['soils'] as $id => $jSoil) {

            $soil = null;

            if ($jSoil['soil']) {
                $soil = Soil::createFromArray($jSoil['soil']);
            }

            $out->soils[$id] = (object) [
                        'soil'     => $soil,
                        'poligons' => [],
                        'area'     => 0
            ];

            foreach ($jSoil['poligons'] as $pId => $jPoly) {
                $polygon                         = new \App\Geometry\Polygon($jPoly['points']);
                $out->soils[$id]->poligons[$pId] = $polygon;
                $out->soils[$id]->area+= $polygon->getArea();
            }
        }

        return $out;
    }

    ////////////////////////////////////////////////////////////////////////////
    // DB relationships
    ////////////////////////////////////////////////////////////////////////////
    // Image relationships
    ////////////////////////////////////////////////////////////////////////////
    // static

    public static function getStatusValues() {
        return [
            static::STATUS_CREATED  => 'Nou',
            static::STATUS_APPROVED => 'Aprobat',
            static::STATUS_PAYED    => 'Plătit',
            static::STATUS_CANCELED => 'Anulat',
        ];
    }

    public static function expandDetails(\Illuminate\Http\Request $request) {
        return (object) [
                    'soils'   => static::expandSoils($request->get('soils')),
                    'modules' => static::expandModules($request->get('modules')),
        ];
    }

    public static function expandSoils($inputSoils) {
        $rawSoils = json_decode(stripslashes($inputSoils), true);

        $soilsIds = array_unique(array_pluck($rawSoils, 's'));

        $soils = [];
        if (count($soilsIds)) {
            $soils = Soil::byId(Soil::whereIn('id', $soilsIds)->get());
        }

        $perimeters = [];

        foreach ($rawSoils as $rawPerimeter) {
            $soil   = NULL;
            $points = new \App\Geometry\Polygon();

            if (isset($rawPerimeter['p'])) {
                foreach ($rawPerimeter['p'] as $rawPoint) {
                    $points->addPoint($rawPoint);
                }
            }

            $soil_id = array_get($rawPerimeter, 's', 0);

            if (isset($rawPerimeter['s']) && isset($soils[$rawPerimeter['s']])) {
                $soil = array_get($soils, $rawPerimeter['s'], NULL);
            }

            if (!isset($perimeters[$soil_id])) {
                $perimeters[$soil_id] = (object) [
                            'soil'     => $soil,
                            'poligons' => [],
                            'area'     => 0
                ];
            }

            $perimeters[$soil_id]->poligons[] = $points;
            $perimeters[$soil_id]->area += $points->getArea();
        }

        return $perimeters;
    }

    public static function expandModules($inputModules) {
        $rawModules = json_decode(stripslashes($inputModules), true);

        $moduleIDs = array_unique(array_pluck($rawModules, 'm'));
        $modules   = Module::byId(Module::whereIn('id', $moduleIDs));

        $out = [];
        foreach ($rawModules as $raw) {
            if (!isset($modules[$raw['m']])) {
                continue;
            }

            if (!isset($out[$raw['m']])) {
                $out[$raw['m']] = (object) [
                            'module'  => $modules[$raw['m']],
                            'centers' => []
                ];
            }

            $out[$raw['m']]->centers[] = new \Geometry\Point($raw['p']);
        }

        return $out;
    }

}
