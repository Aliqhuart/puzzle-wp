<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace Controllers\Plants;

use Models\Plant;

/**
 * Description of Search
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Search extends \Controllers\Base{
    
    protected function onAJAX(\Controllers\Request $input) {
        $search = $input->get('search');
        
        if ('' == $search) {
            return Plant::all()->toArray();
        }
        
        $plants = Plant::where('name', 'LIKE', $search . '%')->orWhere('scientific', 'LIKE', $search . '%');
        if ($plants->count()) {
            return $plants->get()->toArray();
        }
        
        $plants = Plant::where('name', 'LIKE', '%' . $search . '%')->orWhere('scientific', 'LIKE', '%' . $search . '%');
        return $plants->get()->toArray();
    }
}
