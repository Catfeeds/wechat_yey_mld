ALTER TABLE `wechat_base_user_info_work` ADD `job` CHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '工作岗位' AFTER `end_date`;
ALTER TABLE `wechat_base_user_info_awards` ADD `category` CHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '种类' AFTER `name`;

CREATE TABLE `wechat_base_user_info_base` (
  `uid` mediumint(8) unsigned NOT NULL COMMENT '用户编号',
  `name` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '姓名',
  `card_id` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '身份证',
  `sex` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT '性别',
  `birthday` date NOT NULL COMMENT '出生日期',
  `nation` char(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '民族',
  `politics` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '政治面膜',
  `join_work_date` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '参加工作时间',
  `birthplace` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '出生地',
  `native` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '籍贯',
  `in_type` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '人员进入形式',
  `in_time` date NOT NULL COMMENT '进入本单位时间',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Dumping data for table `wechat_base_user_info_base`
-- 

INSERT INTO `wechat_base_user_info_base` (`uid`, `name`, `card_id`, `sex`, `birthday`, `nation`, `politics`, `join_work_date`, `birthplace`, `native`, `in_type`, `in_time`) VALUES 
(656, '尹陆明', '110108197506195428', '女', '1975-06-19', '汉', '中共党员', '1993.07', '北京', '北京', '从事业单位调入', '2015-09-07'),
(653, '吴丽娟', '11010819640404494X', '女', '1964-04-04', '汉', '中共党员', '1983.07', '北京', '北京', '事业单位招聘', '1983-07-01'),
(657, '张春华', '110104196509011620', '女', '1965-09-01', '汉', '中共党员', '1984.07', '北京', '北京', '从事业单位调入', '1998-09-01'),
(658, '博红艳', '110104196610042026', '女', '1966-10-04', '满', '中共党员', '1985.07', '北京', '北京', '从事业单位调入', '1998-10-01'),
(678, '李洪', '110108196708175447', '女', '1967-08-17', '汉', '中共党员', '1986.07', '北京', '北京', '从事业单位调入', '2000-01-01'),
(677, '王晖', '110102197901122327', '女', '1979-01-12', '汉', '群众', '1997.07', '北京', '北京', '从事业单位调入', '1998-08-01'),
(654, '王友菊', '413029196902090949', '女', '1969-02-09', '汉', '预备党员', '1990.07', '河南', '河南', '从事业单位调入', '2009-09-01'),
(659, '孙莉', '11010419720717084X', '女', '1972-07-17', '汉', '群众', '1991.07', '北京', '北京', '从事业单位调入', '2006-07-01'),
(667, '韩莹', '110108197902095488', '女', '1979-02-09', '回', '中共党员', '1997.07', '北京', '北京', '事业单位招聘', '1997-07-01'),
(660, '王桂媛', '110106197308210647', '女', '1973-08-21', '汉', '中共党员', '1992.07', '北京', '北京', '从事业单位调入', '2013-08-01'),
(672, '刘畅', '110104198512282543', '女', '1985-12-28', '满', '群众', '2007.07', '北京', '北京', '事业单位招聘', '2007-07-01'),
(680, '李永佳', '110111198510145725', '女', '1985-10-14', '汉', '群众', '2004.07', '北京', '北京', '事业单位招聘', '2004-07-01'),
(681, '戴洁琦', '330184198402070024', '女', '1984-02-07', '汉', '群众', '2006.07', '杭州', '杭州', '事业单位招聘', '2016-08-01'),
(695, '党建玲', '110104196601122040', '女', '1966-01-12', '汉', '群众', '1984.07', '北京', '北京', '从事业单位调入', '1993-08-01'),
(694, '李立新', '110104196809031623', '女', '1968-09-03', '汉', '群众', '1987.07', '北京', '北京', '事业单位招聘', '1987-07-01'),
(664, '王艳', '110104196808303025', '女', '1968-03-30', '汉', '群众', '1986.07', '北京', '北京', '事业单位整建制转入', '1996-07-01'),
(665, '刘敬伟', '110226198707243644', '女', '1987-07-24', '汉', '中共党员', '2006.07', '北京', '北京', '事业单位招聘', '2006-07-01'),
(708, '田颖', '110102198907120829', '女', '1989-07-12', '汉', '共青团员', '2007.07', '北京', '北京', '事业单位招聘', '2007-07-01'),
(669, '祁雯', '110111198802190325', '女', '1988-02-19', '汉', '中共党员', '2011.07', '北京', '北京', '事业单位招聘', '2011-07-01'),
(671, '张云霞', '110227198910041227', '女', '1989-10-04', '汉', '共青团员', '2008.07', '北京', '北京', '事业单位招聘', '2008-07-01'),
(670, '田建萍', '533001198308200324', '女', '1983-08-20', '汉', '群众', '2001.08', '云南', '云南', '其他政策性安置', '2013-08-01'),
(666, '史亚娟', '110106199002182742', '女', '1990-02-18', '汉', '共青团员', '2008.07', '北京', '北京', '事业单位招聘', '2008-07-01'),
(673, '武自艳', '110111199109128827', '女', '1991-09-12', '汉', '共青团员', '2010.07', '北京', '北京', '事业单位招聘', '2010-07-01'),
(679, '张欣阳', '110104199111122025', '女', '1991-11-12', '汉', '共青团员', '2010.07', '北京', '北京', '事业单位招聘', '2010-07-01'),
(668, '张明月', '110111199608286520', '女', '1996-08-28', '满', '共青团员', '2014.07', '北京', '北京', '事业单位招聘', '2014-07-01'),
(687, '赵静', '110109199608254623', '女', '1996-08-25', '汉', '共青团员', '2014.07', '北京', '北京', '事业单位招聘', '2014-07-01'),
(685, '韩美川', '110109199510165227', '女', '1995-10-16', '汉', '共青团员', '2014.07', '北京', '北京', '事业单位招聘', '2014-07-01'),
(683, '毕一铭', '110227199610101229', '女', '1996-10-10', '满', '共青团员', '2014.07', '北京', '北京', '事业单位招聘', '2014-07-01'),
(686, '杜紫钰', '110227199608200041', '女', '1996-08-20', '汉', '共青团员', '2014.07', '北京', '北京', '事业单位招聘', '2014-07-01'),
(688, '崔秋雨', '110103199208070624', '女', '1992-08-07', '汉', '共青团员', '2014.07', '北京', '北京', '事业单位招聘', '2014-07-01'),
(684, '韩双宇', '110227199604010021', '女', '1996-04-01', '汉', '共青团员', '2014.07', '北京', '北京', '事业单位招聘', '2014-07-01'),
(662, '王倩', '110111198506254240', '女', '1985-06-25', '汉', '群众', '2005.07', '北京', '北京', '事业单位招聘', '2014-03-01'),
(663, '张丽萍', '110104196301210428', '女', '1963-01-21', '汉', '群众', '1981.07', '北京', '北京', '从事业单位调入', '1993-05-01'),
(661, '张金波', '11010419640207252X', '女', '1964-02-07', '汉', '群众', '1981.09', '北京', '北京', '事业单位招聘', '1985-12-01'),
(696, '谢辰', '110104198503240018', '男', '1985-03-24', '汉', '群众', '2013.12', '北京', '北京', '事业单位招聘', '2013-03-01'),
(697, '耿建强', '110111198901120074', '男', '1989-01-12', '汉', '共青团员', '2007.08', '北京', '北京', '事业单位招聘', '2014-03-01'),
(699, '王立节', '110104197002212524', '女', '1970-02-21', '汉', '群众', '1987.12', '北京', '北京', '从事业单位调入', '1997-10-01'),
(703, '金雪', '11010419850208122x', '女', '1985-02-08', '汉', '群众', '2002.09', '北京', '北京', '事业单位招聘', '2015-03-01'),
(674, '陈菊', '11010819871114574x', '女', '1987-11-14', '汉', '群众', '2008.07', '北京', '北京', '从事业单位调入', '2015-07-01'),
(682, '赵思晴', '110227199401300061', '女', '1994-01-30', '汉', '共青团员', '2015.07', '北京', '北京', '事业单位招聘', '2015-07-01'),
(689, '霍霂笛', '110108199410104121', '女', '1994-10-10', '汉', '共青团员', '2015.07', '北京', '北京', '事业单位招聘', '2015-07-01'),
(690, '孟宇', '110106199505125424', '女', '1995-05-12', '汉', '共青团员', '2015.07', '北京', '北京', '事业单位招聘', '2015-07-01'),
(675, '刘阳', '110108198408182222', '女', '1984-08-18', '汉', '群众', '2007.07', '北京', '北京', '从事业单位调入', '2015-03-01'),
(693, '尚闻捷', '110102199310150448', '女', '1993-10-15', '汉', '共青团员', '2016.07', '北京', '北京', '事业单位招聘', '2016-07-01'),
(692, '高宇', '110111199509015522', '女', '1995-09-01', '汉', '共青团员', '2016.07', '北京', '北京', '事业单位招聘', '2016-07-01'),
(701, '李斯', '110103199412310920', '女', '1994-12-31', '汉', '共青团员', '2016.07', '北京', '北京', '事业单位招聘', '2016-07-01'),
(700, '郑晓明', '110102199408240820', '女', '1994-08-24', '汉', '共青团员', '2012.08', '北京', '北京', '事业单位招聘', '2016-04-01'),
(676, '王纯妍', '110102198906202320', '女', '1989-06-20', '汉', '共青团员', '2009.01', '北京', '北京', '事业单位招聘', '2016-05-01'),
(706, '李媛', '110106199704172426', '女', '1997-04-17', '汉', '共青团员', '2017.07', '北京', '北京', '事业单位招聘', '2017-07-01'),
(705, '赵慧', '110227199607210029', '女', '1996-07-21', '汉', '共青团员', '2017.07', '北京', '北京', '事业单位招聘', '2017-07-01'),
(702, '赵艳艳', '110228198803183226', '女', '1988-03-18', '汉', '群众', '2008.07', '北京', '北京', '从事业单位调入', '2017-08-01'),
(707, '刘雨涵', '110223199706202723', '女', '1997-06-20', '汉', '共青团员', '2017.07', '北京', '北京', '事业单位招聘', '2017-07-01'),
(704, '熊琦', '110106199104162742', '女', '1991-04-16', '汉', '共青团员', '2010.07', '#N/A', '北京', '从事业单位调入', '2013-08-01'),
(691, '杨荥', '110106199506130049', '女', '1995-06-13', '汉', '共青团员', '2015.07', '#N/A', '北京', '事业单位招聘', '2015-07-01'),
(698, '聂晨', '110102198106150497', '男', '1981-06-15', '汉', '群众', '1999.1', '#N/A', '北京', '事业单位招聘', '2017-04-01'),
(709, '张惠荣', '110104197301230423', '女', '1973-01-23', '汉', '群众', '1991.07', '北京', '北京', '从事业单位调入', '1996-07-01');

CREATE TABLE `wechat_base_user_info_project` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户编号',
  `name` char(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '课题名称',
  `level` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '课题级别',
  `role` char(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '参与角色',
  `start_date` date NOT NULL COMMENT '开题时间',
  `end_date` date NOT NULL COMMENT '结题时间',
  `result` text COLLATE utf8_unicode_ci NOT NULL COMMENT '课题成果',
  `create_date` datetime NOT NULL COMMENT '创建日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='课题立项' AUTO_INCREMENT=1 ;


