CREATE TABLE `notice_center_type` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `number` int(2) unsigned NOT NULL DEFAULT '1' COMMENT '顺序',
  `type` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '类型',
  `name` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='通知类型' AUTO_INCREMENT=12 ;

-- 
-- 导出表中的数据 `notice_center_type`
-- 

INSERT INTO `notice_center_type` (`id`, `number`, `type`, `name`) VALUES 
(1, 1, 'parent', '园所通知'),
(2, 2, 'parent', '办公室通知'),
(3, 3, 'parent', '开园通知'),
(4, 4, 'parent', '缴费通知'),
(5, 5, 'parent', '体检通知'),
(6, 6, 'parent', '安全通知'),
(7, 7, 'parent', '放假通知'),
(8, 8, 'parent', '活动通知'),
(9, 1, 'teacher', '园所通知'),
(10, 2, 'teacher', '会议通知'),
(11, 1, 'teacher', '公示公告');

---已经更新到生产环境