<?php

/** @var array $data from \App\Views\Base::render() */

$router = \App\Core\App::getRouter();
$category = $router->getParams()[0];

?>
<div class="row">
    <div class="col-12">
        <h1><?=$data['category']['title']?></h1>
    </div>
</div>

<div class="row">
    <div class="list-group col-12">
        <?php foreach ($data['news'] as $news): ?>
            <a href="<?=$router->buildUri('news.view', [$news['id']])?>" class="list-group-item list-group-item-action">
                <?=$news['title']?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Pagination -->
<?php if ($data['pagination']): ?>
<div class="row pt-3">
    <nav aria-label="">
        <ul class="pagination">
            <li class="page-item <?=$data['pagination']['back'] ? '' : 'disabled'?>">
                <a class="page-link" href="<?=$data['pagination']['back'] ? $router->buildUri('category.view', [$category, 1]) : ''?>" aria-label="First">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <li class="page-item <?=$data['pagination']['back'] ? '' : 'disabled'?>">
                <a class="page-link" href="<?=$data['pagination']['back'] ? $router->buildUri('category.view', [$category, $data['pagination']['back']]) : ''?>" tabindex="-1">Previous</a>
            </li>

            <?php foreach ($data['pagination']['middle'] as $key => $value): ?>
            <li class="page-item <?=$router->getParams()[1] == $key ? 'active' : ''?>">
                <a class="page-link" href="<?=$router->buildUri('category.view', [$category, $key])?>"><?=$key?></a>
            </li>
            <?php endforeach; ?>

            <li class="page-item <?=$data['pagination']['forward'] ? '' : 'disabled'?>">
                <a class="page-link" href="<?=$data['pagination']['forward'] ? $router->buildUri('category.view', [$category, $data['pagination']['forward']]) : ''?>">Next</a>
            </li>

            <li class="page-item <?=$data['pagination']['forward'] ? '' : 'disabled'?>">
                <a class="page-link" href="<?=$router->buildUri('category.view', [$category, $data['pagination']['last']])?>" aria-label="Last">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php endif; ?>