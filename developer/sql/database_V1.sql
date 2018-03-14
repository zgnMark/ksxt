SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `j_monolog`
-- ----------------------------
DROP TABLE IF EXISTS `j_monolog`;
CREATE TABLE `j_monolog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel` varchar(255) DEFAULT NULL COMMENT '通道',
  `level` varchar(255) DEFAULT NULL COMMENT '日志级别',
  `message` mediumtext COMMENT '日志消息',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `channel` (`channel`) USING HASH,
  KEY `level` (`level`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='日志表';


-- ----------------------------
-- Table structure for tp_action_log
-- ----------------------------
DROP TABLE IF EXISTS `j_action_log`;
CREATE TABLE `j_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` varchar(255) NOT NULL COMMENT '执行行为者ip',
  `log` longtext NOT NULL COMMENT '日志备注',
  `log_url` varchar(255) NOT NULL COMMENT '执行的URL',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8  COMMENT='行为日志表';

-- ----------------------------
-- Table structure for `cmd_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `cmd_schedule`;
CREATE TABLE `cmd_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expression` varchar(255) DEFAULT NULL COMMENT '时间执行表达式',
  `command` varchar(255) DEFAULT NULL COMMENT '任务执行表达式',
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  `locked` tinyint(1) DEFAULT '0' COMMENT '0正常，1锁定状态',
  `status` tinyint(1) DEFAULT '0' COMMENT '任务状态,0下线，1上线',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='任务调度表';

-- ----------------------------
-- Records of cmd_schedule
-- ----------------------------
INSERT INTO `cmd_schedule` VALUES ('1', '*/5 * * * *', 'D:\\xampp\\php\\php D:\\xampp\\htdocs\\gworld\\lxt querywithdraw', '提现查单（每5分钟执行一次）', '0', '1');

-- ----------------------------
-- Table structure for `cmd_schedule_log`
-- ----------------------------
DROP TABLE IF EXISTS `cmd_schedule_log`;
CREATE TABLE `cmd_schedule_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schedule_id` int(11) DEFAULT NULL COMMENT '任务ID',
  `standard_output` text COMMENT '标准输出',
  `error_output` text COMMENT '错误输出',
  `start_time` datetime DEFAULT NULL COMMENT '任务开始执行时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `run_status` tinyint(1) DEFAULT NULL COMMENT '运行状态,1运行中2运行成功，3失败',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='任务调度日志';


##################################权限########################################
-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `j_admin`;
CREATE TABLE `j_admin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `nickname` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(32) NOT NULL DEFAULT '',
  `mobile` varchar(11) DEFAULT NULL,
  `remark` varchar(200) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态，0正常，1冻结',
  `is_del` int(11) NOT NULL DEFAULT '0' COMMENT '软删除状态，0正常，1删除',
  `last_login_time` datetime DEFAULT NULL,
  `update_time` datetime NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='后台用户表';

-- ----------------------------
-- Records of admin
-- ----------------------------


-- ----------------------------
-- auth_rule，规则表，
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
`title` varchar(255) NOT NULL DEFAULT '' COMMENT '规则中文名称',
`type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '暂时没用',
`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
`condition` text NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',  # 规则附件条件,满足附加条件的规则,才认为是有效的规则
`pid` mediumint(8) unsigned NOT NULL COMMENT '用户把规则划分成组，方便分配权限',
PRIMARY KEY (`id`),
UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- auth_group 用户组表
-- ----------------------------
DROP TABLE IF EXISTS `auth_group`;
CREATE TABLE `auth_group` (
`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
`title` varchar(255) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
`rules` text  DEFAULT '' COMMENT '用户组拥有的规则id，多个规则","隔开',
`remarks` text  DEFAULT '' COMMENT '备注',
PRIMARY KEY (`id`)
) ENGINE=InnoDB  AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- auth_group_access 用户组明细表
-- ----------------------------
DROP TABLE IF EXISTS `auth_group_access`;
CREATE TABLE `auth_group_access` (
`uid` mediumint(8) unsigned NOT NULL COMMENT '用户id',
`group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
KEY `uid` (`uid`),
KEY `group_id` (`group_id`)
) ENGINE=InnoDB  AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户组明细表';

##########################权限################################################

-- ----------------------------
-- Table structure for `j_sysuser_account`
-- ----------------------------
DROP TABLE IF EXISTS `j_sysuser_account`;
CREATE TABLE `j_sysuser_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_number` int(11) DEFAULT NULL COMMENT '账号',
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '邮件',
  `mobile_area_code` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '手机国家区号',
  `mobile` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '手机',
  `login_password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '密码',
  `account_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '账户类型:qq, wechat, sina ,mobile',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态，0:正常，1:冻结',
  `country_id` int(11) DEFAULT NULL COMMENT '注册国家,j_country表',
  `create_time` datetime DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  `is_del` int(11) NOT NULL DEFAULT '0' COMMENT '软删除状态，0正常，1删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='前台帐户通行表';

-- ----------------------------
-- Table structure for `j_sysuser_user`
-- ----------------------------
DROP TABLE IF EXISTS `j_sysuser_user`;
CREATE TABLE `j_sysuser_user` (
  `user_id` int(11) NOT NULL,
  `nickname` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '昵称',
  `realname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '真名',
  `currency` decimal(11,2) DEFAULT NULL COMMENT '金币',
  `sex` int(11) DEFAULT NULL COMMENT '性别:0未知，1男，2女',
  `birthday` date DEFAULT NULL COMMENT '生日',
  `login_num` int(11) DEFAULT NULL COMMENT '登录次数',
  `follow_num` int(11) DEFAULT '0' COMMENT '关注用户数',
  `followed_num` int(11) DEFAULT '0' COMMENT '被关注用户数',
  `constellation_id` int(11) DEFAULT '0' COMMENT '星座,对应配置表里的星座ID',
  `reg_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '注册IP',
  `reg_time` datetime DEFAULT NULL COMMENT '注册时间',
  `last_login_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '最后登录IP',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `signature` text COLLATE utf8_unicode_ci COMMENT '签名',
  `avatar_logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '头像',
  `device_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '注册类型，0:手机，1:平板',
  `is_del` int(11) NOT NULL DEFAULT '0' COMMENT '软删除状态，0正常，1删除',
  PRIMARY KEY (`user_id`),
  KEY `name` (`nickname`),
  KEY `userId` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户详细信息表';

-- ----------------------------
-- Table structure for `j_oauth_login`
-- ----------------------------
DROP TABLE IF EXISTS `j_oauth_login`;
CREATE TABLE `j_oauth_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '本站用户',
  `openid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '第三方用户id',
  `unionid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '微信多平台唯一',
  `type_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '类型:qq、wechat、sina',
  `access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '访问令牌',
  `param` text COLLATE utf8_unicode_ci COMMENT '返回参数',
  `create_time` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0:正常，1：删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='第三方绑定登录用户表';


-- ----------------------------
-- Table structure for `j_country`
-- ----------------------------
DROP TABLE IF EXISTS `j_country`;
CREATE TABLE `j_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '自己国家所属语言名称',
  `chinese_name` varchar(255) DEFAULT NULL COMMENT '区域即国家名称,统一为中文名称',
  `english_name` varchar(255) DEFAULT NULL COMMENT '英文标识,统一为英文标识',
  `logo` varchar(255) DEFAULT NULL COMMENT '图片即国旗',
  `area_code` varchar(255) DEFAULT NULL COMMENT '区号，手机带的',
  `status` tinyint(1) DEFAULT NULL COMMENT '开放状态,0开放，1为未开放',
  `update_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `is_del` int(11) NOT NULL DEFAULT '0' COMMENT '软删除状态，0正常，1删除',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序，降序即越大越靠前',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='区域表（国家）';

-- ----------------------------
-- Records of j_country
-- ----------------------------

-- ----------------------------
-- Table structure for `j_live`
-- ----------------------------
DROP TABLE IF EXISTS `j_live`;
CREATE TABLE `j_live` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `live_channel_id` int(11) DEFAULT NULL COMMENT '直播频道ID，目前对应网易直播表j_netease_live_channel',
  `title` varchar(255) DEFAULT NULL COMMENT '标题(歌曲名称)',
  `cover_picture` varchar(255) DEFAULT NULL COMMENT '封面图',
  `content` text COMMENT '直播内容',
  `start_time` datetime DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `online_num` int(11) NOT NULL DEFAULT '0' COMMENT '最大在线数',
  `is_del` int(11) NOT NULL DEFAULT '0' COMMENT '软删除状态，0正常，1删除',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态，0正在直播，1已结束',
  `update_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='直播表';

-- ----------------------------
-- Records of j_live
-- ----------------------------

-- ----------------------------
-- Table structure for `j_live_vote`
-- ----------------------------
DROP TABLE IF EXISTS `j_live_vote`;
CREATE TABLE `j_live_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `live_id` int(11) DEFAULT NULL COMMENT '直播ID',
  `user_id` int(11) DEFAULT NULL COMMENT '投票用户ID',
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `live_id` (`live_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='直播投票详细记录表';

-- ----------------------------
-- Records of j_live_vote
-- ----------------------------

-- ----------------------------
-- Table structure for `j_netease_live_channel`
-- ----------------------------
DROP TABLE IF EXISTS `j_netease_live_channel`;
CREATE TABLE `j_netease_live_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `live_number` int(11) DEFAULT NULL COMMENT '直播号，即房间号',
  `user_id` int(11) DEFAULT NULL COMMENT '所属用户',
  `name` varchar(255) DEFAULT NULL COMMENT '频道名称',
  `cid` varchar(255) DEFAULT NULL COMMENT '频道ID',
  `ctime` varchar(255) DEFAULT NULL COMMENT '网易云频道创建时间',
  `push_url` varchar(255) DEFAULT NULL COMMENT '推流地址',
  `http_pull_url` varchar(255) DEFAULT NULL COMMENT 'http拉流地址',
  `hls_pull_url` varchar(255) DEFAULT NULL COMMENT 'hls拉流地址',
  `rtmp_pull_url` varchar(255) DEFAULT NULL COMMENT 'rtmp拉流地址',
  `update_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网易直播频道表';

-- ----------------------------
-- Table structure for `j_netease_im_user`
-- ----------------------------
DROP TABLE IF EXISTS `j_netease_im_user`;
CREATE TABLE `j_netease_im_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户',
  `accid` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='网易IM关联用户';

-- ----------------------------
-- Table structure for `j_singer`
-- ----------------------------
DROP TABLE IF EXISTS `j_singer`;
CREATE TABLE `j_singer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `update_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='歌手表';

-- ----------------------------
-- Records of j_singer
-- ----------------------------

-- ----------------------------
-- Table structure for `j_user_follow`
-- ----------------------------
DROP TABLE IF EXISTS `j_user_follow`;
CREATE TABLE `j_user_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `follow_user_id` int(11) DEFAULT NULL COMMENT '被关注用户',
  `user_id` int(11) DEFAULT NULL COMMENT '关注用户',
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `follow_user_id` (`follow_user_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户关注表';

-- ----------------------------
-- Records of j_user_follow
-- ----------------------------

-- ----------------------------
-- Table structure for `j_user_follow_log`
-- ----------------------------
DROP TABLE IF EXISTS `j_user_follow_log`;
CREATE TABLE `j_user_follow_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `follow_user_id` int(11) DEFAULT NULL COMMENT '被关注用户',
  `user_id` int(11) DEFAULT NULL COMMENT '关注用户',
  `type` tinyint(1) DEFAULT NULL COMMENT '类型：0关注，1取消关注',
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `follow_user_id` (`follow_user_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户关注历史记录表';

-- ----------------------------
-- Table structure for `j_activity`
-- ----------------------------
DROP TABLE IF EXISTS `j_activity`;
CREATE TABLE `j_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) DEFAULT NULL COMMENT '语言',
  `admin_id` int(11) DEFAULT NULL COMMENT '创建管理员ID',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `cover_img` varchar(255) DEFAULT NULL COMMENT '活动封面图',
  `singer` varchar(255) DEFAULT NULL COMMENT '歌手',
  `content` mediumtext COMMENT '内容',
  `country_id` int(11) DEFAULT NULL COMMENT '举办国家',
  `address` varchar(1000) DEFAULT NULL COMMENT '举办活动详细地址',
  `start_time` datetime DEFAULT NULL COMMENT '任务开始执行时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `view_num` int(11) DEFAULT NULL COMMENT '查看数',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态：0上线、1未上线',
  `is_del` tinyint(1) DEFAULT NULL COMMENT '删除状态：0正常，1删除',
  `publish_time` datetime DEFAULT NULL COMMENT '发布时间',
  `update_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动表';

-- ----------------------------
-- Records of j_activity
-- ----------------------------

-- ----------------------------
-- Table structure for `j_language`
-- ----------------------------
DROP TABLE IF EXISTS `j_language`;
CREATE TABLE `j_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '语言名称',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态：0正常，1未启用',
  `is_del` tinyint(1) DEFAULT NULL COMMENT '删除状态：0正常，1删除',
  `update_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='语言表';

-- ----------------------------
-- Table structure for `j_currency_log`
-- ----------------------------
DROP TABLE IF EXISTS `j_currency_log`;
CREATE TABLE `j_currency_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '用户',
  `currency` decimal(11,2) DEFAULT NULL COMMENT '变动金币数',
  `currency_balance` decimal(11,2) DEFAULT NULL COMMENT '变动后金币余数',
  `type` tinyint(1) DEFAULT NULL COMMENT '变动类型：0增加，1扣除',
  `type_id` int(11) DEFAULT NULL COMMENT '类型：0系统充值，1管理员调整',
  `amount` decimal(11,2) DEFAULT NULL COMMENT '花费金额',
  `remarks` varchar(1000) DEFAULT NULL COMMENT '备注',
  `is_del` tinyint(1) DEFAULT NULL COMMENT '删除状态：0正常，1删除',
  `update_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='金币日志表';

-- ----------------------------
-- Table structure for `j_ad_space`
-- ----------------------------
DROP TABLE IF EXISTS `j_ad_space`;
CREATE TABLE `j_ad_space` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `show_img` varchar(1024) DEFAULT NULL COMMENT '广告图展示位',
  `model`   varchar(255) DEFAULT NULL  COMMENT '广告位数据模型：1轮播图,2歌手',
  `remarks` varchar(1000) DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态：0正常，1未启用',
  `is_del` tinyint(1) DEFAULT NULL COMMENT '软删除：0正常，1删除',
  `update_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告位';

-- ----------------------------
-- Records of j_ad_space
-- ----------------------------

-- ----------------------------
-- Table structure for `j_ad`
-- ----------------------------
DROP TABLE IF EXISTS `j_ad`;
CREATE TABLE `j_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_space` int(11) DEFAULT '0' COMMENT '所属广告位',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `url` varchar(1024) DEFAULT NULL COMMENT '跳转链接',
  `url_type` tinyint(1) DEFAULT '0' COMMENT '链接类型：0http，1手机APP原生跳转',
  `cover_img` varchar(1024) DEFAULT NULL COMMENT '封面图',
  `val` varchar(255) DEFAULT '' COMMENT '广告位的值',
  `extend` text COMMENT '扩展值',
  `sort` int(11) DEFAULT NULL COMMENT '排序：越大越靠前',
  `start_time` datetime DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `remarks` varchar(1024) DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态：0正常，1关闭',
  `is_del` tinyint(1) DEFAULT NULL COMMENT '软删除：0正常，1删除',
  `update_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告';


-- ----------------------------
-- Table structure for `j_order`
-- ----------------------------
DROP TABLE IF EXISTS `j_order`;
CREATE TABLE `j_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id（购买人）',
  `order_no` varchar(255) NOT NULL DEFAULT '' COMMENT '订单号',
  `out_trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '第三方订单号',
  `product_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联相关商品表id',
  `currency_type` int(11) NOT NULL COMMENT '币种：0人民币，1港币',
  `amount` decimal(11,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '支付金额',
  `pay_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '付款方式：0线下现金支付，1',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态：0待付款，1已付款',
  `remarks` varchar(1000) NOT NULL COMMENT '备注',
  `is_del` tinyint(1) NOT NULL COMMENT '软删除：0正常，1删除',
  `update_time` datetime NOT NULL COMMENT '更新时间',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付订单表';


-- ----------------------------
-- Table structure for `j_gift_log`
-- ----------------------------
DROP TABLE IF EXISTS `j_gift_log`;
CREATE TABLE `j_gift_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '送礼用户',
  `receive_user_id` int(11) DEFAULT NULL COMMENT '接收用户ID',
  `gift_id` int(11) DEFAULT NULL COMMENT '礼物表ID',
  `live_id` int(11) DEFAULT NULL COMMENT '直播ID',
  `num` int(11) DEFAULT NULL COMMENT '数量',
  `create_time` datetime DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='送礼记录';

-- ----------------------------
-- Records of j_gift_log
-- ----------------------------

-- ----------------------------
-- Table structure for `j_gift_group`
-- ----------------------------
DROP TABLE IF EXISTS `j_gift_group`;
CREATE TABLE `j_gift_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT '0' COMMENT '所属国家',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `is_del` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '状态：0启用，1未启用',
  `remarks` varchar(1000) NOT NULL COMMENT '备注',
  `update_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='礼物组';

-- ----------------------------
-- Records of j_gift_group
-- ----------------------------

-- ----------------------------
-- Table structure for `j_gift`
-- ----------------------------
DROP TABLE IF EXISTS `j_gift`;
CREATE TABLE `j_gift` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL COMMENT '所属礼物组',
  `name` varchar(255) DEFAULT NULL COMMENT '礼物名称',
  `gift_url` varchar(1024) DEFAULT NULL COMMENT 'icon图链接',
  `currency` decimal(11,2) DEFAULT NULL COMMENT '等值星币',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态：0正常，1停用',
  `is_del` tinyint(1) DEFAULT NULL,
  `remarks` varchar(1000) NOT NULL COMMENT '备注',
  `update_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='礼物表';


