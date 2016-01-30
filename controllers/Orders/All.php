<?php
namespace Controllers\Orders;

use Controllers\Base;
use Models\Order;

/**
 * Orders List
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class All extends Base{

    public function __construct(\Controllers\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.orders.index';
    }

    protected function onAJAX(\Controllers\Request $input) {
        return Order::all()->toArray();
    }


    protected function onPost(\Controllers\Request $input) {

        return parent::onPost($input);
    }


    protected function onGet(\Controllers\Request $input) {
        $this->data['orders'] = Order::orderBy('status', 'desc')->orderBy('created_at', 'asc')->paginate(25, ['*'], 'subpage');
        return parent::onGet($input);
    }
}
