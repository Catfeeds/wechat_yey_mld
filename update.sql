
CREATE TABLE `wechat_wx_user_leavemsg` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户编号',
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '留言内容',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '留言日期',
  `is_reply` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否被回复',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户留言存储' AUTO_INCREMENT=1 ;


CREATE TABLE `wechat_wx_user_leavemsg_reply` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `msg_id` mediumint(8) NOT NULL DEFAULT '0' COMMENT '留言编号',
  `uid` mediumint(8) NOT NULL DEFAULT '0' COMMENT '用户编号',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '回复日期',
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '回复内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户留言回复记录' AUTO_INCREMENT=1 ;

--wechat_wx_user_leavemsg_view
select `wechat_wx_user_leavemsg`.`id` AS `id`,`wechat_wx_user_leavemsg`.`user_id` AS `user_id`,`wechat_wx_user_info`.`photo` AS `photo`,`wechat_wx_user_info`.`nickname` AS `nickname`,`wechat_wx_user_info`.`sex` AS `sex`,`wechat_wx_user_info`.`openid` AS `openid`,`wechat_wx_user_info`.`session_id` AS `session_id`,`wechat_wx_user_leavemsg`.`comment` AS `comment`,`wechat_wx_user_leavemsg`.`date` AS `date`,`wechat_wx_user_leavemsg`.`is_reply` AS `is_reply` from (`wechat_wx_user_leavemsg` join `wechat_wx_user_info` on((`wechat_wx_user_leavemsg`.`user_id` = `wechat_wx_user_info`.`id`)))


--wechat_wx_user_leavemsg_reply_view
select `wechat_wx_user_leavemsg_reply`.`id` AS `id`,`wechat_wx_user_leavemsg_reply`.`msg_id` AS `msg_id`,`wechat_wx_user_leavemsg_reply`.`uid` AS `uid`,`wechat_base_user`.`username` AS `username`,`wechat_wx_user_leavemsg_reply`.`date` AS `date`,`wechat_wx_user_leavemsg_reply`.`comment` AS `comment`,`wechat_wx_user_info`.`photo` AS `photo`,`wechat_base_user_info`.`name` AS `name` from ((((`wechat_wx_user_leavemsg_reply` join `wechat_base_user` on((`wechat_wx_user_leavemsg_reply`.`uid` = `wechat_base_user`.`uid`))) join `wechat_base_user_wechat` on((`wechat_base_user`.`uid` = `wechat_base_user_wechat`.`uid`))) join `wechat_wx_user_info` on((`wechat_base_user_wechat`.`wechat_id` = `wechat_wx_user_info`.`id`))) join `wechat_base_user_info` on((`wechat_wx_user_leavemsg_reply`.`uid` = `wechat_base_user_info`.`uid`)))