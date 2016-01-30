<?php

namespace \Controllers;

use Models\Module;
use Controllers\Request;
use Models\Soil;
use Geometry\Polygon;

/**
 * PuzzleController
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class PuzzleController
        extends Controller {

    public function getIndex() {

        return view('puzzle.index', $this->data);
    }

    public function getModules(Request $input) {
        $query = \App\Models\Module::query();

        if ($input->has('id')) {
            $id = $input->get('id');
            if (is_array($id)) {
                $query->whereIn('modules.id', $id);
            } else {
                $query->where('modules.id', $id);
            }
        }

        if ($input->has('category_id')) {
            $id = $input->get('category_id');
            $query->leftJoin('modules_categories', 'modules.id', '=', 'modules_categories.module_id');
            if (is_array($id)) {
                $query->whereIn('modules_categories.category_id', $id);
            } else {
                $query->where('modules_categories.category_id', $id);
            }
        }

        $fullModules = $query->select('modules.*')->with('categories')->get();
        $moduleIDs = $fullModules->lists('id');

        $responseImages = [];
        /* SELECT
          mp.module_id,
          SUM(mp.amount * p.price)
          FROM homestead.module_plants as mp
          LEFT JOIN homestead.plants as p on mp.plant_id = p.id
          GROUP BY mp.module_id
          ; */
        $dbPricesQuery = \DB::table('module_plants AS mp')
            ->leftJoin('plants AS p', 'mp.plant_id', '=', 'p.id')
            ->select(['mp.module_id', \DB::raw('SUM(mp.amount * p.price) AS price')])
            ->whereIn('mp.module_id', $moduleIDs)
            ->groupBy('mp.module_id');

        $dbPrices = $dbPricesQuery->get();

        $prices         = [];
        foreach ($dbPrices as $price) {
            $prices[$price->module_id] = $price->price;
        }

        /** @var Module $module */
        foreach ($fullModules as $module) {
            $responseImages[$module->id] = [
                'id'        => $module->id,
                'top_image' => $module->top_image_hash,
                'front_image' => $module->front_image_hash,
                'mature_front_image' => $module->mature_front_image_hash,
                'price'     => array_get($prices, $module->id, 0),
                'height'    => $module->height,
                'width'     => $module->width,
                'categories' => $module->categories->lists('slug', 'id')
            ];
        }

        return response(json_encode($responseImages, JSON_FORCE_OBJECT), 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    public function getSoil() {
        $fullObjects = \App\Models\Soil::all();

        $responseImages = [];

        foreach ($fullObjects as $obj) {
            $responseImages[$obj->id] = [
                'top_image' => $obj->top_image
            ];
        }

        return response(json_encode($responseImages, JSON_FORCE_OBJECT), 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    public function getOrderView() {
        if (!\Session::has('user_order')) {
            return \Redirect::action(static::actionString('getIndex'));
        }
        $this->data['user_order'] = session('user_order');

        return view('puzzle.view', $this->data);
    }

    public function postOrderView(Request $request) {
        \Session::set('user_order', \App\Models\Order::expandDetails($request));

        if (!\Auth::check()) {
            \Session::put('login-url', $request->url());
            return \Redirect::action(Auth\AuthController::actionString('getLogin'))->with('login-reason', 'Trebuie sa ai cont pentru a face comanda');
        }

        return \Redirect::action(static::actionString('getOrderView'));
    }

    public function postOrder(Request $request) {

        try {
            $obj = \App\Models\Order::createFromInput($request);
            return \Redirect::action(PuzzleController::actionString('anyOrderSuccess'))->with('create-success', true);
        } catch (\App\Exceptions\Validation $ex) {
            return \Redirect::back()->withErrors($ex->validator)->withInput();
        } catch (\Exception $ex) {
            return \Redirect::back()->withErrors($ex->getMessage())->withInput();
        }
    }

    public function anyOrderSuccess() {
        return view('puzzle.order-success');
    }

    private function _expandInput($input) {
        $result = [
            'modules' => [],
            'soils'   => [],
        ];

        $soilById = Soil::byId(Soil::all());

        $perimeters = array_get($input, 'soils', []);
        foreach ($perimeters as $poly) {
            $polygon           = new Polygon($poly['p']);
            $soil              = array_get($soilById, array_get($poly, 's', ''), new Soil);
            $result['soils'][] = [
                'polygon' => $polygon,
                'soil'    => $soil,
            ];
        }

        return $result;
    }

}
