<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace Controllers\Plants;

use Controllers\Base;
use Models\Plant;

/**
 * Create plant page
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Create extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.plants.create';
    }

    protected function onPost(\Controllers\Request $input) {

        $this->data['create_success'] = false;

        try {
            $obj = Plant::createFromInput($input);
            $this->data['create_success'] = true;
            $this->view = 'admin.plants.edit';
            $this->data['plant'] = $obj;
            return $this->redirect($this->plugin->plants_url('update', ['id' => $obj->id]));
        } catch (\App\Exceptions\Validation $ex) {
            dd ($this->input);
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            $this->errors->add('create-error', $ex->getMessage());
        }
        
        return parent::onPost($input);
    }

    protected function onGet(\Controllers\Request $input) {
        $this->data['plants'] = Plant::all();
        return parent::onGet($input);
    }

}
