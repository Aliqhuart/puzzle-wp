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
class Update extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.soil.edit';
    }

    protected function onPost(\Controllers\Request $input) {
        
        $id = $input->get('id');
        
        $this->data['update_success'] = false;

        try {
            $obj = Soil::createFromInput($input, $id);
            $this->data['update_success'] = true;
        } catch (\App\Exceptions\Validation $ex) {
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            $this->errors->add('update-error', $ex->getMessage());
        }
        
        return parent::onPost($input);
    }

    protected function onGet(\Controllers\Request $input) {
        $id = $this->input->get('id');
        $this->data['soil_type'] = Soil::find($id);
        
        if (!$this->data['soil_type']) {
            return $this->redirect($this->plugin->soil_url());
        }
        return parent::onGet($input);
    }

}
