<?php

$router = \App\Core\App::getRouter();

?>
<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=__('header.category')?></a>
	<div class="dropdown-menu" aria-labelledby="dropdown01">
		<?php foreach ($data as $value): ?>
		<a class="dropdown-item <?=$value['title'] == 'Analytics' ? 'text-warning' : ''?>" href="<?=$router->buildUri('category.view', [$value['id'], 1])?>"><?=$value['title']?></a>
		<?php endforeach; ?>
	</div>
</li>
