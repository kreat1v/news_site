<?php

$router = \App\Core\App::getRouter();

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <h2>Style management</h2>
    </div>
</div>

<div class="row mt-4">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12 pt-3">
        <form action="<?=$router->buildUri('style.default')?>" method="post">
            <button type="submit" class="btn btn-primary">Default color theme</button>
        </form>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <h4>Choose colors</h4>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12 pt-3">
        <form action="<?=$router->buildUri('style.edit')?>" method="post">
            <div class="form-group">
                <label for="color" class="mr-3">Header: </label>
                <input type="color" id="color" name="colorHeader" value="#ff0000" class="form-control">
            </div>
            <div class="form-group">
                <label for="color2" class="mr-3">Background: </label>
                <input type="color" id="color2" name="colorBody" value="#ff0000" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <h4>Or use an already prepared color scheme</h4>
    </div>
</div>

<div class="row mb-3">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12 pt-3">
        <form action="<?=$router->buildUri('style.theme')?>" method="post">
            <div class="form-group">
                <label for="exampleFormControlSelect1">Theme</label>
                <select class="form-control" name="theme" id="exampleFormControlSelect1">
                    <option value="red">Red</option>
                    <option value="green">Green</option>
                    <option value="gold">Gold</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>