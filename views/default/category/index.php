<?php

/** @var array $data from \App\Views\Base::render() */

use \App\Core\Config;

$router = \App\Core\App::getRouter();

?>
<div class="row">
    <div class="col-12 d-flex justify-content-center">
        <h1>Welcome to homepage</h1>
    </div>
</div>

<div class="row">
    <div class="col-12 d-flex justify-content-center">
    <div id="carouselExampleIndicators" class="my-carousel carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
	        <?php for ($i = 0; $i < count($data['carousel']); $i++): ?>
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="<?=$i==0 ? "active" : ""?>"></li>
	        <?php endfor; ?>
        </ol>

        <div class="carousel-inner">
	        <?php for ($i = 0; $i < count($data['carousel']); $i++): ?>
            <div class="carousel-item <?=$i==0 ? "active" : ""?>">
                <?php $images = array_values(array_diff(scandir(Config::get('gallery') . $data['carousel'][$i]['img_dir']), ['.', '..']));?>
                <img class="d-block w-100 img-thumbnail" src="<?=\App\Core\Config::get('imgDir') . $data['carousel'][$i]['img_dir'] . DS . $images[0]?>" alt="slide">
                <div class="carousel-caption d-none d-md-block">
                    <h3><a href="<?=$router->buildUri('news.view', [$data['carousel'][$i]['id']])?>"><?=$data['carousel'][$i]['title']?></a></h3>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    </div>

    <div class="col-12">
	    <?php foreach ($data['category'] as $category): ?>
        <div class="list-group pt-3">
            <a href="<?=$router->buildUri('view', [$category['id'], 1])?>" class="list-group-item list-group-item-action active">
	            <?=$category['title']?>
            </a>
	        <?php foreach ($data['news'][$category['id']] as $news): ?>
            <a href="<?=$router->buildUri('news.view', [$news['id']])?>" class="list-group-item list-group-item-action">
	            <?=$news['title']?>
            </a>
	        <?php endforeach; ?>
        </div>
	    <?php endforeach; ?>
    </div>

    <div class="col-12">
        <div class="list-group pt-3">
            <p class="list-group-item list-group-item-action active border-danger bg-danger">
                Top Commentators
            </p>
            <?php foreach ($data['topUser'] as $top): ?>
            <a href="<?=$router->buildUri('search.users', [$top['id'], 1])?>" class="list-group-item list-group-item-action">
                <span class="badge badge-primary badge-pill bg-danger mr-3"><?=$top['count']?></span><?=$top['firstName'] . ' ' . $top['secondName'] . ', ' . $top['email']?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="col-12">
        <div class="list-group pt-3">
            <p class="list-group-item list-group-item-action active border-danger bg-danger">
                Top News
            </p>
			<?php foreach ($data['topNews'] as $topNews): ?>
                <a href="<?=$router->buildUri('news.view', [$topNews['id']])?>" class="list-group-item list-group-item-action">
                    <?=$topNews['title']?>
                </a>
			<?php endforeach; ?>
        </div>
    </div>
</div>