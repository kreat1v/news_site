<?php

function __($code, $default = '') {
	return \App\Core\Localization::get($code, $default);
}

function pre($data) {
	echo '<pre>', print_r($data, 1), '</pre>';
}