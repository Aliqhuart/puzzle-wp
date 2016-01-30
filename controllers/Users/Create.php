<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace App\Admin\Pages\Users;

use App\Admin\Pages\Base;
use App\User;

/**
 * Create user page
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Create extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.users.create';
    }

    protected function onPost(\Illuminate\Http\Request $input) {

        $this->data['create_success'] = false;

        try {
            $obj                          = User::createFromInput($input);
            $this->data['create_success'] = true;
            $this->view                   = 'admin.users.edit';
            $this->data['user']           = $obj;
            return $this->redirect($this->plugin->users_url('update', ['id' => $obj->id]));
        } catch (\App\Exceptions\Validation $ex) {
            dd ($this->input);
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            $this->errors->add('create-error', $ex->getMessage());
        }

        return parent::onPost($input);
    }

    protected function onGet(\Illuminate\Http\Request $input) {
        $this->data['users'] = User::all();
        return parent::onGet($input);
    }

}
