<?php // Представление админского контроллера по умолчанию - Index.

$router = \App\Core\App::getRouter();

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <h2>Category management</h2>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12 pt-3">
        <a class="btn btn-lg btn-success" href="<?=$router->buildUri('edit')?>">Create category</a>
    </div>
</div>

<div class="row my-margin-bottom">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12 pt-3">
        <ul class="list-group">
            <li class="list-group-item active">Category List</li>
            <?php foreach ($data as $category): ?>
                <li class="list-group-item">
                    <?=$category['title']?>
                    <?php if ($category['moderation'] == 1): ?>
                    <span class="badge badge-danger ml-2">moderation</span>
                    <?php endif; ?>
                    <a class="btn btn-sm btn-success" style="float: right" href="<?=$router->buildUri('edit', [$category['id']])?>">Edit</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>