
同步 wechat_base_module 表

数据表 student_info 改名为 student_info_2018

将sub/webservice/signup_fix_allow_audit.php 加入计划任务每分钟执行一次

将 sub/admission/output 给予777权限

TRUNCATE TABLE  `student_info_wechat`;

UPDATE `wechat_base_setup` SET `system_name`='幼儿管理平台' WHERE (`id`='1');

ALTER TABLE  `wechat_base_setup` ADD  `xchyey_signup_license` CHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT  '西城幼儿园报名平台许可证号' AFTER  `xcye_collect_license` ;

ALTER TABLE  `wechat_base_setup` ADD  `xchyey_signup_url` CHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT  '西城幼儿报名平台接口地址' AFTER  `xcye_collect_url` ;


CREATE TABLE `student_info` (
  `student_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `state` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '0等待允许核验，1等待核验',
  `reject` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '拒绝',
  `name` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '幼儿姓名',
  `sex` char(2) NOT NULL COMMENT '性别',
  `birthday` date NOT NULL COMMENT '生日',
  `nation` char(8) NOT NULL COMMENT '民族',
  `only` char(2) NOT NULL COMMENT '独生子女',
  `only_code` char(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '独生子女证号',
  `is_first` char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否头胎',
  `h_code` char(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '户籍编码',
  `h_city` char(10) NOT NULL COMMENT '户籍城市',
  `h_area` char(6) NOT NULL COMMENT '户籍区',
  `h_street` char(10) NOT NULL COMMENT '户籍街道',
  `h_add` char(80) NOT NULL COMMENT '户籍地址',
  `id` char(20) NOT NULL COMMENT '身份证号',
  `id_type` char(50) NOT NULL COMMENT '身份证类型',
  `z_city` char(10) NOT NULL COMMENT '现住城市',
  `z_property` char(10) NOT NULL COMMENT '居住房屋属性',
  `z_area` char(6) NOT NULL COMMENT '现住区',
  `z_street` char(10) NOT NULL COMMENT '现住街道',
  `z_add` char(80) NOT NULL COMMENT '现住地地址',
  `illness` text NOT NULL COMMENT '病史',
  `allergic` text NOT NULL COMMENT '过敏史',
  `dept_id` mediumint(8) unsigned NOT NULL,
  `grade_number` int(8) unsigned NOT NULL,
  `class_number` int(2) unsigned NOT NULL,
  `class_name_diy` char(50) NOT NULL COMMENT '自定义班级名称',
  `jiudu` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '走读' COMMENT '就读方式',
  `birthplace` char(50) NOT NULL COMMENT '出生地',
  `birthplace_code` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '出生地代码',
  `id_quality` char(50) NOT NULL COMMENT '户口性质',
  `id_quality_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '非农业户口类型',
  `signup_date` date NOT NULL COMMENT '报名日期',
  `in_time` date NOT NULL COMMENT '入园时间',
  `out_time` date NOT NULL,
  `is_liushou` char(20) NOT NULL COMMENT '是否留守儿童',
  `is_wugong` char(5) NOT NULL COMMENT '是否进城务工人员随迁子女',
  `is_canji` char(5) NOT NULL COMMENT '是否残疾幼儿',
  `canji_type` char(50) NOT NULL COMMENT '残疾幼儿类别',
  `is_jisu` char(5) NOT NULL COMMENT '是否寄宿生',
  `is_guer` char(5) NOT NULL COMMENT '是否孤儿',
  `is_dibao` char(5) NOT NULL COMMENT '是否低保',
  `dibao_code` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '低保证号',
  `is_zizhu` char(5) NOT NULL COMMENT '是否接受资助',
  `nationality` char(50) NOT NULL COMMENT '国籍',
  `gangao` char(50) NOT NULL COMMENT '港澳台侨',
  `is_lieshi` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否烈士子女',
  `canji_code` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '幼儿残疾证号',
  `jiankang` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '总体健康状况',
  `xuexing` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '血型',
  `is_yiwang` char(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否有既往病史',
  `is_shoushu` char(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否有手术史',
  `shoushu` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '手术名称',
  `is_yizhi` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否有移植史',
  `is_yichuan` char(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否有遗传病史',
  `is_xiaochuan` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否有哮喘',
  `is_dianxian` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否有癫痫史',
  `is_jingjue` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否有惊厥史',
  `is_xinzangbing` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否有先天性心脏病',
  `is_guomin` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否有过敏史',
  `qitabingshi` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '其他家族遗传病史',
  `beizhu` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '备注',
  `h_shequ` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '户籍所在社区',
  `z_shequ` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '现住址所在社区',
  `z_same` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '现住址是否与户籍为同一地址',
  `h_guanxi` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '户主与幼儿关系',
  `z_owner` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '产权人姓名',
  `h_owner` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '户主姓名',
  `z_guanxi` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '产权人与孩子关系',
  `jh_1_connection` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第一监护人关系',
  `jh_1_is_zhixi` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第一监护人是否是直系亲属',
  `jh_1_is_canji` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第一监护人是否残疾',
  `jh_1_name` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第一监护人姓名',
  `jh_1_job` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第一监护人职业状况',
  `jh_1_danwei` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '工作单位全称',
  `jh_1_canji_code` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第一监护人残疾证号',
  `jh_1_id_type` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第一监护人证件类型',
  `jh_1_jiaoyu` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第一监护人教育程度',
  `jh_1_id` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第一监护人身份证',
  `jh_1_phone` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第一监护人手机',
  `jh_2_connection` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第一监护人关系',
  `jh_2_is_zhixi` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第二监护人是否是直系亲属',
  `jh_2_is_canji` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第二监护人是否残疾',
  `jh_2_name` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第二监护人姓名',
  `jh_2_job` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第二监护人职业状况',
  `jh_2_danwei` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '工作单位全称',
  `jh_2_canji_code` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第二监护人残疾证号',
  `jh_2_id_type` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第二监护人证件类型',
  `jh_2_jiaoyu` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第二监护人教育程度',
  `jh_2_id` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第二监护人身份证',
  `jh_2_phone` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '第二监护人手机',
  `jianhu_connection` char(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '其他监护人与幼儿关系',
  `jianhu_name` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '其他监护人信息姓名',
  `jianhu_phone` char(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '其他监护人信息联系电话',
  `flag_three` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '优先招收三周岁以上幼儿',
  `flag_xicheng` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '优先招收西城户籍幼儿入园',
  `flag_same` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '优先招收户籍与住址一致家庭的幼儿入园',
  `flag_only` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '独生子女',
  `flag_first` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '单独二胎儿童中的头胎子女优先录入',
  `h_is_group` char(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '否' COMMENT '户籍属性为集体',
  `h_is_yizhi` char(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '是' COMMENT '幼儿与父母户籍一致',
  `h_in_time` date NOT NULL COMMENT '幼儿落户时间',
  `signup_phone` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '报名联系电话',
  `signup_phone_backup` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '报名联系电话备用',
  `hospital_name` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '接种疫苗所在医院名称',
  `class_mode` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '报名班级',
  `compliance` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '是否接受调剂',
  `auditor_id` mediumint(8) unsigned NOT NULL COMMENT '核验人编号',
  `auditor_name` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '核验人姓名',
  `audit_remark` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '信息核验备注',
  `meet_auditor_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '幼儿见面审核员ID',
  `meet_auditor_name` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '幼儿见面审核员姓名',
  `meet_item` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '见面结果选择的项目',
  `audit_option` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '五证优先选项',
  `meet_remark` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '见面结果备注',
  `meet_parent_auditor_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '家长见面审核员',
  `meet_parent_auditor_name` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '家长见面审核员姓名',
  `meet_parent_item` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '家长面试结果',
  `meet_parent_remark` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '家长面试备注',
  `reject_reason` char(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '不批准原因',
  PRIMARY KEY (`student_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=1;