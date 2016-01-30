<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <title><?= isset($title)? $title : 'Admin' ?></title>

        <link rel="stylesheet" type="text/css" href="<?= elixir("css/admin.css") ?>">
        @yield("extend-head")
    </head>
    <body>
        <div class="container">
            @include('navbar')
            <div class="col-xs-12">
                @yield("body")
            </div>
        </div>
        
        @yield("extend-body")
    </body>
</html>
