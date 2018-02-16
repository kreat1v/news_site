<?php

$router = \App\Core\App::getRouter();

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <h2>News management</h2>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12 pt-3">
        <a class="btn btn-lg btn-success" href="<?=$router->buildUri('edit')?>">Create news</a>
    </div>
</div>

<div class="row my-margin-bottom">
    <div class="col-xl-10 col-lg-10 col-md-12 col-12 pt-3">
        <ul class="list-group">
            <li class="list-group-item active">Pages List</li>
            <?php foreach ($data as $news): ?>
                <li class="list-group-item">
                    <?=$news['id'] . '. ' . $news['title']?>
	                <?php if ($news['analytics'] == 1): ?>
                    <span class="badge badge-danger ml-2">analytics</span>
	                <?php endif; ?>
                    <a class="btn btn-sm btn-success" style="float: right; margin-left: 10px" href="<?=$router->buildUri('edit', [$news['id']])?>">Edit</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>