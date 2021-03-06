<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace Controllers\Orders;

use Controllers\Base;
use Models\Order;

/**
 * delete orders page
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Delete extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.orders.delete';
    }

    protected function onPost(\Controllers\Request $input) {

        $id = $input->get('id');

        $this->data['update_success'] = false;

        try {
            Order::find($id)->delete();
            $this->data['delete_success'] = true;
            return $this->redirect($this->plugin->orders_url());
        } catch (\App\Exceptions\Validation $ex) {
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            $this->errors->add('delete-error', $ex->getMessage());
        }

        return parent::onPost($input);
    }

    protected function onGet(\Controllers\Request $input) {
        $id = $this->input->get('id');
        $this->data['order'] = Order::find($id);
        if (!$this->data['order']) {
            return $this->redirect($this->plugin->orders_url());
        }
        return parent::onGet($input);
    }

}
