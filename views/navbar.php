<?php

use App\Http\Controllers;
?>
<nav id="main-nav" class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= Controllers\PuzzleController::action('getIndex') ?>">Gradina Puzzle</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="<?= Request::is('despre', 'despre/*') ? 'active' : '' ?>"><a href="<?= url('despre') ?>">Despre Noi</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (Auth::check()): ?>
                    <li class="navbar-text"><?= Auth::user()->firstname, ' ', Auth::user()->lastname ?></li>
                    <li><a href="<?= Controllers\Auth\AuthController::action('getLogout') ?>">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?= Controllers\Auth\AuthController::action('getLogin') ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>