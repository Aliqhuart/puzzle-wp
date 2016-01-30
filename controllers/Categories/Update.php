<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace App\Admin\Pages\Categories;

use App\Admin\Pages\Base;
use App\Models\Category;

/**
 * Edit category page page
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Update extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.categories.edit';
    }

    protected function onPost(\Illuminate\Http\Request $input) {

        $id = $input->get('id');

        $this->data['update_success'] = false;

        try {
            $obj = Category::createFromInput($input, $id);
            $this->data['update_success'] = true;
        } catch (\App\Exceptions\Validation $ex) {
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            $this->errors->add('update-error', $ex->getMessage());
        }

        return parent::onPost($input);
    }

    protected function onGet(\Illuminate\Http\Request $input) {
        $id = $this->input->get('id');
        $this->data['category'] = Category::find($id);

        if (!$this->data['category']) {
            return $this->redirect($this->plugin->categories_url());
        }
        return parent::onGet($input);
    }

}
