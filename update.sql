CREATE TABLE  `book_info_teacher_borrow` (
 `id` MEDIUMINT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT  '编号',
 `book_id` MEDIUMINT( 8 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '图书编号',
 `teacher_id` MEDIUMINT( 8 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '教师编号',
 `borrow_date` DATETIME NOT NULL COMMENT  '借阅时间',
 `return_date` DATETIME NOT NULL COMMENT  '归还时间'
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT =  '教师借阅图书记录';

---book_info_teacher_borrow_view
select `book_info_teacher_borrow`.`id` AS `id`,`book_info_teacher_borrow`.`book_id` AS `book_id`,`book_info_teacher_borrow`.`teacher_id` AS `teacher_id`,`book_info_teacher_borrow`.`borrow_date` AS `borrow_date`,`book_info_teacher_borrow`.`return_date` AS `return_date`,`wechat_base_user_info`.`name` AS `teacher_name`,`book_info_teacher`.`isbn` AS `isbn`,`book_info_teacher`.`title` AS `title`,`book_info_teacher`.`img` AS `img` from ((`book_info_teacher_borrow` join `book_info_teacher` on((`book_info_teacher_borrow`.`book_id` = `book_info_teacher`.`id`))) join `wechat_base_user_info` on((`book_info_teacher_borrow`.`teacher_id` = `wechat_base_user_info`.`uid`)))

