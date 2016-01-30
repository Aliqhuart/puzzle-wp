@extends('layouts.wordpress-admin')
@section('body')
@include("admin.users.nav")
<?php
if (session('destroy-success')):
    $message = 'Users sters';
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
        </tr>
    </thead>
    <tbody>
        <?php
        /* @var $user \App\Model\User */
        foreach ($users as $user):
            ?>
            <tr>
                <td>
                        <?= $user->email ?>
                    </td>
                    <td>
                        <?= $user->firstname ?>
                    </td>
                    <td>
                        <?= $user->lastname ?>
                    </td>
                    <td>
                            <a href="<?= $plugin->users_url('update', ['id' => $user->id]) ?>">Edit</a>
                        <a href="<?= $plugin->users_url('delete', ['id' => $user->id]) ?>">Sterge</a>
                    </td>
            </tr>
            <?php
        endforeach;
        ?>
    </tbody>
</table>
@stop