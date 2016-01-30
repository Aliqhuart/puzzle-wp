<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace Controllers\Soil;

use Controllers\Base;
use Models\Soil;

/**
 * Create soil page
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Create extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.soil.create';
    }

    protected function onPost(\Controllers\Request $input) {

        $this->data['create_success'] = false;

        try {
            $obj = Soil::createFromInput($input);
            $this->data['create_success'] = true;
            $this->view = 'admin.soil.edit';
            $this->dta['soil_type'] = $obj;
            return $this->redirect($this->plugin->soil_url('update', ['id' => $obj->id]));
        } catch (\Exceptions\Validation $ex) {
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            $this->errors->add('create-error', $ex->getMessage());
        }
        
        return parent::onPost($input);
    }

    protected function onGet(\Controllers\Request $input) {
        $this->data['soil_types'] = Soil::all();
        return parent::onGet($input);
    }

}
