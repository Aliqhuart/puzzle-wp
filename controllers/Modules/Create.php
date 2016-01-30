<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace Controllers\Modules;

use Controllers\Base;
use Models\Module;

/**
 * Create module page
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Create extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.modules.create';
    }

    protected function onPost(\Controllers\Request $input) {

        $this->data['create_success'] = false;

        try {
            $obj = Module::createFromInput($input);
            $this->data['create_success'] = true;
            $this->view = 'admin.modules.edit';
            $this->dta['module'] = $obj;
            return $this->redirect($this->plugin->modules_url('update', ['id' => $obj->id]));
        } catch (\App\Exceptions\Validation $ex) {
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            $this->errors->add('create-error', $ex->getMessage());
        }
        
        return parent::onPost($input);
    }

    protected function onGet(\Controllers\Request $input) {
        $this->data['modules'] = Module::all();
        return parent::onGet($input);
    }

}
