<?php

/** @var array $data from \App\Views\Base::render() */

$router = \App\Core\App::getRouter();

?>
<div class="row">
    <div class="col-12">
        <h1>News search</h1>
    </div>
</div>

<form action="<?=$router->buildUri('search.filter')?>" method="post">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="dateFrom">From</label>
            <input type="date" class="form-control" id="dateFrom" name="dateFrom">
            <small class="form-text text-muted">Select the time period of interest.</small>
        </div>
        <div class="form-group col-md-4">
            <label for="dateTo">To</label>
            <input type="date" class="form-control" id="dateTo" name="dateTo">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputState">Tags</label>
            <select id="inputState" class="form-control" name="tags[]" multiple size="3">
                <?php if (isset($data['tags'])):
                    foreach ($data['tags'] as $tags): ?>
                    <option value="<?=$tags['id']?>">#<?=$tags['title']?></option>
                    <?php endforeach;
                endif; ?>
            </select>
            <small class="form-text text-muted">You can select several tags.</small>
        </div>
        <div class="form-group col-md-4">
            <label for="inputState">Category</label>
            <select id="inputState" class="form-control" name="category[]" multiple size="3">
	            <?php if (isset($data['category'])):
		            foreach ($data['category'] as $category): ?>
                    <option value="<?=$category['id']?>"><?=$category['title']?></option>
		            <?php endforeach;
	            endif; ?>
            </select>
            <small class="form-text text-muted">You can select several categories.</small>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Search</button>
</form>

<hr>

<?php if (!empty($data['result'])): ?>
<div class="col-12">
    <div class="list-group pt-3">
        <p class="list-group-item list-group-item-action active">Search results</p>
        <?php foreach ($data['result'] as $news): ?>
            <a href="<?=$router->buildUri('news.view', [$news['id']])?>" class="list-group-item list-group-item-action">
                <?=$news['title']?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php endif;