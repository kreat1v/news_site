<?php

/** @var array $data */

use App\Core\Localization;
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

<body style="background-color: <?=\App\Core\Style::get('body.background-color')?> !important; margin-top: 100px">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" style="background-color: <?=\App\Core\Style::get('header.background-color')?> !important;">
        <a class="navbar-brand" href="<?=$router->buildUri('.')?>"><?=__('header.homepage')?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
	            <?=$data['menu']?>
                <li class="nav-item <?php if($router->getController(true) == 'Search' && $router->getAction(true) == 'filter') { ?>active<?php } ?>">
                    <a class="nav-link" href="<?=$router->buildUri('search.filter')?>"><?=__('header.filter')?></a>
                </li>
                <li class="nav-item <?php if($router->getController(true) == 'Contacts' && $router->getAction(true) == 'index') { ?>active<?php } ?>">
                    <a class="nav-link" href="<?=$router->buildUri('contacts.index')?>"><?=__('header.contact_us')?></a>
                </li>
	            <?php if (Session::get('id')):?>
                <li class="nav-item <?php if($router->getController(true) == 'Contacts' && $router->getAction(true) == 'view') { ?>active<?php } ?>">
                    <a class="nav-link" href="<?=$router->buildUri('contacts.view')?>"><?=__('header.messages')?></a>
                </li>
	            <?php endif; ?>
	            <?php if (Session::get('role') == 'admin'):?>
                <li class="nav-item ml-2">
                    <a class="btn btn-outline-success my-2 my-sm-0" href="<?=$router->buildUri('admin.category')?>"><?=__('header.admin')?></a>
                </li>
	            <?php endif; ?>
            </ul>

            <div class="input-group my-search ml-3 mr-3">
                <input type="search" class="form-control" id="search" placeholder="Search" aria-label="Имя получателя" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <a class="btn btn-outline-secondary" id="searchButton" href=""><i class="fas fa-search"></i></a>
                </div>
            </div>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=__('header.language')?></a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="<?=Localization::chooseLang('ru')?>">Русский</a>
                        <a class="dropdown-item" href="<?=Localization::chooseLang('en')?>">English</a>
                    </div>
                </li>
	            <?php if (!Session::get('id')):?>
                <li class="nav-item <?php if($router->getController(true) == 'User' && $router->getAction(true) == 'login') { ?>active<?php } ?>">
                    <a class="nav-link" href="<?=$router->buildUri('user.login')?>"><?=__('header.login')?></a>
                </li>
                <li class="nav-item <?php if($router->getController(true) == 'User' && $router->getAction(true) == 'register') { ?>active<?php } ?>">
                    <a class="nav-link" href="<?=$router->buildUri('user.register')?>"><?=__('header.do_register')?></a>
                </li>
	            <?php endif; ?>
	            <?php if (Session::get('id')):?>
                <li class="nav-item <?php if($router->getController(true) == 'User') { ?>active<?php } ?>">
                    <a class="nav-link" href="<?=$router->buildUri('user.index')?>"><?=__('header.profile') .' | '. Session::get('email')?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=$router->buildUri('user.logout')?>"><?=__('header.logout')?></a>
                </li>
	            <?php endif; ?>
            </ul>
        </div>
    </nav>

	<main class="container main">
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-3 col-12">

            <?=$data['adLeft']?>

            </div>
            <div class="col-xl-8 col-lg-8 col-md-6 col-12">
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
            <div class="col-xl-2 col-lg-2 col-md-3 col-12">

            <?=$data['adRight']?>

            </div>
        </div>
	</main>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hello!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you want to subscribe to the newsletter?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a class="btn btn-primary" href="<?=$router->buildUri('subscription.index')?>">Yes</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hello!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Exit?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a class="btn btn-primary" href="<?=$router->buildUri('subscription.index')?>">Yes</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="container">
        <hr>
        <p>&copy; <?=__('header.homepage')?> <?=date('Y')?></p>
    </footer>
    <script type="application/javascript" src="/js/admin.js"></script>
    <script type="application/javascript" src="/js/close.js"></script>
    <script type="application/javascript" src="/js/ad.js"></script>
    <script type="application/javascript" src="/js/vote.js"></script>
    <script type="application/javascript" src="/js/comments.js"></script>
    <script type="application/javascript" src="/js/search.js"></script>
    <script type="application/javascript" src="/js/jquery.cookie.js"></script>
</body>
</html>