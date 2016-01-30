@extends('layouts.wordpress-admin')
@section('body')
@include("admin.soil.nav")
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
        /* @var $soil \App\Model\Soil */
        foreach ($soil_types as $soil):
            ?>
        <tr>
            <td><?= $soil->name ?></td>
            <td>
                <a href="<?= $plugin->soil_url('update',['id'=> $soil->id]) ?>">Edit</a>
                <a href="<?= $plugin->soil_url('delete',['id'=> $soil->id]) ?>">Sterge</a>
            </td>
        </tr>
        <?php if ($soil->top_image) : ?>
        <tr>
            <td colspan="2" class="soil-demo" style="background-image: url('<?= $soil->top_image->url() ?>')"></td>
        </tr>
        <?php endif; ?>
            <?php
        endforeach;
        ?>
    </tbody>
</table>
@stop