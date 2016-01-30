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
class Delete extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.soil.delete';
    }

    protected function onPost(\Controllers\Request $input) {
        
        $id = $input->get('id');
        
        $this->data['update_success'] = false;

        try {
            Soil::find($id)->delete();
            $this->data['delete_success'] = true;
            $this->view = 'admin.soil.index';
            $this->data['soil_types'] = Soil::all();
        } catch (\Exceptions\Validation $ex) {
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            $this->errors->add('delete-error', $ex->getMessage());
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
