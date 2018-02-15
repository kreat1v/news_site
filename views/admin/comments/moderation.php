<?php

$router = \App\Core\App::getRouter();

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <h2>Moderate comments</h2>
    </div>
</div>

<div class="row my-margin-bottom mt-5">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col" class="col-3">Date</th>
            <th scope="col" class="col-9">Comments</th>
        </tr>
        </thead>
        <tbody>
		<?php foreach ($data as $comments): ?>
            <tr>
                <td class="col-3">
					<?=date('d.m.y H:i', strtotime($comments['date']))?>
                </td>
                <td class="col-9">
					<?=$comments['messages']?>
                    <a class="btn btn-sm btn-success" style="float: right; margin-left: 10px" href="<?=$router->buildUri('edit', [$comments['id']])?>">Edit</a>
                </td>
            </tr>
		<?php endforeach; ?>
        </tbody>
    </table>
</div>