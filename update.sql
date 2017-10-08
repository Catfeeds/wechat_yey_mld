CREATE TABLE `student_onboard_snapshot` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '编号', 
  `teacher_id` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '教师编号', 
  `student_id` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '学生编号', 
  `date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '日期', 
  `url` CHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '连接地址', 
  `type` CHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'img 或 video'
)
ENGINE = myisam
 CHARACTER SET utf8 COLLATE utf8_unicode_ci
COMMENT = '教师随拍';

----已更新到服务器
