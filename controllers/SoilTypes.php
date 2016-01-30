<?php
namespace Controllers;

use Models\Soil;

/**
 * Description of Admin
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class SoilTypes extends Base{
    
    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.soil.index';
    }
    
    protected function onPost(\Illuminate\Http\Request $input) {
        
        return parent::onPost($input);
    }


    protected function onGet(\Illuminate\Http\Request $input) {
        $this->data['soil_types'] = Soil::orderBy('name')->paginate(25, ['*'], 'subpage');
        return parent::onGet($input);
    }
}
