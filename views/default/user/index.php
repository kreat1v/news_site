<?php
// Представление контроллера User - страница профиля.

$router = \App\Core\App::getRouter();
?>
<div class="row">
	<div class="jumbotron mt-3 col-xl-6 col-lg-6 col-md-8 col-12">

		<h1>Your profile</h1>

		<p class="lead"><b>Your first name:</b> <?=$data['firstName']?></p>
		<p class="lead"><b>Your second name:</b> <?=$data['secondName']?></p>
		<p class="lead"><b>Your email:</b> <?=$data['email']?></p>

		<br />
		<a class="btn btn-md btn-primary" href="<?=$router->buildUri('user.edit')?>" role="button">Edit your profile</a>
		<a class="btn btn-md btn-primary" href="<?=$router->buildUri('user.editpassword')?>" role="button">Edit your password</a>

	</div>
</div>