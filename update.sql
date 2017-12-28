ALTER TABLE `wechat_base_user_info_work` CHANGE `contant` `content` CHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '工作内容';
ALTER TABLE `wechat_base_user_info_training` CHANGE `picture` `picture` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '证书照片';
ALTER TABLE `wechat_base_user_info_awards` CHANGE `picture` `picture` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '奖状照片';

已更新到生产环境