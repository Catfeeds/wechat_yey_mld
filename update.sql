ALTER TABLE `wechat_wx_user_leavemsg` ADD `type` CHAR(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text' COMMENT '消息类型' AFTER `is_reply`;
