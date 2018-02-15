<?php

$router = \App\Core\App::getRouter();

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <h2>Ad management (left side)</h2>
        <small>You can add up to 4 ad units.</small>
    </div>
</div>

<?php if(count($data) < 4): ?>
<div class="row pt-3">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12 pt-3">
        <a class="btn btn-lg btn-success" href="<?=$router->buildUri('edit', ['right'])?>">Create ad</a>
    </div>
</div>
<?php endif; ?>

<div class="row my-margin-bottom">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12 pt-3">
        <ul class="list-group">
            <li class="list-group-item active">Ad List</li>
            <?php foreach ($data as $ad): ?>
                <li class="list-group-item">
                    <?=$ad['title']?>
                    <a class="btn btn-sm btn-success" style="float: right; margin-left: 10px" href="<?=$router->buildUri('edit', ['right', $ad['id']])?>">Edit</a>
                    <a class="btn btn-sm btn-warning" style="float: right" onclick="return confirmDelete()" href="<?=$router->buildUri('delete', ['right', $ad['id']])?>">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>