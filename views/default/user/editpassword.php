<?php
// Представление контроллера User - редактирование пароля.

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <h1>Editing a password</h1>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <form method="post">
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" name="oldPassword" id="exampleInputPassword1" placeholder="Your old password">
            </div>
            <div class="form-group">
                <label for="exampleInputNewPassword1">New password</label>
                <input type="password" class="form-control" name="password" id="exampleInputNewPassword1" placeholder="Your new password">
            </div>
            <div class="form-group">
                <label for="exampleInputConfirmPassword1">Confirm password</label>
                <input type="password" class="form-control" name="confirmPassword" id="exampleInputConfirmPassword1" placeholder="Confirm password">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>