<?php

use App\Core\Config;

/**
 * Routing
 */
Config::set('routes', ['default', 'admin']);
Config::set('defaultRoute', 'default');
Config::set('defaultController', 'category');
Config::set('defaultAction', 'index');  

/**
 * Languages
 */
Config::set('languages', ['en', 'ru']);
Config::set('defaultLanguage', 'en');

/**
 * Debug
 */
Config::set('debug', true);

/**
 * Meta
 */
Config::set('siteName', 'Новостной сайт');

/**
 * Database
 */
Config::set('db.host', 'localhost:3306');
Config::set('db.user', 'root');
Config::set('db.password', '');
Config::set('db.name', 'news_site');

/**
 * Набор случайных символов для усложнения подборки пользовательского пароля ("соль").
 */
Config::set('salt', 'g5kgat83kd0pbm51d');

/**
 * Pagination
 */
Config::set('pagLimit', 5);
Config::set('pagButtonLimit', 5);

/**
 * Gallery
 */
Config::set('gallery', ROOT.DS.'public'.DS.'img'.DS);
Config::set('imgDir', DS.'img'.DS);