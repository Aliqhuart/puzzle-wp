<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace Controllers\Modules;

use Controllers\Base;
use Models\Module;

/**
 * Edit module page page
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Update extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.modules.edit';
    }

    protected function onPost(\Controllers\Request $input) {

        $id = $input->get('id');

        $this->data['update_success'] = false;

        try {
            $obj = Module::createFromInput($input, $id);
            $this->data['update_success'] = true;
        } catch (\App\Exceptions\Validation $ex) {
            dd ($ex);
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            dd ($ex);
            $this->errors->add('update-error', $ex->getMessage());
        }

        return parent::onPost($input);
    }

    protected function onGet(\Controllers\Request $input) {
        $id = $this->input->get('id');
        $this->data['module'] = Module::find($id);

        if (!$this->data['module']) {
            return $this->redirect($this->plugin->modules_url());
        }
        return parent::onGet($input);
    }

}
