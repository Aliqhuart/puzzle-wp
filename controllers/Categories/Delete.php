<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace App\Admin\Pages\Categories;

use App\Admin\Pages\Base;
use App\Models\Category;

/**
 * delete categories page
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Delete extends Base {

    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.categories.delete';
    }

    protected function onPost(\Illuminate\Http\Request $input) {

        $id = $input->get('id');

        $this->data['update_success'] = false;

        try {
            Category::find($id)->delete();
            $this->data['delete_success'] = true;
            return $this->redirect($this->plugin->categories_url());
        } catch (\App\Exceptions\Validation $ex) {
            $this->data['errors'] = $ex->validator->errors();
        } catch (\Exception $ex) {
            $this->errors->add('delete-error', $ex->getMessage());
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
