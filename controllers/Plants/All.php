<?php
namespace Controllers\Plants;

use Controllers\Base;
use Models\Plant;

/**
 * Plants List
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class All extends Base{
    
    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.plants.index';
    }
    
    protected function onAJAX(\Controllers\Request $input) {
        return Plant::all()->toArray();
    }


    protected function onPost(\Controllers\Request $input) {
        
        return parent::onPost($input);
    }


    protected function onGet(\Controllers\Request $input) {
        $this->data['plants'] = Plant::orderBy('name')->paginate(25, ['*'], 'subpage');
        return parent::onGet($input);
    }
}
