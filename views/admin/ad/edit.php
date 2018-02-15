<?php

$isNew = empty($data) || isset($data['new']);

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
	    <h2><?=$isNew ? 'Create' : 'Edit'?></h2>
    </div>
</div>

<div class="row my-margin-bottom">
    <div class="col-12 pt-3">
        <form action="" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?=isset($data['title']) ? $data['title'] : ''?>" class="form-control" />
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" value="<?=isset($data['price']) ? $data['price'] : ''?>" class="form-control" />
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea rows="3" maxlength="150" id="content" name="content" class="form-control"><?=isset($data['content']) ? $data['content'] : ''?></textarea>
                <small id="content" class="form-text text-muted">Enter no more than 150 characters.</small>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>