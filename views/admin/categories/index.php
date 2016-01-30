@extends('layouts.wordpress-admin')
@section('body')
@include("admin.categories.nav")
<?php
if (session('destroy-success')):
    $message = 'Sol sters';
    ?>
@include('snipets.warning')
    <?php
endif;
?>
<table class="table">
    <thead>
        <tr>
            <th>Nume</th>
            <th>Optiuni</th>
        </tr>
    </thead>
    <tbody>
        <?php
        /* @var $category \App\Model\Category */
        foreach ($categories as $category):
            ?>
        <tr>
            <td><?= $category->name ?></td>
            <td>
                <a href="<?= $plugin->categories_url('update',['id'=> $category->id]) ?>">Edit</a>
                <a href="<?= $plugin->categories_url('delete',['id'=> $category->id]) ?>">Sterge</a>
            </td>
        </tr>
            <?php
        endforeach;
        ?>
    </tbody>
</table>
@stop