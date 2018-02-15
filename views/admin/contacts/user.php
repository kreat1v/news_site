<?php

$router = \App\Core\App::getRouter();

?>
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-8 col-12">
        <h2>History of your messages (user messages)</h2>
    </div>
</div>

<div class="row">
    <div class="col-12 pt-3">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Message</th>
            </tr>
            </thead>
            <tbody>
			<?php
			$count = 1;
			foreach ($data as $message):
				?>
                <tr>
                    <th scope="row"><?=$count?></th>
                    <td><?=date('d.m.y H:i', strtotime($message['time']))?></td>
                    <td>
                        <?=$message['messages']?>
                        <a class="btn btn-sm btn-warning" style="float: right; margin-left: 10px" onclick="return confirmDelete()" href="<?=$router->buildUri('delete', [$message['id']])?>">Delete</a>
                        <a class="btn btn-sm btn-success" style="float: right" href="<?=$router->buildUri('edit', [$message['id']])?>">Edit</a>
                    </td>
                </tr>
				<?php
				$count++;
			endforeach;
			?>
            </tbody>
        </table>
    </div>
</div>