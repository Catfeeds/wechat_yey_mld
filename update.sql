CREATE TABLE `wechat_base_user_info_base` (
  `uid` mediumint(8) unsigned NOT NULL COMMENT '用户编号',
  `name` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `card_id` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '身份证',
  `sex` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT '性别',
  `birthday` date NOT NULL COMMENT '出生日期',
  `nation` char(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '民族',
  `politics` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '政治面膜',
  `join_work_date` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '参加工作时间',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `wechat_base_user_info_education` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户编号',
  `graduate_date` date NOT NULL COMMENT '毕业时间',
  `education_type` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '学历类别：就业学历、第二学历',
  `education` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '学历与学位：高中、中专、大专、本科、硕士研究生、博士研究生',
  `school` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '毕业学校',
  `profession` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '所学专业',
  `length` char(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '学制：2年制、3年制、4年制、5年制',
  `pro_type` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '专业类别：哲学、经济学、法学、教育学、文学、历史学、理学、工学、农学、医学、军事学、管理学、艺术学',
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='学历学位' AUTO_INCREMENT=1 ;

CREATE TABLE `wechat_base_user_info_jobtitle` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '编号', 
  `uid` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户编号', 
  `name` CHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '资格证名称', 
  `number` CHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '证书编号', 
  `organization` CHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '发证机关', 
  `date` CHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '发证时间', 
  `picture` CHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '证书照片', 
  `create_date` DATETIME NOT NULL COMMENT '创建日期'
)
ENGINE = myisam
 CHARACTER SET utf8 COLLATE utf8_unicode_ci;
 
 CREATE TABLE `wechat_base_user_info_training` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '编号', 
  `uid` MEDIUMINT(8) UNSIGNED NOT NULL COMMENT '用户编号', 
  `start_date` DATE NOT NULL COMMENT '开始时间', 
  `end_date` DATE NOT NULL COMMENT '结束时间', 
  `type` CHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '培训类型', 
  `content` CHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '培训内容', 
  `organization` CHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '主办单位', 
  `is_certificate` CHAR(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否取得证书', 
  `picture` CHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '证书照片', 
  `create_date` DATETIME NOT NULL COMMENT '创建日期'
)
ENGINE = myisam
 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE `wechat_base_user_info_work` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '编号', 
  `uid` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户编号', 
  `start_date` DATE NOT NULL COMMENT '开始时间', 
  `end_date` DATE NOT NULL COMMENT '结束时间', 
  `contant` CHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '工作内容', 
  `role` CHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '本人角色', 
  `type` CHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '业绩类型', 
  `create_date` DATETIME NOT NULL COMMENT '创建时间'
)
ENGINE = myisam
 CHARACTER SET utf8 COLLATE utf8_unicode_ci
COMMENT = '工作业绩';
 
CREATE TABLE `wechat_base_user_info_awards` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户编号',
  `date` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '获奖时间',
  `name` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '项目名称',
  `type` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '类别',
  `grade` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '级别',
  `level` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '等级',
  `role_level` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色排名',
  `approve_dept` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '批准部门',
  `is_certificate` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT '是否取得奖状',
  `picture` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '奖状照片',
  `create_date` datetime NOT NULL COMMENT '创建日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='获奖情况' AUTO_INCREMENT=1 ;

CREATE TABLE `wechat_base_user_info_thesis` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户编号',
  `date` date NOT NULL COMMENT '日期',
  `title` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '标题',
  `book_name` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '刊物名称',
  `role_level` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色等级',
  `create_date` datetime NOT NULL COMMENT '创建日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='论文著作' AUTO_INCREMENT=1 ;

CREATE TABLE `wechat_base_user_info_tech` (
  `id` MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '编号', 
  `uid` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户编号', 
  `date` DATE NOT NULL COMMENT '时间', 
  `title` CHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '题目', 
  `role_level` CHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '本人角色或排名', 
  `create_date` DATETIME NOT NULL
)
ENGINE = myisam
 CHARACTER SET utf8 COLLATE utf8_unicode_ci
COMMENT = '技术报告';
