CREATE TABLE `dailywork_workflow_case` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `opener` mediumint(8) unsigned NOT NULL COMMENT '申请人ID',
  `date` datetime NOT NULL COMMENT '申请日期',
  `main_id` mediumint(8) unsigned NOT NULL COMMENT '工作流ID',
  `state` int(2) NOT NULL DEFAULT '1' COMMENT '当前状态',
  `close_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流用户申请主体' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_workflow_case_data` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `case_id` mediumint(8) unsigned NOT NULL COMMENT 'case编号',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '数据名称',
  `value` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '数据值',
  `is_decode` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要解码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户提交的工作流申请数据' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_workflow_case_step` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `case_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'case编号',
  `step_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '步骤编号',
  `owner_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '填写人编号',
  `date` date NOT NULL COMMENT '日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流实际审批记录' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_workflow_case_step_data` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `step_id` mediumint(8) unsigned NOT NULL COMMENT '审批步骤编号',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '数据名称',
  `value` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '数据值',
  `is_decode` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要解码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户提交的工作流申请数据' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_workflow_main` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `state_sum` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态总数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流程主体' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_workflow_main_step` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `main_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '主体编号',
  `number` int(2) unsigned NOT NULL DEFAULT '1' COMMENT '工作流顺序',
  `role_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '审批角色编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流审批步骤' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_workflow_main_step_vcl` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `step_id` mediumint(8) unsigned NOT NULL COMMENT '步骤编号',
  `number` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '字段名称',
  `html` text COLLATE utf8_unicode_ci NOT NULL COMMENT '代码',
  `is_must` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否必填',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流控件' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_workflow_main_vcl` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `main_id` mediumint(8) unsigned NOT NULL COMMENT '主体编号',
  `number` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '字段名称',
  `html` text COLLATE utf8_unicode_ci NOT NULL COMMENT '代码',
  `is_must` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否必填',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流控件' AUTO_INCREMENT=1 ;
