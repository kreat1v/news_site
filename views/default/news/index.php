<?php

/** @var array $data from \App\Views\Base::render() */

$router = \App\Core\App::getRouter();

?>
<div class="row">
    <div class="col-12">
        <h1>All news</h1>
    </div>
</div>

<div class="row">
    <div class="list-group col-12">
        <?php foreach ($data as $news): ?>
        <a href="#" class="list-group-item list-group-item-action">
            <?=$news['title']?>
        </a>
        <?php endforeach; ?>
    </div>
</div>