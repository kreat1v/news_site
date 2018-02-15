<?php
// Представление контроллера User - редактирование профиля.

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <h1>Editing a profile</h1>
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
                <input type="email" class="form-control" name="email" id="exampleInputEmail1" value="<?=isset($data['email']) ? $data['email'] : ''?>" placeholder="Enter email">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>