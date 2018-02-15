<?php

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
	    <h1>Newsletter subscription</h1>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <form method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">News categories</label>
                <select size="4" class="custom-select" id="inputGroupSelect04" name="category[]" multiple>
                    <?php foreach ($data['cat'] as $category): ?>
                    <option name="<?=$category['id']?>" value="<?=$category['title']?>"><?=$category['title']?></option>
                    <?php endforeach; ?>
                </select>
                <small id="emailHelp" class="form-text text-muted">You can select several categories.</small>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
</div>