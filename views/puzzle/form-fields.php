<?php
if (!isset($order)) {
    $order = new \Models\Order();
}
$value = function($field, $default = "") use ($order) {
    $val = old($field, $order->getAttribute($field));

    if (!$val) {
        return $default;
    }

    return $val;
};
?>
<div class="form-group">
    <label>Nume de familie</label>
    <input type="text" name="lastname" value="<?= $value('lastname', Auth::user()->firstname) ?>" class="form-control">
</div>
<div class="form-group">
    <label>Prenume</label>
    <input type="text" name="firstname" value="<?= $value('firstname', Auth::user()->lastname) ?>" class="form-control">
</div>
<div class="form-group">
    <label>E-Mail</label>
    <input type="email" name="email" value="<?= $value('email', Auth::user()->email) ?>" class="form-control">
</div>
<div class="form-group">
    <label>Telefon</label>
    <input type="tel" name="phone" value="<?= $value('phone', Auth::user()->phone) ?>" class="form-control">
</div>