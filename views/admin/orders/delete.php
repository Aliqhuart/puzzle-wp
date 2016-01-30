@extends('layouts.wordpress-admin')
@section('body')
@include("admin.orders.nav")

<form action="<?= $plugin->orders_url('delete', ['id' => $order->id]) ?>" method="POST">

    Esti sigur ca vrei sa stergi aceasta comanda?

    <button type="submit" class="btn-link">Da</button>
    <a href="<?= $plugin->orders_url() ?>">Nu</a>
</form>

@stop