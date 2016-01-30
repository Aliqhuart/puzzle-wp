<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Admin\Pages;

/**
 * Description of Admin
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Admin extends Base{
    
    public function __construct(\App\Admin\Plugin $plugin) {
        parent::__construct($plugin);
        $this->view = 'admin.main';
    }
}
