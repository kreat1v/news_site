<?php

/** @var array $data from \App\Views\Base::render() */

$router = \App\Core\App::getRouter();
$users = $router->getParams()[0];

?>
<div class="row">
    <div class="col-12">
        <h1><?=$data['userComments']['firstName'] . ' ' . $data['userComments']['secondName'] . ', ' . $data['userComments']['email']?></h1>
    </div>
</div>

<div class="row">
	<?php foreach ($data['commentsSection'] as $comment): ?>
        <div class="my-comment media rounded border border-secondary mb-3 col-12">
            <div class="mr-3 d-flex flex-column text-center">
                <span class="star"><i class="far fa-star fa-2x"></i></span>
                <span class="rating"><?=$comment['rating']?></span>
            </div>
            <div class="media-body">
				<?=$comment['messages']?>
                <div class="d-flex justify-content-between mt-2">
                    <small class="mr-auto" ><?=date('d.m.Y H:i', strtotime($comment['date']) - 3600)?></small>
                </div>
            </div>
        </div>
	<?php endforeach; ?>
</div>

<!-- Pagination -->
<?php if ($data['pagination']): ?>
<div class="row pt-3">
    <nav aria-label="">
        <ul class="pagination">
            <li class="page-item <?=$data['pagination']['back'] ? '' : 'disabled'?>">
                <a class="page-link" href="<?=$data['pagination']['back'] ? $router->buildUri('search.users', [$users, 1]) : ''?>" aria-label="First">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <li class="page-item <?=$data['pagination']['back'] ? '' : 'disabled'?>">
                <a class="page-link" href="<?=$data['pagination']['back'] ? $router->buildUri('search.users', [$users, $data['pagination']['back']]) : ''?>" tabindex="-1">Previous</a>
            </li>

            <?php foreach ($data['pagination']['middle'] as $key => $value): ?>
            <li class="page-item <?=$router->getParams()[1] == $key ? 'active' : ''?>">
                <a class="page-link" href="<?=$router->buildUri('search.users', [$users, $key])?>"><?=$key?></a>
            </li>
            <?php endforeach; ?>

            <li class="page-item <?=$data['pagination']['forward'] ? '' : 'disabled'?>">
                <a class="page-link" href="<?=$data['pagination']['forward'] ? $router->buildUri('search.users', [$users, $data['pagination']['forward']]) : ''?>">Next</a>
            </li>

            <li class="page-item <?=$data['pagination']['forward'] ? '' : 'disabled'?>">
                <a class="page-link" href="<?=$router->buildUri('search.users', [$users, $data['pagination']['last']])?>" aria-label="Last">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php endif; ?>