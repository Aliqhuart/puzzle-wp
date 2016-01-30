<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace Controllers\Modules;

use Controllers\Base;
use Models\Module;

/**
 * delete modules page
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Delete extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.modules.delete';
    }

    protected function onPost(\Controllers\Request $input) {
        
        $id = $input->get('id');
        
        $this->data['update_success'] = false;

        try {
            Module::find($id)->delete();
            $this->data['delete_success'] = true;
            return $this->redirect($this->plugin->modules_url());
        } catch (\App\Exceptions\Validation $ex) {
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            $this->errors->add('delete-error', $ex->getMessage());
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
