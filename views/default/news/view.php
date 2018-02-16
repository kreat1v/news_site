<?php
/** @var array $data from \App\Views\Base::render() */

use App\Core\Session;

$router = \App\Core\App::getRouter();

?>
<div class="row">
    <div class="card mb-3">
        <?php if (isset($data['news']['img_dir'])): ?>
        <img class="card-img-top d-inline-block" src="<?=\App\Core\Config::get('imgDir') . $data['news']['img_dir'] . DS . $data['gallery'][0]?>" alt="Card image cap">
        <?php endif; ?>
        <div class="card-body">
            <h5 class="card-title text-right">
	            <?php if ($data['news']['analytics'] == 1): ?>
                <span class="badge badge-danger mr-2" style="font-size: 15px">analytics</span>
	            <?php endif; ?>
                <?=$data['news']['title']?>
            </h5>
	        <?php if (isset($data['news']['views'])): ?>
            <i class="fas fa-eye text-right"></i> <?=$data['news']['views']?>
	        <?php endif; ?>
	        <?php if (isset($data['nowWatching'])): ?>
            <p class="card-text justify-content-end"><small class="text-muted">now watching <?=$data['nowWatching']?></small></p>
	        <?php endif; ?>
            <p class="card-text"><?=$data['news']['content']?></p>
	        <?php if (isset($data['news']['img_dir'])):
                foreach ($data['gallery'] as $key => $img):
			        if ($key != 0): ?>
                    <img src="<?=\App\Core\Config::get('imgDir') . $data['news']['img_dir'] . DS . $data['gallery'][$key]?>" alt="img" class="img-thumbnail my-image">
                <?php endif;
                endforeach;
	        endif; ?>
            <div class="row clearfix">
                <div class="col-12">
                    <?php if (isset($data['news']['date'])): ?>
                    <p class="card-text text-right"><small class="text-muted"><?=date('d.m.Y H:i', strtotime($data['news']['date']))?></small></p>
                    <?php endif; ?>
                    <?php if (!empty($data['tags'])):
                        foreach ($data['tags'] as $value): ?>
                            <a href="<?=$router->buildUri('search.tags',[$value['title'], 1])?>" class="badge badge-warning">#<?=$value['title']?></a>
                    <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Форма отправки комментариев -->
    <?php if (Session::get('id')):
        if ($data['category']['moderation'] == 1): ?>
            <p class="mt-4 ml-4">Comments in this category of news appear only after the approval of the moderator.</p>
        <?php endif; ?>
        <div class="container mt-3 mb-3">
            <form method="post" action="<?=$router->buildUri('comments.send', [$data['news']['id']])?>">
                <div class="input-group mb-3">
                    <textarea rows="2" maxlength="300" id="content" name="messages" class="form-control" placeholder="Your comment. Enter no more than 300 characters."></textarea>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Send</button>
                    </div>
                </div>
            </form>
        </div>
    <?php else: ?>
	    <?php if ($data['news']['analytics'] == 1): ?>
        <p class="pt-2 pb-2"><a href="<?=$router->buildUri('user.login')?>">Sign</a> in to access the full article.</p>
        <?php else: ?>
        <p class="pt-2 pb-2"><a href="<?=$router->buildUri('user.login')?>">Sign</a> in to leave a comment.</p>
	    <?php endif; ?>
    <?php endif; ?>

    <!-- Вывод комментариев -->
	<?php if (!empty($data['comments'])):
	    if (isset($data['vote'])):
		    $arrayVote = array_flip(array_column($data['vote'], 'id_comments'));
	    endif;

        foreach ($data['comments'] as $comments):
            if ($comments['active'] == 1): ?>
                <div class="my-comment media rounded border border-secondary mb-3 col-12">

                    <!-- Оценки -->
                    <div class="mr-3 d-flex flex-column text-center">
                        <?php if (Session::get('id') && !array_key_exists($comments['id'], $arrayVote)): ?>
                        <span class="pb-1 like" data-comments="<?=$comments['id']?>" data-url="<?=$router->buildUri('comments.vote')?>"><i class="far fa-thumbs-up fa-2x"></i></span>
                        <?php else: ?>
                        <span class="star"><i class="far fa-star fa-2x"></i></span>
                        <?php endif; ?>
                        <span class="rating"><?=$comments['rating']?></span>
                        <?php if (Session::get('id') && !array_key_exists($comments['id'], $arrayVote)): ?>
                        <span class="pt-1 dislike" data-comments="<?=$comments['id']?>" data-url="<?=$router->buildUri('comments.vote')?>"><i class="far fa-thumbs-down fa-2x"></i></span>
                        <?php endif; ?>
                    </div>

                    <!-- Комментарий -->
                    <div class="media-body">
                        <h5 class="mt-0"><?=$comments['firstName'] . ' ' . $comments['secondName']?></h5>
                        <span class="row pl-3 pb-3 email">- <?=$comments['email']?> -</span>
                        <?=$comments['messages']?>
                        <div class="d-flex justify-content-between mt-2">
                            <small class="mr-auto" ><?=date('d.m.Y H:i', strtotime($comments['date']))?></small>
                            <?php if (Session::get('id') == $comments['id_user']): ?>
                            <a class="my-time" data-time="<?=strtotime($comments['date'])?>" data-toggle="collapse" href="#collapseEdit<?=$comments['id']?>" role="button" aria-expanded="false" aria-controls="collapseEdit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (Session::get('id')): ?>
                            <a data-toggle="collapse" href="#collapse<?=$comments['id']?>" role="button" aria-expanded="false" aria-controls="collapse">
                                <i class="fas fa-reply"></i>
                            </a>
                            <?php endif; ?>
                        </div>

                        <!-- Форма редактирования комментариев ответов -->
                        <div class="collapse mt-2" id="collapseEdit<?=$comments['id']?>">
                            <form method="post" action="<?=$router->buildUri('comments.send', [$data['news']['id'], $comments['id']])?>">
                                <div class="input-group mb-3">
                                    <textarea rows="1" maxlength="300" name="messages" class="form-control"><?=$comments['messages']?></textarea>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Форма ответов -->
                        <div class="collapse mt-2" id="collapse<?=$comments['id']?>">
                            <form method="post" action="<?=$router->buildUri('comments.answers', [$data['news']['id'], $comments['id']])?>">
                                <div class="input-group mb-3">
                                    <textarea rows="1" maxlength="150" name="answers" class="form-control" placeholder="Your reply. Enter no more than 150 characters."></textarea>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Ответы -->
                        <?php if (!empty($data['answers'])):?>
                            <hr>
                            <?php foreach ($data['answers'] as $answers):
                                if ($answers['id_comments'] != $comments['id']):
                                    continue;
                                else: ?>
                                <div class="media mt-3  pt-3">
                                    <div class="col-2"></div>
                                    <div class="media-body">
                                        <h6 class="mt-0"><?=$answers['firstName'] . ' ' . $answers['secondName'] . ' - ' . $answers['email']?></h6>
                                        <small><?=$answers['messages']?></small>
                                        <p><small><?=date('d.m.Y H:i', strtotime($answers['date']))?></small></p>
                                    </div>
                                </div>
                                <?php
                                endif;
                            endforeach;
                        endif; ?>
                    </div>
                </div>
        <?php endif;
        endforeach;
	endif; ?>
</div>