CREATE TABLE `book_info_stu_comment` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `book_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '图书编号',
  `teacher_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '教师编号',
  `comment` text COLLATE utf8_unicode_ci NOT NULL COMMENT '评论',
  `date` datetime NOT NULL COMMENT '评论时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='幼儿图书教师评论' AUTO_INCREMENT=1 ;

CREATE TABLE `book_info_stu_location` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '编号', 
  `book_id` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '图书编号', 
  `class_id` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '班级编号', 
  `sum` INT UNSIGNED NOT NULL DEFAULT '1' COMMENT '数量'
)
ENGINE = myisam
 CHARACTER SET utf8 COLLATE utf8_unicode_ci
COMMENT = '幼儿图书位置与数理';


--book_info_comment_view
select `book_info_stu`.`id` AS `id`,`book_info_stu`.`isbn` AS `isbn`,`book_info_stu`.`class_id` AS `class_id`,`book_info_stu`.`title` AS `title`,`book_info_stu`.`pages` AS `pages`,`book_info_stu`.`author` AS `author`,`book_info_stu`.`publisher` AS `publisher`,`book_info_stu`.`binding` AS `binding`,`book_info_stu`.`pubdate` AS `pubdate`,`book_info_stu`.`price` AS `price`,`book_info_stu`.`img` AS `img`,`book_info_stu`.`summary` AS `summary`,`book_info_stu`.`in_open` AS `in_open`,`book_info_stu`.`sum` AS `sum`,`book_info_stu`.`into` AS `into`,`book_info_stu`.`out_sum` AS `out_sum`,`book_info_stu`.`state` AS `state`,`book_info_stu`.`tag` AS `tag`,`book_info_stu_comment`.`teacher_id` AS `teacher_id`,`book_info_stu_comment`.`comment` AS `comment`,`book_info_stu_comment`.`date` AS `comment_date`,`wechat_base_user_info`.`name` AS `teacher_name` from ((`book_info_stu` join `book_info_stu_comment` on((`book_info_stu`.`id` = `book_info_stu_comment`.`book_id`))) join `wechat_base_user_info` on((`book_info_stu_comment`.`teacher_id` = `wechat_base_user_info`.`uid`)));

