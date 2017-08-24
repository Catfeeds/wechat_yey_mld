CREATE TABLE `dailywork_workflow_case` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `opener` mediumint(8) unsigned NOT NULL COMMENT '申请人ID',
  `date` datetime NOT NULL COMMENT '申请日期',
  `main_id` mediumint(8) unsigned NOT NULL COMMENT '工作流ID',
  `state` int(2) NOT NULL DEFAULT '1' COMMENT '当前状态0表示驳回，其他情况，如果Reason不为空，表示退回',
  `close_date` datetime NOT NULL,
  `reason` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '退回与驳回原因共用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流用户申请主体' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_workflow_case_data` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `case_id` mediumint(8) unsigned NOT NULL COMMENT 'case编号',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '数据名称',
  `type` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '控件类型',
  `value` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '数据值',
  `is_decode` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要解码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户提交的工作流申请数据' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_workflow_case_log` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `case_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'Case编号',
  `date` date NOT NULL COMMENT '日期',
  `operator_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '操作人ID',
  `operator_name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '操作人姓名',
  `comment` text COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='case日志' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_workflow_case_step` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `case_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'case编号',
  `main_step_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '步骤编号',
  `owner_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '填写人编号',
  `date` date NOT NULL COMMENT '日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流实际审批记录' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_workflow_case_step_data` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `case_step_id` mediumint(8) unsigned NOT NULL COMMENT '审批步骤编号',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '数据名称',
  `type` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '控件类型',
  `value` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '数据值',
  `is_decode` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要解码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户提交的工作流申请数据' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_workflow_main` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `number` int(3) unsigned NOT NULL COMMENT '显示顺序',
  `title` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `state_sum` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态总数',
  `role_id` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '可以提case的角色Json数组',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流程主体' AUTO_INCREMENT=2 ;

INSERT INTO `dailywork_workflow_main` (`id`, `number`, `title`, `state_sum`, `role_id`) VALUES 
(1, 1, '工作流测试流程1', 4, '0');

CREATE TABLE `dailywork_workflow_main_step` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `main_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '主体编号',
  `number` int(2) unsigned NOT NULL DEFAULT '1' COMMENT '工作流顺序',
  `role_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '审批角色编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流审批步骤' AUTO_INCREMENT=5 ;

INSERT INTO `dailywork_workflow_main_step` (`id`, `main_id`, `number`, `role_id`) VALUES 
(1, 1, 1, 65),
(2, 1, 2, 66),
(3, 1, 3, 69),
(4, 1, 4, 64);

CREATE TABLE `dailywork_workflow_main_step_vcl` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `step_id` mediumint(8) unsigned NOT NULL COMMENT '步骤编号',
  `number` int(2) unsigned NOT NULL DEFAULT '1' COMMENT '顺序',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '字段名称',
  `html` text COLLATE utf8_unicode_ci NOT NULL COMMENT '代码',
  `type` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '控件类型',
  `is_must` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否必填',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流控件' AUTO_INCREMENT=1 ;

CREATE TABLE `dailywork_workflow_main_vcl` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `main_id` mediumint(8) unsigned NOT NULL COMMENT '主体编号',
  `number` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '字段名称',
  `html` text COLLATE utf8_unicode_ci NOT NULL COMMENT '代码',
  `type` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '控件类型',
  `is_must` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否必填',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流控件' AUTO_INCREMENT=4 ;

INSERT INTO `dailywork_workflow_main_vcl` (`id`, `main_id`, `number`, `name`, `html`, `type`, `is_must`) VALUES 
(1, 1, 1, '文本类型', '<div class="weui-cells__title">文本类型</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'input', 1),
(2, 1, 2, '日期类型', '<div class="weui-cells__title">日期类型</div>\r\n	<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" type="date" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'input', 1),
(3, 1, 3, '下拉框类型', '<div class="weui-cells__title">多选类型</div>\r\n	<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<select class="weui-select" id="Vcl_%id%" name="Vcl_%id%">\r\n	        	<option value="">必选</option>\r\n				<option value="初中及以下">初中及以下</option>\r\n				<option value="高中及中专">高中及中专</option>\r\n				<option value="技校">技校</option>\r\n				<option value="大专">大专</option>\r\n				<option value="本科">本科</option>\r\n				<option value="硕士研究生">硕士研究生</option>\r\n				<option value="博士研究生及以上">博士研究生及以上</option>\r\n	        </select>\r\n		</div>\r\n	</div>\r\n</div>', 'select', 1),
(4, 1, 4, '多选类型', '<div class="weui-cells__title">多选类型</div>\r\n<div class="weui-cells weui-cells_form">\r\n	<div class="weui-cell weui-cell_switch">\r\n		<div class="weui-cell__bd">选项1</div>\r\n		<div class="weui-cell__ft">\r\n			<input class="weui-switch" onchange="dailywork_workflow_new_change_check(this,''%id%'',''选项1'')" type="checkbox"/>\r\n		</div>\r\n	</div>\r\n	<div class="weui-cell weui-cell_switch">\r\n		<div class="weui-cell__bd">选项2</div>\r\n		<div class="weui-cell__ft">\r\n			<label for="switchCP" class="weui-switch-cp">\r\n				<input class="weui-switch" onchange="dailywork_workflow_new_change_check(this,''%id%'',''选项2'')" type="checkbox"/>\r\n			</label>\r\n		</div>\r\n	</div>\r\n	<input type="hidden"  id="Vcl_%id%" name="Vcl_%id%" value=""/>\r\n</div>', 'multiple', 1),
(5, 1, 4, '单选类型', '<div class="weui-cells__title">单选类型</div>\r\n<div class="weui-cells weui-cells_radio">\r\n	<label class="weui-cell weui-check__label" for="Vcl_%id%_1">\r\n		<div class="weui-cell__bd">\r\n			<p>选项01</p>\r\n		</div>\r\n	<div class="weui-cell__ft">\r\n		<input type="radio" class="weui-check" value="选项01" id="Vcl_%id%_1" name="Vcl_%id%">\r\n		<span class="weui-icon-checked"></span>\r\n	</div>\r\n	</label>\r\n	<label class="weui-cell weui-check__label" for="Vcl_%id%_2">\r\n		<div class="weui-cell__bd">\r\n			<p>选项02</p>\r\n		</div>\r\n		<div class="weui-cell__ft">\r\n			<input type="radio" class="weui-check" value="选项02" id="Vcl_%id%_2" name="Vcl_%id%">\r\n			<span class="weui-icon-checked"></span>\r\n		</div>\r\n	</label>\r\n</div>', 'single', 1);


--dailywork_workflow_main_step_view
select `dailywork_workflow_main_step`.`id` AS `id`,`dailywork_workflow_main`.`number` AS `main_number`,`dailywork_workflow_main_step`.`main_id` AS `main_id`,`dailywork_workflow_main`.`title` AS `title`,`dailywork_workflow_main`.`state_sum` AS `state_sum`,`dailywork_workflow_main`.`role_id` AS `main_role_id`,`dailywork_workflow_main_step`.`number` AS `number`,`dailywork_workflow_main_step`.`role_id` AS `role_id`,`wechat_base_role`.`name` AS `role_name` from ((`dailywork_workflow_main` join `dailywork_workflow_main_step` on((`dailywork_workflow_main`.`id` = `dailywork_workflow_main_step`.`main_id`))) join `wechat_base_role` on((`dailywork_workflow_main_step`.`role_id` = `wechat_base_role`.`role_id`))) order by `dailywork_workflow_main`.`number`,`dailywork_workflow_main_step`.`number`;

--dailywork_workflow_case_view
select `dailywork_workflow_case`.`id` AS `id`,`dailywork_workflow_case`.`opener` AS `opener`,`wechat_base_user_wechat_view`.`name` AS `name`,`dailywork_workflow_case`.`main_id` AS `main_id`,`dailywork_workflow_main`.`title` AS `title`,`dailywork_workflow_main`.`state_sum` AS `state_sum`,`dailywork_workflow_main`.`role_id` AS `role_id`,`dailywork_workflow_case`.`date` AS `date`,`dailywork_workflow_case`.`state` AS `state`,`dailywork_workflow_case`.`close_date` AS `close_date`,`dailywork_workflow_case`.`reason` AS `reason` from ((`dailywork_workflow_case` join `wechat_base_user_wechat_view` on((`dailywork_workflow_case`.`opener` = `wechat_base_user_wechat_view`.`uid`))) join `dailywork_workflow_main` on((`dailywork_workflow_main`.`id` = `dailywork_workflow_case`.`main_id`))) order by `dailywork_workflow_case`.`date` desc;

--dailywork_workflow_case_step_view
select `dailywork_workflow_case_step`.`id` AS `id`,`dailywork_workflow_case_step`.`case_id` AS `case_id`,`dailywork_workflow_case_view`.`opener` AS `opener`,`dailywork_workflow_case_view`.`name` AS `name`,`dailywork_workflow_case_view`.`main_id` AS `main_id`,`dailywork_workflow_case_view`.`title` AS `title`,`dailywork_workflow_case_view`.`state_sum` AS `state_sum`,`dailywork_workflow_case_view`.`date` AS `case_date`,`dailywork_workflow_case_view`.`state` AS `state`,`dailywork_workflow_case_view`.`close_date` AS `close_date`,`dailywork_workflow_case_view`.`reason` AS `reason`,`dailywork_workflow_case_step`.`main_step_id` AS `main_step_id`,`dailywork_workflow_main_step`.`number` AS `number`,`dailywork_workflow_main_step`.`role_id` AS `role_id`,`dailywork_workflow_case_step`.`owner_id` AS `owner_id`,`dailywork_workflow_case_step`.`date` AS `step_date`,`wechat_base_role`.`name` AS `role_name` from (((`dailywork_workflow_case_view` join `dailywork_workflow_case_step` on((`dailywork_workflow_case_step`.`case_id` = `dailywork_workflow_case_view`.`id`))) join `dailywork_workflow_main_step` on((`dailywork_workflow_case_step`.`main_step_id` = `dailywork_workflow_main_step`.`id`))) join `wechat_base_role` on((`dailywork_workflow_main_step`.`role_id` = `wechat_base_role`.`role_id`)));

