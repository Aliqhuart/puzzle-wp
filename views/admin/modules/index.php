@extends('layouts.wordpress-admin')
@section('body')
@include("admin.modules.nav")
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
            <th>Imagine</th>
            <th>Optiuni</th>
        </tr>
    </thead>
    <tbody>
        <?php
        /* @var $module \App\Model\Module */
        foreach ($modules as $module):
            ?>
            <tr>
                <td>
                    <?= $module->name ?>
                </td>
                <td>
                    <?php if ($module->top_image_hash): ?>
                        <img src="<?= $module->top_image->url(['height' => 100]) ?>" />
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= $plugin->modules_url('update', ['id' => $module->id]) ?>">Edit</a>
                    <a href="<?= $plugin->modules_url('delete', ['id' => $module->id]) ?>">Sterge</a>
                </td>
            </tr>
            <?php
        endforeach;
        ?>
    </tbody>
</table>
    <?= $modules->appends(Request::all())->render() ?>
@stop