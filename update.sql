INSERT INTO `wechat_base_module` (`module_id`, `name`, `module`, `explain`, `icon_id`, `path`, `parent_module_id`, `mini_icon_id`, `wait_read_table`) VALUES ('120307', '通知类型管理', '203_07_0', '', '120300', '', '120300', '120300', '');

UPDATE `wechat_base_module` SET `path` = 'sub/notice_center/notice_type.php' WHERE `wechat_base_module`.`module_id` = 120307 LIMIT 1;

TRUNCATE TABLE  `notice_center_type`;

INSERT INTO `notice_center_type` (`id`, `number`, `type`, `name`) VALUES 
(1, 1, '幼儿家长', '园所通知'),
(2, 2, '幼儿家长', '办公室通知'),
(3, 3, '幼儿家长', '开园通知'),
(4, 4, '幼儿家长', '缴费通知'),
(5, 5, '幼儿家长', '体检通知'),
(6, 6, '幼儿家长', '安全通知'),
(7, 7, '幼儿家长', '放假通知'),
(8, 8, '幼儿家长', '活动通知'),
(9, 1, '教职工', '园所通知'),
(10, 2, '教职工', '会议通知'),
(11, 3, '教职工', '公示公告');

