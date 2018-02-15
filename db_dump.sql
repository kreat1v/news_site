create database news_site;

use news_site;

create table `category`(
  `id` tinyint(3) unsigned not null auto_increment,
  `title` varchar(100) not null,
  primary key (`id`)
) engine = InnoDB default charset=utf8;

create table `news`(
  `id` int unsigned not null auto_increment,
  `id_category` tinyint(3) unsigned not null,
  `date` timestamp,
  `title` varchar(100) not null,
  `content` text default null,
  `active` tinyint(1) unsigned default 0,
  `tag` varchar(100) not null,
  primary key (`id`)
) engine = InnoDB default charset=utf8;

create table `comments` (
  `id` int unsigned not null auto_increment,
  `id_user` tinyint(1) unsigned not null,
  `id_news` int unsigned not null,
  `date` timestamp,
  `messages` text default null,
  primary key (`id`)
) engine=InnoDB default charset=utf8;

create table `answers` (
  `id` int unsigned not null auto_increment,
  `id_user` int unsigned not null,
  `id_comments` int unsigned not null,
  `date` timestamp,
  `messages` text default null,
  primary key (`id`)
) engine=InnoDB default charset=utf8;

create table `users` (
  `id` int unsigned not null auto_increment,
  `login` varchar(45) not null,
  `email` varchar(100) not null,
  `role` varchar(45) not null default 'admin',
  `password` char(32) not null,
  `active` tinyint(1) unsigned default '1',
  primary key (`id`)
) engine=InnoDB default charset=utf8;

create table `url_rewrite` (
  `id` int(10) unsigned not null auto_increment,
  `alias` varchar(100) not null,
  `target` varchar(100) not null,
  primary key (`id`)
) engine=InnoDB default charset=utf8;

create table `tags`(
  `id` tinyint(3) unsigned not null auto_increment,
  `title` varchar(100) not null,
  primary key (`id`)
) engine = InnoDB default charset=utf8;

insert into `tags` values
  (1, 'events'),
  (2, 'people'),
  (3, 'cinema'),
  (4, 'interview'),
  (5, 'important'),
  (6, 'funny'),
  (7, 'weather'),
  (8, 'life'),
  (9, 'meeting'),
  (10, 'incidents');

insert into `news_tag` (`id_news`, `id_tags`) values
  ('1', '5'),
  ('1', '1'),
  ('1', '9'),
  ('41', '1'),
  ('41', '7'),
  ('40', '5'),
  ('40', '9'),
  ('39', '2'),
  ('39', '6'),
  ('39', '10');

SELECT comments.*, users.* FROM `comments`
  JOIN users ON comments.id_user = users.id;

SELECT news.* FROM `news`
  JOIN news_tag ON news.id = news_tag.id_news
  JOIN tags ON tags.id = news_tag.id_tags
WHERE tags.id = 2;

SELECT news.* FROM `news`
  JOIN news_tag ON news.id = news_tag.id_news
WHERE news_tag.id_tags = 9;

SELECT * FROM `tags` WHERE id IN (1, 3);

SELECT vote.* FROM vote
  JOIN comments ON comments.id = vote.id_comments
WHERE comments.id_news = 50 AND vote.id_user = 2