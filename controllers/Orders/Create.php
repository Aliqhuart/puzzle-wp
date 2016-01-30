<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace Controllers\Orders;

use Controllers\Base;
use Models\Order;

/**
 * Create order page
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Create extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.orders.create';
    }

    protected function onPost(\Controllers\Request $input) {

        $this->data['create_success'] = false;

        try {
            $obj                          = Order::createFromInput($input);
            $this->data['create_success'] = true;
            $this->view                   = 'admin.orders.edit';
            $this->data['order']          = $obj;
            return $this->redirect($this->plugin->orders_url('update', ['id' => $obj->id]));
        } catch (\App\Exceptions\Validation $ex) {
            dd ($this->input);
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            $this->errors->add('create-error', $ex->getMessage());
        }

        return parent::onPost($input);
    }

    protected function onGet(\Controllers\Request $input) {
        $this->data['orders'] = Order::all();
        return parent::onGet($input);
    }

}
