<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace App\Admin\Pages\Users;

use App\Admin\Pages\Base;
use App\Models\User;

/**
 * delete users page
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Delete extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.users.delete';
    }

    protected function onPost(\Illuminate\Http\Request $input) {

        $id = $input->get('id');

        $this->data['update_success'] = false;

        try {
            User::find($id)->delete();
            $this->data['delete_success'] = true;
            return $this->redirect($this->plugin->users_url());
        } catch (\App\Exceptions\Validation $ex) {
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            $this->errors->add('delete-error', $ex->getMessage());
        }

        return parent::onPost($input);
    }

    protected function onGet(\Illuminate\Http\Request $input) {
        $id = $this->input->get('id');
        $this->data['user'] = User::find($id);
        if (!$this->data['user']) {
            return $this->redirect($this->plugin->users_url());
        }
        return parent::onGet($input);
    }

}
