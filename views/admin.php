<?php

/** @var array $data */

use App\Core\Session;

$router = \App\Core\App::getRouter();

?><!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=\App\Core\Config::get('siteName')?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/default.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body style="background-color: <?=\App\Core\Style::get('body.background-color')?> !important;">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" style="background-color: <?=\App\Core\Style::get('header.background-color')?> !important;">
            <a class="navbar-brand" href="<?=$router->buildUri('admin.category.index')?>"><?=__('header.homepage')?> Admin Dashboard</a>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-brand mr-auto"></ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$router->buildUri('default.user.index')?>"><?=__('admin_nav.back_profile')?></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light sidebar">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php if($router->getController(true) == 'Category') { ?>active<?php } ?>" href="<?=$router->buildUri('category.index')?>"><?=__('admin_nav.pages_management')?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($router->getController(true) == 'News') { ?>active<?php } ?>" href="<?=$router->buildUri('news.index')?>"><?=__('admin_nav.news')?></a>
                    </li>
                </ul>

                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php if($router->getController(true) == 'Comments' && $router->getAction(true) == 'moderation') { ?>active<?php } ?>" href="<?=$router->buildUri('comments.moderation')?>"><?=__('admin_nav.moderation')?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($router->getController(true) == 'Comments' && $router->getAction(true) == 'index') { ?>active<?php } ?>" href="<?=$router->buildUri('comments.index')?>"><?=__('admin_nav.comments')?></a>
                    </li>
                </ul>

                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php if($router->getController(true) == 'Contacts' && $router->getAction(true) == 'anonymous') { ?>active<?php } ?>" href="<?=$router->buildUri('contacts.anonymous')?>"><?=__('admin_nav.external_messages')?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($router->getController(true) == 'Contacts' && $router->getAction(true) == 'user') { ?>active<?php } ?>" href="<?=$router->buildUri('contacts.user')?>"><?=__('admin_nav.user_messages')?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($router->getController(true) == 'Contacts' && $router->getAction(true) == 'index') { ?>active<?php } ?>" href="<?=$router->buildUri('contacts.index')?>"><?=__('admin_nav.all_messages')?></a>
                    </li>
                </ul>

                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php if($router->getController(true) == 'User') { ?>active<?php } ?>" href="<?=$router->buildUri('user.index')?>"><?=__('admin_nav.users')?></a>
                    </li>
                </ul>

                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php if($router->getController(true) == 'Ad' && $router->getAction(true) == 'left') { ?>active<?php } ?>" href="<?=$router->buildUri('ad.left')?>"><?=__('admin_nav.adLeft')?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($router->getController(true) == 'Ad' && $router->getAction(true) == 'right') { ?>active<?php } ?>" href="<?=$router->buildUri('ad.right')?>"><?=__('admin_nav.adRight')?></a>
                    </li>
                </ul>

                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php if($router->getController(true) == 'Style') { ?>active<?php } ?>" href="<?=$router->buildUri('style.index')?>"><?=__('admin_nav.style')?></a>
                    </li>
                </ul>
            </nav>

            <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
                <div class="container pt-3">
                    <div class="row">
                    <?php if (Session::hasFlash()):
                        foreach (Session::getFlash() as $message): ?>
                            <div class="alert alert-warning col-xl-4 col-lg-4 col-md-6 col-12">
                                <?=$message?>
                            </div>
                        <?php endforeach;
                    endif; ?>
                    </div>
                    <?=$data['content']?>
                </div>
            </main>
        </div>
    </div>

    <script type="application/javascript" src="/js/admin.js"></script>
    <script type="application/javascript" src="/js/subscription.js"></script>
    <script type="application/javascript" src="/js/close.js"></script>
    <script type="application/javascript" src="/js/ad.js"></script>
    <script type="application/javascript" src="/js/vote.js"></script>
    <script type="application/javascript" src="/js/comments.js"></script>
    <script type="application/javascript" src="/js/search.js"></script>
    <script type="application/javascript" src="/js/jquery.cookie.js"></script>

</body>
</html>