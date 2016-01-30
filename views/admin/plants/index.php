@extends('layouts.wordpress-admin')
@section('body')
@include("admin.plants.nav")
<?php
if (session('destroy-success')):
    $message = 'Sol sters';
    ?>
    @include('snipets.warning')
    <?php
endif;
?>
<table class="table wp-list-table striped">
    <thead>
        <tr>
            <th>Nume</th>
            <th>Denumire stiintifica</th>
            <th>Imagine</th>
            <th>Optiuni</th>
        </tr>
    </thead>
    <tbody>
        <?php
        /* @var $plant \App\Model\Plant */
        foreach ($plants as $plant):
            ?>
            <tr>
                <td>
                    <?= $plant->name ?>
                </td>
                <td>
                    <?= $plant->scientific ?>
                </td>
                <td>
                    <?php
                    
                    $imgOptions = ['height' => 100];
                    $imgUrl = $plant->getPrefferedUrl($imgOptions);
                    ?>
                    <?php if ($imgUrl): ?>
                        <img src="<?= $imgUrl ?>" />
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= $plugin->plants_url('update', ['id' => $plant->id]) ?>">Edit</a>
                    <a href="<?= $plugin->plants_url('delete', ['id' => $plant->id]) ?>">Sterge</a>
                </td>
            </tr>
            <?php
        endforeach;
        ?>
    </tbody>
</table>
@stop