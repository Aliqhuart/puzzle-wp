<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace Controllers\Categories;

use App\Admin\Pages\Base;
use App\Models\Category;

/**
 * Create category page
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Create extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.categories.create';
    }

    protected function onPost(\Illuminate\Http\Request $input) {

        $this->data['create_success'] = false;

        try {
            $obj = Category::createFromInput($input);
            $this->data['create_success'] = true;
            $this->view = 'admin.categories.edit';
            $this->data['category'] = $obj;
            return $this->redirect($this->plugin->categories_url('update', ['id' => $obj->id]));
        } catch (\App\Exceptions\Validation $ex) {
            dd ($this->input);
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            $this->errors->add('create-error', $ex->getMessage());
        }

        return parent::onPost($input);
    }

    protected function onGet(\Illuminate\Http\Request $input) {
        $this->data['categories'] = Category::all();
        return parent::onGet($input);
    }

}
