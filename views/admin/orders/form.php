<?php

use Models\Order;

if (!isset($order)) {
    $order = new Order;
}
?>
<form action="<?=
$order->exists
        ? $plugin->orders_url('update', ['id' => $order->id])
        : $plugin->orders_url('create')
?>" method="POST" enctype="multipart/form-data">
          <?= csrf_field() ?>
    <div class="col-xs-12 form-group<?=
    $errors->has('lastname')
            ? ' has-error'
            : ''
    ?>">
        <label>Nume de familie</label>
        <input name="lastname" type="text" value="<?= old('lastname', $order->lastname) ?>" class="form-control">
    </div>
    <div class="col-xs-12 form-group<?=
    $errors->has('firstname')
            ? ' has-error'
            : ''
    ?>">
        <label>Prenume</label>
        <input name="firstname" type="text" value="<?= old('firstname', $order->firstname) ?>" class="form-control">
    </div>
    <div class="col-xs-12 form-group<?=
    $errors->has('email')
            ? ' has-error'
            : ''
    ?>">
        <label>E-Mail</label>
        <input name="email" type="email" value="<?= old('email', $order->email) ?>" class="form-control">
    </div>
    <div class="col-xs-12 form-group<?=
    $errors->has('phone')
            ? ' has-error'
            : ''
    ?>">
        <label>Telefon</label>
        <input name="phone" type="tel" value="<?= old('phone', $order->phone) ?>" class="form-control">
    </div>
    <div class="col-xs-12 form-group<?=
    $errors->has('status')
            ? ' has-error'
            : ''
    ?>">
        <label>Stare</label>
        <select name="status" class="form-control">
            <?php
            $availableStatuses = Order::getStatusValues();
            foreach ($availableStatuses as $status => $display):
                ?>
                <option value="<?= $status ?>"<?=
                $status == $order->status
                        ? ' selected'
                        : ''
                ?>><?= $display ?></option>
                        <?php
                    endforeach;
                    ?>
        </select>
    </div>
    <div class = "col-xs-12">
        <button type = "submit" class = "btn btn-primary">
            Salveaza
        </button>
    </div>
</form>