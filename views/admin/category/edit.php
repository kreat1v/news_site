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
                <label for="moderation">Moderation?</label>
                <input type="checkbox" value="1" id="moderation" name="moderation" <?=($isNew || $data['moderation'] ? 'checked' : '')?> />
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>