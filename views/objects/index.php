@extends('layouts.admin')

@section('body')
<h1>Lista de obiecte</h1>
@include("objects.nav")
<?php
if (session('destroy-success')):
    $message = 'Object deleted';
    ?>
@include('snipets.warning')
    <?php
endif;
?>
<table class="table">
    <thead>
        <tr>
            <th>Nume</th>
            <th>Denumire stiintifica</th>
            <th>Optiuni</th>
        </tr>
    </thead>
    <tbody>
        <?php
        /* @var $obj \App\GardenObject */
        foreach ($garden_objects as $obj):
            ?>
        <tr>
            <td><?= $obj->name ?></td>
            <td><?= $obj->scientific?></td>
            <td>
                <a href="<?= route('admin.objects.edit',$obj->id) ?>">Edit</a>
                <form action="<?= route('admin.objects.destroy', $obj->id)?>" style="display:inline" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-link">Sterge</button>
                </form>
            </td>
        </tr>
            <?php
        endforeach;
        ?>
    </tbody>
</table>
@stop