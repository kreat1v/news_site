<?php

$isNew = empty($data['news']) || isset($data['news']['new']);

$router = \App\Core\App::getRouter();

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
	    <h2><?=$isNew ? 'Create' : 'Edit'?></h2>
    </div>
</div>

<div class="row my-margin-bottom">
    <div class="col-12 pt-3">
        <form action="" enctype="multipart/form-data" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?=isset($data['news']['title']) ? $data['news']['title'] : ''?>" class="form-control" />
            </div>

            <div class="form-group">
                <label for="analytics">Analytics?</label>
                <input type="checkbox" value="1" id="analytics" name="analytics" <?=($isNew || $data['news']['analytics'] ? 'checked' : '')?> />
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select name="id_category" class="form-control" id="category">
			        <?php foreach ($data['categoryList'] as $value):
                        if ($value['title'] == 'Analytics'):
                            continue;
			            endif; ?>
                        <option value="<?=$value['id']?>"
					        <?php if (isset($data['news']['id_category'])): ?>
						        <?=$value['id'] == $data['news']['id_category'] ? 'selected' : ''?>
					        <?php endif; ?>
                        ><?=$value['title']?></option>
			        <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea rows="15" id="content" name="content" class="form-control"><?=isset($data['news']['content']) ? $data['news']['content'] : ''?></textarea>
            </div>

            <div class="form-group">
                <label for="tags">Tags</label>
                <select multiple name="tags[]" class="form-control" id="tags">
	                <?php foreach ($data['tagsList'] as $value): ?>
                        <option value="<?=$value['id']?>"
	                        <?php if (isset($data['tags'])):
                                foreach ($data['tags'] as $tags):
                                    if (in_array($value['id'], $tags)):
                                        echo 'selected';
                                    endif;
                                endforeach;
	                        endif; ?>
                        >#<?=$value['title']?></option>
	                <?php endforeach; ?>
                </select>
                <small id="tags" class="form-text text-muted">You can select several tags.</small>
            </div>

	        <?php if (isset($data['news']['img_dir'])): ?>
            <div class="form-group">
                <?php foreach ($data['gallery'] as $key => $img):?>
                    <img src="<?=\App\Core\Config::get('imgDir').$data['news']['img_dir'].DS.$img?>" alt="img" class="img-thumbnail my-img-size">
                <?php endforeach; ?>
            </div>
	        <?php endif; ?>

            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" name="images[]" class="custom-file-input" id="inputGroupFile01" multiple>
                    <label class="custom-file-label" for="inputGroupFile01">Choose file. Your image can not be more than 3 megabytes.</label>
                </div>
            </div>

            <button type="submit" class="btn btn-success" id="button">Save</button>
        </form>
    </div>
</div>