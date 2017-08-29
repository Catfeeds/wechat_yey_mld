
-- --------------------------------------------------------

-- 
-- 表的结构 `dailywork_workflow_case`
-- 

CREATE TABLE `dailywork_workflow_case` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `opener` mediumint(8) unsigned NOT NULL COMMENT '申请人ID',
  `date` datetime NOT NULL COMMENT '申请日期',
  `main_id` mediumint(8) unsigned NOT NULL COMMENT '工作流ID',
  `state` int(2) NOT NULL DEFAULT '1' COMMENT '当前状态0表示驳回，其他情况，如果Reason不为空，表示退回',
  `close_date` datetime NOT NULL,
  `reason` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '退回与驳回原因共用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流用户申请主体' AUTO_INCREMENT=13 ;

-- 
-- 导出表中的数据 `dailywork_workflow_case`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `dailywork_workflow_case_data`
-- 

CREATE TABLE `dailywork_workflow_case_data` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `case_id` mediumint(8) unsigned NOT NULL COMMENT 'case编号',
  `main_vcl_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '工作流数据控件ID',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '数据名称',
  `type` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '控件类型',
  `value` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '数据值',
  `is_decode` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要解码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户提交的工作流申请数据' AUTO_INCREMENT=76 ;

-- 
-- 导出表中的数据 `dailywork_workflow_case_data`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `dailywork_workflow_case_log`
-- 

CREATE TABLE `dailywork_workflow_case_log` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `case_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'Case编号',
  `date` datetime NOT NULL COMMENT '日期',
  `operator_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '操作人ID',
  `operator_name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '操作人姓名',
  `comment` text COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='case日志' AUTO_INCREMENT=36 ;

-- 
-- 导出表中的数据 `dailywork_workflow_case_log`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `dailywork_workflow_case_step`
-- 

CREATE TABLE `dailywork_workflow_case_step` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `case_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'case编号',
  `main_step_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '步骤编号',
  `owner_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '填写人编号',
  `date` datetime NOT NULL COMMENT '日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流实际审批记录' AUTO_INCREMENT=42 ;

-- 
-- 导出表中的数据 `dailywork_workflow_case_step`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `dailywork_workflow_case_step_data`
-- 

CREATE TABLE `dailywork_workflow_case_step_data` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `case_step_id` mediumint(8) unsigned NOT NULL COMMENT '审批步骤编号',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '数据名称',
  `type` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '控件类型',
  `value` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '数据值',
  `is_decode` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否需要解码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户提交的工作流申请数据' AUTO_INCREMENT=14 ;

-- 
-- 导出表中的数据 `dailywork_workflow_case_step_data`
-- 


-- --------------------------------------------------------

-- 
-- 表的结构 `dailywork_workflow_main`
-- 

CREATE TABLE `dailywork_workflow_main` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `number` int(3) unsigned NOT NULL COMMENT '显示顺序',
  `title` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `state_sum` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态总数',
  `role_id` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '可以提case的角色Json数组',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流程主体' AUTO_INCREMENT=101 ;

-- 
-- 导出表中的数据 `dailywork_workflow_main`
-- 

INSERT INTO `dailywork_workflow_main` (`id`, `number`, `title`, `state_sum`, `role_id`) VALUES 
(1, 1, '购置', 4, '0'),
(2, 2, '维修', 4, '0'),
(3, 3, '请假', 3, '0');

-- --------------------------------------------------------

-- 
-- 表的结构 `dailywork_workflow_main_step`
-- 

CREATE TABLE `dailywork_workflow_main_step` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `main_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '主体编号',
  `number` int(2) unsigned NOT NULL DEFAULT '1' COMMENT '工作流顺序',
  `role_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '审批角色编号',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流审批步骤' AUTO_INCREMENT=12 ;

-- 
-- 导出表中的数据 `dailywork_workflow_main_step`
-- 

INSERT INTO `dailywork_workflow_main_step` (`id`, `main_id`, `number`, `role_id`) VALUES 
(1, 1, 1, 65),
(2, 1, 2, 66),
(3, 1, 3, 69),
(4, 1, 4, 64),
(5, 2, 1, 65),
(6, 2, 2, 66),
(7, 2, 3, 69),
(8, 2, 4, 64),
(9, 3, 1, 65),
(10, 3, 2, 66),
(11, 3, 3, 69);

-- --------------------------------------------------------

-- 
-- 表的结构 `dailywork_workflow_main_step_vcl`
-- 

CREATE TABLE `dailywork_workflow_main_step_vcl` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `step_id` mediumint(8) unsigned NOT NULL COMMENT '步骤编号',
  `number` int(2) unsigned NOT NULL DEFAULT '1' COMMENT '顺序',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '字段名称',
  `html` text COLLATE utf8_unicode_ci NOT NULL COMMENT '代码',
  `type` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '控件类型',
  `is_must` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否必填',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流控件' AUTO_INCREMENT=12 ;

-- 
-- 导出表中的数据 `dailywork_workflow_main_step_vcl`
-- 

INSERT INTO `dailywork_workflow_main_step_vcl` (`id`, `step_id`, `number`, `name`, `html`, `type`, `is_must`) VALUES 
(1, 1, 1, '审批意见', '<div class="weui-cells__title">审批意见</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="选填">\r\n		</div>\r\n	</div>\r\n</div>', 'input', 0),
(2, 2, 1, '审批意见', '<div class="weui-cells__title">审批意见</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="选填">\r\n		</div>\r\n	</div>\r\n</div>', 'input', 0),
(3, 3, 1, '审批意见', '<div class="weui-cells__title">审批意见</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="选填">\r\n		</div>\r\n	</div>\r\n</div>', 'input', 0),
(4, 4, 1, '实际金额', '<div class="weui-cells__title">实际金额（单位：元）</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" type="number" id="Vcl_%id%" onkeyup="value=value.replace(/[^0-9.]/g,'''')" name="Vcl_%id%" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'input', 1),
(5, 5, 1, '审批意见', '<div class="weui-cells__title">审批意见</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="选填">\r\n		</div>\r\n	</div>\r\n</div>', 'input', 0),
(6, 6, 1, '审批意见', '<div class="weui-cells__title">审批意见</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="选填">\r\n		</div>\r\n	</div>\r\n</div>', 'input', 0),
(7, 7, 1, '审批意见', '<div class="weui-cells__title">审批意见</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="选填">\r\n		</div>\r\n	</div>\r\n</div>', 'input', 0),
(8, 8, 1, '实际金额', '<div class="weui-cells__title">实际金额（单位：元）</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" type="number" id="Vcl_%id%" onkeyup="value=value.replace(/[^0-9.]/g,'''')" name="Vcl_%id%" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'input', 1),
(9, 9, 1, '审批意见', '<div class="weui-cells__title">审批意见</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="选填">\r\n		</div>\r\n	</div>\r\n</div>', 'input', 0),
(10, 10, 1, '审批意见', '<div class="weui-cells__title">审批意见</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="选填">\r\n		</div>\r\n	</div>\r\n</div>', 'input', 0),
(11, 11, 1, '审批意见', '<div class="weui-cells__title">审批意见</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="选填">\r\n		</div>\r\n	</div>\r\n</div>', 'input', 0);

-- --------------------------------------------------------

-- 
-- 表的结构 `dailywork_workflow_main_vcl`
-- 

CREATE TABLE `dailywork_workflow_main_vcl` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `main_id` mediumint(8) unsigned NOT NULL COMMENT '主体编号',
  `number` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  `name` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '字段名称',
  `html` text COLLATE utf8_unicode_ci NOT NULL COMMENT '代码',
  `type` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '控件类型',
  `is_must` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否必填',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='工作流控件' AUTO_INCREMENT=24 ;

-- 
-- 导出表中的数据 `dailywork_workflow_main_vcl`
-- 

INSERT INTO `dailywork_workflow_main_vcl` (`id`, `main_id`, `number`, `name`, `html`, `type`, `is_must`) VALUES 
(17, 2, 4, '金额（单位：元）', '<div class="weui-cells__title">金额（单位：元）</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" type="number" id="Vcl_%id%" onkeyup="value=value.replace(/[^0-9.]/g,'''')" name="Vcl_%id%" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'money', 1),
(16, 2, 3, '维修原因', '<div class="weui-cells__title">维修原因</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'text', 1),
(15, 2, 2, '维修类别', '<div class="weui-cells__title">维修类别</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<select class="weui-select" id="Vcl_%id%" name="Vcl_%id%">\r\n	        	<option value="">必选</option>\r\n				<option value="照明设备">照明设备</option>\r\n				<option value="空调">空调</option>\r\n				<option value="信息系统">信息系统</option>\r\n				<option value="洗衣机">洗衣机</option>\r\n				<option value="五金配件">五金配件</option>\r\n				<option value="木制家具">木制家具</option>\r\n				<option value="其他">其他</option>\r\n	        </select>\r\n		</div>\r\n	</div>\r\n</div>', 'select', 1),
(13, 1, 8, '执行部门', '<div class="weui-cells__title">执行部门</div>\r\n<div class="weui-cells weui-cells_radio">\r\n	<label class="weui-cell weui-check__label" for="Vcl_%id%_1">\r\n		<div class="weui-cell__bd">\r\n			<p>财务岗</p>\r\n		</div>\r\n	<div class="weui-cell__ft">\r\n		<input type="radio" class="weui-check" value="财务岗" id="Vcl_%id%_1" name="Vcl_%id%">\r\n		<span class="weui-icon-checked"></span>\r\n	</div>\r\n	</label>\r\n	<label class="weui-cell weui-check__label" for="Vcl_%id%_2">\r\n		<div class="weui-cell__bd">\r\n			<p>资料岗</p>\r\n		</div>\r\n		<div class="weui-cell__ft">\r\n			<input type="radio" class="weui-check" value="资料岗" id="Vcl_%id%_2" name="Vcl_%id%">\r\n			<span class="weui-icon-checked"></span>\r\n		</div>\r\n	</label>\r\n</div>', 'single', 1),
(6, 1, 1, '申请部门', '<div class="weui-cells__title">申请部门</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<select class="weui-select" id="Vcl_%id%" name="Vcl_%id%">\r\n	        	<option value="">必选</option>\r\n				<option value="小一班">小一班</option>\r\n				<option value="小二班">小二班</option>\r\n				<option value="小三班">小三班</option>\r\n				<option value="小四班">小四班</option>\r\n				<option value="中一班">中一班</option>\r\n				<option value="中二班">中二班</option>\r\n				<option value="中三班">中三班</option>\r\n				<option value="大一班">大一班</option>\r\n				<option value="大二班">大二班</option>\r\n				<option value="大三班">大三班</option>\r\n				<option value="保健室">保健室</option>\r\n				<option value="资料室">资料室</option>\r\n				<option value="中层办公室">中层办公室</option>\r\n				<option value="厨房">厨房</option>\r\n				<option value="会计室">会计室</option>\r\n	        </select>\r\n		</div>\r\n	</div>\r\n</div>', 'select', 1),
(7, 1, 2, '使用时间', '<div class="weui-cells__title">使用时间</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" type="date" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'date', 1),
(8, 1, 3, '购置物品类别', '<div class="weui-cells__title">购置物品类别</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<select class="weui-select" id="Vcl_%id%" name="Vcl_%id%">\r\n	        	<option value="">必选</option>\r\n				<option value="教学类">教学类</option>\r\n				<option value="玩具类">玩具类</option>\r\n				<option value="环境创设类">环境创设类</option>\r\n				<option value="日杂类">日杂类</option>\r\n	        </select>\r\n		</div>\r\n	</div>\r\n</div>', 'text', 1),
(9, 1, 4, '物品名称', '<div class="weui-cells__title">物品名称</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'test', 1),
(10, 1, 5, '物品数量（单位：个）', '<div class="weui-cells__title">物品数量（单位：个）</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" type="number" pattern="[0-9]*" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'int', 1),
(11, 1, 6, '物品用途', '<div class="weui-cells__title">物品用途</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'text', 1),
(12, 1, 7, '金额（单位：元）', '<div class="weui-cells__title">金额（单位：元）</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" type="number" id="Vcl_%id%" onkeyup="value=value.replace(/[^0-9.]/g,'''')" name="Vcl_%id%" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'money', 1),
(14, 2, 1, '申请部门', '<div class="weui-cells__title">申请部门</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<select class="weui-select" id="Vcl_%id%" name="Vcl_%id%">\r\n	        	<option value="">必选</option>\r\n				<option value="小一班">小一班</option>\r\n				<option value="小二班">小二班</option>\r\n				<option value="小三班">小三班</option>\r\n				<option value="小四班">小四班</option>\r\n				<option value="中一班">中一班</option>\r\n				<option value="中二班">中二班</option>\r\n				<option value="中三班">中三班</option>\r\n				<option value="大一班">大一班</option>\r\n				<option value="大二班">大二班</option>\r\n				<option value="大三班">大三班</option>\r\n				<option value="保健室">保健室</option>\r\n				<option value="资料室">资料室</option>\r\n				<option value="中层办公室">中层办公室</option>\r\n				<option value="厨房">厨房</option>\r\n				<option value="会计室">会计室</option>\r\n	        </select>\r\n		</div>\r\n	</div>\r\n</div>', 'select', 1),
(18, 2, 5, '执行部门', '<div class="weui-cells__title">执行部门</div>\r\n<div class="weui-cells weui-cells_radio">\r\n	<label class="weui-cell weui-check__label" for="Vcl_%id%_1">\r\n		<div class="weui-cell__bd">\r\n			<p>总务岗</p>\r\n		</div>\r\n	<div class="weui-cell__ft">\r\n		<input type="radio" class="weui-check" value="总务岗" id="Vcl_%id%_1" name="Vcl_%id%">\r\n		<span class="weui-icon-checked"></span>\r\n	</div>\r\n	</label>\r\n	<label class="weui-cell weui-check__label" for="Vcl_%id%_2">\r\n		<div class="weui-cell__bd">\r\n			<p>资料岗</p>\r\n		</div>\r\n		<div class="weui-cell__ft">\r\n			<input type="radio" class="weui-check" value="资料岗" id="Vcl_%id%_2" name="Vcl_%id%">\r\n			<span class="weui-icon-checked"></span>\r\n		</div>\r\n	</label>\r\n</div>', 'single', 1),
(19, 3, 1, '申请部门', '<div class="weui-cells__title">申请部门</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<select class="weui-select" id="Vcl_%id%" name="Vcl_%id%">\r\n	        	<option value="">必选</option>\r\n				<option value="小一班">小一班</option>\r\n				<option value="小二班">小二班</option>\r\n				<option value="小三班">小三班</option>\r\n				<option value="小四班">小四班</option>\r\n				<option value="中一班">中一班</option>\r\n				<option value="中二班">中二班</option>\r\n				<option value="中三班">中三班</option>\r\n				<option value="大一班">大一班</option>\r\n				<option value="大二班">大二班</option>\r\n				<option value="大三班">大三班</option>\r\n				<option value="保健室">保健室</option>\r\n				<option value="资料室">资料室</option>\r\n				<option value="中层办公室">中层办公室</option>\r\n				<option value="厨房">厨房</option>\r\n				<option value="会计室">会计室</option>\r\n	        </select>\r\n		</div>\r\n	</div>\r\n</div>', 'select', 1),
(20, 3, 2, '请假类别', '<div class="weui-cells__title">请假类别</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<select class="weui-select" id="Vcl_%id%" name="Vcl_%id%">\r\n	        	<option value="">必选</option>\r\n				<option value="病假">病假</option>\r\n				<option value="事假">事假</option>\r\n				<option value="婚假">婚假</option>\r\n				<option value="丧假">丧假</option>\r\n				<option value="家长会假">家长会假</option>\r\n				<option value="产假">产假</option>\r\n				<option value="看病假">看病假</option>\r\n				<option value="倒休">倒休</option>\r\n	        </select>\r\n		</div>\r\n	</div>\r\n</div>', 'select', 1),
(21, 3, 3, '休假时间段（起始日期）', '<div class="weui-cells__title">休假时间段（起始日期）</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" type="datetime-local" id="Vcl_%id%" name="Vcl_%id%" value="" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'time', 1),
(22, 3, 4, '休假时间段（终止日期）', '<div class="weui-cells__title">休假时间段（终止日期）</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" type="datetime-local" value="" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'time', 1),
(23, 3, 5, '工作安排', '<div class="weui-cells__title">工作安排</div>\r\n<div class="weui-cells">\r\n	<div class="weui-cell">\r\n		<div class="weui-cell__bd">\r\n			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">\r\n		</div>\r\n	</div>\r\n</div>', 'text', 1);


--dailywork_workflow_main_step_view
select `dailywork_workflow_main_step`.`id` AS `id`,`dailywork_workflow_main`.`number` AS `main_number`,`dailywork_workflow_main_step`.`main_id` AS `main_id`,`dailywork_workflow_main`.`title` AS `title`,`dailywork_workflow_main`.`state_sum` AS `state_sum`,`dailywork_workflow_main`.`role_id` AS `main_role_id`,`dailywork_workflow_main_step`.`number` AS `number`,`dailywork_workflow_main_step`.`role_id` AS `role_id`,`wechat_base_role`.`name` AS `role_name` from ((`dailywork_workflow_main` join `dailywork_workflow_main_step` on((`dailywork_workflow_main`.`id` = `dailywork_workflow_main_step`.`main_id`))) join `wechat_base_role` on((`dailywork_workflow_main_step`.`role_id` = `wechat_base_role`.`role_id`))) order by `dailywork_workflow_main`.`number`,`dailywork_workflow_main_step`.`number`;

--dailywork_workflow_case_view
select `dailywork_workflow_case`.`id` AS `id`,`dailywork_workflow_case`.`opener` AS `opener`,`wechat_base_user_wechat_view`.`name` AS `name`,`dailywork_workflow_case`.`main_id` AS `main_id`,`dailywork_workflow_main`.`title` AS `title`,`dailywork_workflow_main`.`state_sum` AS `state_sum`,`dailywork_workflow_main`.`role_id` AS `role_id`,`dailywork_workflow_case`.`date` AS `date`,`dailywork_workflow_case`.`state` AS `state`,`dailywork_workflow_case`.`close_date` AS `close_date`,`dailywork_workflow_case`.`reason` AS `reason` from ((`dailywork_workflow_case` join `wechat_base_user_wechat_view` on((`dailywork_workflow_case`.`opener` = `wechat_base_user_wechat_view`.`uid`))) join `dailywork_workflow_main` on((`dailywork_workflow_main`.`id` = `dailywork_workflow_case`.`main_id`))) order by `dailywork_workflow_case`.`date` desc;

--dailywork_workflow_case_step_view
select `dailywork_workflow_case_step`.`id` AS `id`,`dailywork_workflow_case_step`.`case_id` AS `case_id`,`dailywork_workflow_case_view`.`opener` AS `opener`,`dailywork_workflow_case_view`.`name` AS `name`,`dailywork_workflow_case_view`.`main_id` AS `main_id`,`dailywork_workflow_case_view`.`title` AS `title`,`dailywork_workflow_case_view`.`state_sum` AS `state_sum`,`dailywork_workflow_case_view`.`date` AS `case_date`,`dailywork_workflow_case_view`.`state` AS `state`,`dailywork_workflow_case_view`.`close_date` AS `close_date`,`dailywork_workflow_case_view`.`reason` AS `reason`,`dailywork_workflow_case_step`.`main_step_id` AS `main_step_id`,`dailywork_workflow_main_step`.`number` AS `number`,`dailywork_workflow_main_step`.`role_id` AS `role_id`,`dailywork_workflow_case_step`.`owner_id` AS `owner_id`,`dailywork_workflow_case_step`.`date` AS `step_date`,`wechat_base_role`.`name` AS `role_name` from (((`dailywork_workflow_case_view` join `dailywork_workflow_case_step` on((`dailywork_workflow_case_step`.`case_id` = `dailywork_workflow_case_view`.`id`))) join `dailywork_workflow_main_step` on((`dailywork_workflow_case_step`.`main_step_id` = `dailywork_workflow_main_step`.`id`))) join `wechat_base_role` on((`dailywork_workflow_main_step`.`role_id` = `wechat_base_role`.`role_id`)));


以上已更新到生产环境
