<?php
namespace App\Admin\Pages\Categories;

use App\Admin\Pages\Base;
use App\Models\Category;

/**
 * Categories List
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class All extends Base{

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.categories.index';
    }

    protected function onAJAX(\Illuminate\Http\Request $input) {
        return Category::all()->toArray();
    }


    protected function onPost(\Illuminate\Http\Request $input) {

        return parent::onPost($input);
    }


    protected function onGet(\Illuminate\Http\Request $input) {
        $this->data['categories'] = Category::orderBy('name')->paginate(25, ['*'], 'subpage');
        return parent::onGet($input);
    }
}
