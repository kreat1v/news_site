<?php
// Представление контроллера User - вход.
?>
<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
        <h1>Login</h1>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-6 col-12">
        <form method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" value="<?=isset($data['email']) ? $data['email'] : ''?>" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
</div>