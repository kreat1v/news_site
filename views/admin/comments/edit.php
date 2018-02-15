<?php

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
	    <h2>Edit comments</h2>
    </div>
</div>

<div class="row my-margin-bottom">
    <div class="col-12 pt-3">
        <p>Category - <b><?=$data['category']['title']?></b></p>
        <form action="" method="post">
            <div class="form-group">
                <label for="content">Comments - <b><?=$data['user']['firstName'] . ' ' . $data['user']['secondName'] . ', ' . $data['user']['email']?></b></label>
                <textarea rows="5" id="content" name="messages" class="form-control"><?=$data['comments']['messages']?></textarea>
            </div>
            <div class="form-group">
                <label for="active">Active?</label>
                <input type="checkbox" value="1" id="active" name="active" <?=!empty($data['comments']['active']) ? 'checked' : ''?> />
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>