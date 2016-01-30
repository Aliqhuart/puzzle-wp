<?php
namespace Controllers\Modules;

use Controllers\Base;
use Models\Module;

/**
 * Modules List
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class All extends Base{
    
    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.modules.index';
    }
    
    protected function onPost(\Controllers\Request $input) {
        
        return parent::onPost($input);
    }


    protected function onGet(\Controllers\Request $input) {
        $this->data['modules'] = Module::orderBy('name')->paginate(10, ['*'], 'subpage');
        return parent::onGet($input);
    }
}
