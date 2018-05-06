ALTER TABLE  `teaching_sport_item` ADD  `input_type` CHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  'int' COMMENT  'int' AFTER  `unit` ;
UPDATE  `wechat_yey_mld`.`teaching_sport_item` SET  `input_type` =  'float' WHERE  `teaching_sport_item`.`id` =3 LIMIT 1 ;
 ----以上已更新到生产环境
