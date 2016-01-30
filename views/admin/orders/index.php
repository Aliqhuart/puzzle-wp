@extends('layouts.wordpress-admin')
@section('body')
@include("admin.orders.nav")
<?php
if (session('destroy-success')):
    $message = 'Comanda stearsa';
    ?>
    @include('snipets.warning')
    <?php
endif;
?>
<table class="table wp-list-table striped">
    <thead>
        <tr>
            <th>E-Mail</th>
            <th>Prenume</th>
            <th>Nume de familie</th>
            <th>Stare</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $statuses = \App\Models\Order::getStatusValues();
        /* @var $order \App\Model\Order */
        foreach ($orders as $order):
            ?>
            <tr>
                <td>
                    <?= $order->email ?>
                </td>
                <td>
                    <?= $order->firstname ?>
                </td>
                <td>
                    <?= $order->lastname ?>
                </td>
                <td>
                    <?= $statuses[$order->status] ?>
                </td>
                <td>
                    <a href="<?= $plugin->orders_url('update', ['id' => $order->id]) ?>">Edit</a>
                    <a href="<?= $plugin->orders_url('delete', ['id' => $order->id]) ?>">Sterge</a>
                </td>
            </tr>
            <?php
        endforeach;
        ?>
    </tbody>
</table>
@stop