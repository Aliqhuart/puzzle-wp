<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace Controllers\Plants;

use Controllers\Base;
use Models\Plant;

/**
 * Edit plant page page
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Update extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.plants.edit';
    }

    protected function onPost(\Controllers\Request $input) {
        
        $id = $input->get('id');
        
        $this->data['update_success'] = false;

        try {
            $obj = Plant::createFromInput($input, $id);
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
        $this->data['plant'] = Plant::find($id);
        
        if (!$this->data['plant']) {
            return $this->redirect($this->plugin->plants_url());
        }
        return parent::onGet($input);
    }

}
