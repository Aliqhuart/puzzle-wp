<?php

use App\User;

if (!isset($user)) {
    $user = new User;
}
?>
<form action="<?= $user->exists
        ? $plugin->users_url('update', ['id' => $user->id])
        : $plugin->users_url('create') ?>" method="POST" enctype="multipart/form-data">
<?= csrf_field() ?>
    <div class="col-xs-12 form-group<?= $errors->has('lastname')
                    ? ' has-error'
                    : '' ?>">
        <label>Nume de familie</label>
        <input name="lastname" type="text" value="<?= old('lastname', $user->lastname) ?>" class="form-control">
    </div>
    <div class="col-xs-12 form-group<?=
    $errors->has('firstname')
            ? ' has-error'
            : ''
    ?>">
        <label>Prenume</label>
        <input name="firstname" type="text" value="<?= old('firstname', $user->firstname) ?>" class="form-control">
    </div>
    <div class="col-xs-12 form-group<?=
    $errors->has('email')
            ? ' has-error'
            : ''
    ?>">
        <label>E-Mail</label>
        <input name="email" type="email" value="<?= old('email', $user->email) ?>" class="form-control">
    </div>
    <div class="col-xs-12 form-group<?=
    $errors->has('password')
            ? ' has-error'
            : ''
    ?>">
        <label>Password</label>
        <input name="password" type="password" value="" class="form-control">
    </div>
    <div class="col-xs-12">
        <button type="submit" class="btn btn-primary">
            Salveaza
        </button>
    </div>
</form>