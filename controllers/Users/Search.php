<?php

/*
 *  Unless otherwise specified, this is closed-source. Copying without permission is prohibited and may result in legal action with or without this license header
 */

namespace App\Admin\Pages\Users;

use App\Models\User;

/**
 * Description of Search
 *
 * @author Cornel Borina <cornel.borina.ro>
 */
class Search extends \App\Admin\Pages\Base{

    protected function onAJAX(\Illuminate\Http\Request $input) {
        $search = $input->get('search');

        if ('' == $search) {
            return User::all()->toArray();
        }

        $users = User::where('name', 'LIKE', $search . '%')->orWhere('scientific', 'LIKE', $search . '%');
        if ($users->count()) {
            return $users->get()->toArray();
        }

        $users = User::where('name', 'LIKE', '%' . $search . '%')->orWhere('scientific', 'LIKE', '%' . $search . '%');
        return $users->get()->toArray();
    }
}
