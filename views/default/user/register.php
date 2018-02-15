<?php
// Представление контроллера User - регистрация.
?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
	    <h1>Registration</h1>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <form method="post">
            <div class="form-group">
                <label for="exampleInputFirstName1">First name</label>
                <input type="text" class="form-control" name="firstName" id="exampleInputFirstName1" value="<?=isset($data['firstName']) ? $data['firstName'] : ''?>" placeholder="First name">
            </div>
            <div class="form-group">
                <label for="exampleInputSecondName1">Second name</label>
                <input type="text" class="form-control" name="secondName" id="exampleInputSecondName1" value="<?=isset($data['secondName']) ? $data['secondName'] : ''?>" placeholder="Second name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" value="<?=isset($data['email']) ? $data['email'] : ''?>" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputConfirmPassword1">Confirm password</label>
                <input type="password" class="form-control" name="confirmPassword" id="exampleInputConfirmPassword1" placeholder="Confirm password">
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
</div>