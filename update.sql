INSERT INTO `wechat_yey_mld`.`wechat_base_module` (`module_id`, `name`, `module`, `explain`, `icon_id`, `path`, `parent_module_id`, `mini_icon_id`, `wait_read_table`) VALUES ('120305', '全部家长通知', '203_03_0', '', '120300', 'sub/notice_center/record_all.php', '120300', '120300', ''), ('120306', '全部教师通知', '203_06_0', '', '120300', 'sub/notice_center/teacher_record_all.php', '120300', '120300', '');

UPDATE `wechat_yey_mld`.`wechat_base_module` SET `module` = '203_04_0' WHERE `wechat_base_module`.`module_id` = 120303 LIMIT 1; UPDATE `wechat_yey_mld`.`wechat_base_module` SET `module` = '203_05_0' WHERE `wechat_base_module`.`module_id` = 120304 LIMIT 1;

UPDATE `wechat_yey_mld`.`wechat_base_module` SET `name` = '我的家长通知记录' WHERE `wechat_base_module`.`module_id` = 120302 LIMIT 1; UPDATE `wechat_yey_mld`.`wechat_base_module` SET `name` = '我的教师通知记录' WHERE `wechat_base_module`.`module_id` = 120304 LIMIT 1;

以上已更新到生产环境
