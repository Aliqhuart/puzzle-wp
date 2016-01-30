<?php
if (!isset($order)) {
    $order           = new \Models\Order();
    $order->email = '';
    $order->password = '';
    $order->address = '';
}
?>
<form action="<?= App\Http\Controllers\PuzzleController::action('postOrder') ?>" method="POST">
    <?= csrf_field() ?>
    @include('puzzle.form-fields')
    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            Comandă
        </button>
    </div>
</form>