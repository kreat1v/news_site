<?php

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
	    <h2>Edit messages</h2>
    </div>
</div>

<?php if (isset($data['messages'])): ?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12 pt-3">
	    <p>Message from <?=$data['email']?></p>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <form action="" method="post">
            <div class="form-group">
                <label for="exampleInputMessages1">Messages</label>
                <textarea rows="5" name="messages" id="exampleInputMessages1" class="form-control"><?=isset($data['messages']) ? $data['messages'] : ''?></textarea>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>