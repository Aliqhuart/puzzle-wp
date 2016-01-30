<?php
namespace App\Admin\Pages\Users;

use App\Admin\Pages\Base;
use App\User;

/**
 * Users List
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class All extends Base{

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.users.index';
    }

    protected function onAJAX(\Illuminate\Http\Request $input) {
        return User::all()->toArray();
    }


    protected function onPost(\Illuminate\Http\Request $input) {

        return parent::onPost($input);
    }


    protected function onGet(\Illuminate\Http\Request $input) {
        $this->data['users'] = User::orderBy('lastname')->orderBy('firstname')->paginate(25, ['*'], 'subpage');
        return parent::onGet($input);
    }
}
