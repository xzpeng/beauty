-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 10 月 13 日 14:25
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ncms`
--
CREATE DATABASE IF NOT EXISTS `ncms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ncms`;

-- --------------------------------------------------------

--
-- 表的结构 `nc_ad`
--

CREATE TABLE IF NOT EXISTS `nc_ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(180) NOT NULL,
  `type` int(11) NOT NULL COMMENT '广告类型',
  `img` varchar(18) NOT NULL,
  `remark` varchar(360) DEFAULT NULL,
  `href` varchar(255) DEFAULT NULL,
  `window` varchar(10) DEFAULT NULL,
  `bgcolor` varchar(7) DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `model` varchar(10) NOT NULL,
  `edit_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `nc_administrator`
--

CREATE TABLE IF NOT EXISTS `nc_administrator` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ips` varchar(160) DEFAULT NULL,
  `adName` varchar(30) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `adPost` varchar(30) NOT NULL DEFAULT '普通用户',
  `remark` varchar(180) DEFAULT NULL,
  `regTime` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `nc_administrator`
--

INSERT INTO `nc_administrator` (`id`, `ips`, `adName`, `password`, `adPost`, `remark`, `regTime`) VALUES
(1, '', 'developer', '9c442b8be8990ce05381398150c3f7e8', '开发者', '开发者权限', 1376315406);

-- --------------------------------------------------------

--
-- 表的结构 `nc_admin_session`
--

CREATE TABLE IF NOT EXISTS `nc_admin_session` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sid` varchar(32) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `life_time` int(10) unsigned NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=209 ;

-- --------------------------------------------------------

--
-- 表的结构 `nc_article`
--

CREATE TABLE IF NOT EXISTS `nc_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(10) unsigned NOT NULL COMMENT '文章类型',
  `title` varchar(120) NOT NULL COMMENT '标题',
  `img` varchar(18) DEFAULT NULL COMMENT '略缩图',
  `img_width` int(5) unsigned NOT NULL DEFAULT '0',
  `img_height` int(5) unsigned NOT NULL DEFAULT '0',
  `content` text COMMENT '内容',
  `edit_time` int(11) DEFAULT '0' COMMENT '编辑时间',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '点击量',
  `display` varchar(1) NOT NULL DEFAULT '1' COMMENT '显示',
  `href` varchar(180) DEFAULT NULL COMMENT '外链',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `promulgator` int(11) NOT NULL COMMENT '发布者ID',
  `model` varchar(15) NOT NULL,
  `recommend` varchar(1) NOT NULL DEFAULT '0' COMMENT '推荐',
  `keywords` varchar(40) DEFAULT NULL COMMENT '关键词',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `nc_article`
--

INSERT INTO `nc_article` (`id`, `type`, `title`, `img`, `img_width`, `img_height`, `content`, `edit_time`, `hits`, `display`, `href`, `sort`, `promulgator`, `model`, `recommend`, `keywords`) VALUES
(1, 33, '关于美人', NULL, 0, 0, '<p>关于美人<br/></p>', 1381168952, 24, '1', '', 0, 1, 'Admin', '0', ''),
(2, 33, '法律条款', NULL, 0, 0, '<p>法律条款<br/></p>', 1381163860, 4, '1', '', 0, 1, 'Admin', '0', ''),
(3, 33, '诚聘英才', NULL, 0, 0, '<p>诚聘英才<br/></p>', 1381164000, 4, '1', '', 0, 1, 'Admin', '0', ''),
(4, 33, '商务合作', NULL, 0, 0, '<p>商务合作<br/></p>', 1381164016, 2, '1', '', 0, 1, 'Admin', '0', ''),
(5, 33, '线下联盟', NULL, 0, 0, '<p>线下联盟</p>', 1381164024, 4, '1', '', 0, 1, 'Admin', '0', ''),
(6, 33, '联系我们', NULL, 0, 0, '<p>联系我们</p>', 1381164033, 6, '1', '', 0, 1, 'Admin', '0', '');

-- --------------------------------------------------------

--
-- 表的结构 `nc_home_session`
--

CREATE TABLE IF NOT EXISTS `nc_home_session` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sid` varchar(32) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `update_time` int(11) NOT NULL DEFAULT '0',
  `life_time` int(11) NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=239 ;

-- --------------------------------------------------------

--
-- 表的结构 `nc_score`
--

CREATE TABLE IF NOT EXISTS `nc_score` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '选手',
  `judges` int(11) NOT NULL COMMENT '评委',
  `stature` int(11) NOT NULL DEFAULT '0',
  `face` int(11) NOT NULL DEFAULT '0',
  `liked` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `nc_type`
--

CREATE TABLE IF NOT EXISTS `nc_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL,
  `child` int(11) NOT NULL DEFAULT '0',
  `title` varchar(120) NOT NULL,
  `remark` varchar(300) DEFAULT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `edit_time` int(11) unsigned NOT NULL DEFAULT '0',
  `display` varchar(1) NOT NULL DEFAULT '1',
  `path` varchar(300) NOT NULL DEFAULT '0/',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- 转存表中的数据 `nc_type`
--

INSERT INTO `nc_type` (`id`, `pid`, `child`, `title`, `remark`, `sort`, `edit_time`, `display`, `path`) VALUES
(1, 0, 6, '美人', '在这里，您可以看到真正的美人，您可以喜欢他，可以支持她，还可以送礼物给她。不过，为了美人的安全，这些都是要经过验证的哦。', 0, 1380644568, '1', '0/1/'),
(2, 0, 5, '模特', '在这里，您可以找到你喜欢的模特。您可以请她代言，为您的事业更上一层楼而提供出色的服务。小品牌、小企业一样可以找到心仪的代言者。', 0, 1380641936, '1', '0/2/'),
(3, 0, 7, '美课', '作为一个小时代的优秀女性，在这里，您可以学习到让你精神与身体共同美丽的知识，变成美人，在于是否经历，只要肯学习，小鸭变天鹅。', 0, 1380442778, '1', '0/3/'),
(4, 0, 10, '时尚', '不逛街的女人有点傻，更难成大器。作为美人的我，时尚购物是我生活不可或缺的一部分。心灵美了，还需要外在的呵护。内外兼修是我的目标。', 0, 1380442798, '1', '0/4/'),
(5, 1, 0, '美摄', '摄影师眼中的美人|4', 0, 1380443106, '1', '0/1/5/'),
(6, 1, 0, '美作', '女子有才便是德|6', 0, 1380443114, '1', '0/1/6/'),
(7, 1, 0, '美人', '真实美人  尽收眼底|2', 0, 1380443125, '1', '0/1/7/'),
(8, 1, 0, '美腿', '美腿写真  看到你流口水|5', 0, 1380443146, '1', '0/1/8/'),
(9, 1, 0, '美胸', '美胸大放送  看到你发呆|1', 0, 1380443159, '1', '0/1/9/'),
(10, 1, 0, '欧美', '欧美美人  特异的美|3', 0, 1380443171, '1', '0/1/10/'),
(11, 2, 0, '影视', '产品广告  影视模特|2', 0, 1380443324, '1', '0/2/11/'),
(12, 2, 0, '平面', '杂志  服装  品牌代言|5', 0, 1380443360, '1', '0/2/12/'),
(13, 2, 0, '手模', '珠宝  饰品  玉器代言|10', 0, 1380443405, '1', '0/2/13/'),
(14, 2, 0, '腿模', '服装  内衣|1', 0, 1380443511, '1', '0/2/14/'),
(15, 2, 0, '脚模', '品牌鞋类代言|3', 0, 1380443518, '1', '0/2/15/'),
(16, 3, 0, '礼仪', '学礼  知礼  美在内心|1', 0, 1380443632, '1', '0/3/16/'),
(17, 3, 0, '健身', '瑜伽  舞蹈  健身操|3', 0, 1380444061, '1', '0/3/17/'),
(18, 3, 0, '精油', '美人与精油的约会|2', 0, 1380444070, '1', '0/3/18/'),
(19, 3, 0, '中药', '身体调养  健康美丽|5', 0, 1380444101, '1', '0/3/19/'),
(20, 3, 0, '美搭', '穿衣搭配  形象指导|6', 0, 1380444141, '1', '0/3/20/'),
(21, 3, 0, '内涵', '为人处世  国学经典|1', 0, 1380444172, '1', '0/3/21/'),
(22, 3, 0, '化妆', '彩妆课堂  皮肤保养|3', 0, 1380444199, '1', '0/3/22/'),
(23, 4, 0, '美装', '美女服装  内衣  丝巾|2', 0, 1380444754, '1', '0/4/23/'),
(24, 4, 0, '美肤', '化妆品  护肤品  香水|5', 0, 1380444784, '1', '0/4/24/'),
(25, 4, 0, '美机', '手机数码  平板电视|6', 0, 1380444814, '1', '0/4/25/'),
(26, 4, 0, '美食', '零食  干果  饮料  餐饮|1', 0, 1380444847, '1', '0/4/26/'),
(27, 4, 0, '美酒', '红酒  高档洋酒  白酒|3', 0, 1380444875, '1', '0/4/27/'),
(28, 4, 0, '美包', '洋包包  国产包包|8', 0, 1380444906, '1', '0/4/28/'),
(29, 4, 0, '美鞋', '精品皮鞋  凉鞋  高跟鞋|9', 0, 1380444923, '1', '0/4/29/'),
(30, 4, 0, '美宠', '毛绒玩具  礼品|6', 0, 1380444940, '1', '0/4/30/'),
(31, 4, 0, '美车', '适合女生的车车|7', 0, 1380444966, '1', '0/4/31/'),
(32, 4, 0, '美居', '床上用品  创意用品|5', 0, 1380445355, '1', '0/4/32/'),
(33, 0, 0, '单页', '受保护', 0, 1381171659, '1', '0/33/'),
(34, 0, 0, '广告页', '受保护', 0, 1381171673, '1', '0/34/');

-- --------------------------------------------------------

--
-- 表的结构 `nc_user`
--

CREATE TABLE IF NOT EXISTS `nc_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userName` varchar(30) NOT NULL,
  `nickName` varchar(60) DEFAULT NULL COMMENT '昵称',
  `password` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `wburl` varchar(180) DEFAULT NULL COMMENT '微博地址',
  `sex` varchar(1) NOT NULL DEFAULT '0' COMMENT '0保密1男2女',
  `birthday` int(11) NOT NULL,
  `height` int(5) NOT NULL DEFAULT '0' COMMENT '单位cm',
  `weight` int(11) NOT NULL DEFAULT '0',
  `measure1` int(11) NOT NULL DEFAULT '0',
  `measure2` int(11) NOT NULL DEFAULT '0',
  `measure3` int(11) NOT NULL DEFAULT '0',
  `edu` varchar(2) NOT NULL DEFAULT '0' COMMENT '学历',
  `name` varchar(18) DEFAULT NULL,
  `area` varchar(120) DEFAULT NULL COMMENT '地区',
  `zip` varchar(6) DEFAULT NULL COMMENT '邮编',
  `mphone` varchar(11) NOT NULL COMMENT '手机',
  `qq` varchar(15) NOT NULL,
  `job` varchar(60) DEFAULT NULL COMMENT '职位',
  `IDNum` varchar(18) DEFAULT NULL COMMENT '身份证数字',
  `IDCard` varchar(37) DEFAULT NULL COMMENT '身份证正反面图片',
  `lineup` varchar(1) DEFAULT NULL COMMENT '是否在实名审核排队',
  `lineup_time` int(11) DEFAULT NULL COMMENT '开始排队时间',
  `graduated` varchar(60) DEFAULT NULL COMMENT '毕业院校',
  `workRemark` varchar(450) DEFAULT NULL COMMENT '工作经历',
  `marital` varchar(1) NOT NULL DEFAULT '0' COMMENT '婚姻状况0保密1已婚2未婚',
  `address` varchar(90) NOT NULL COMMENT '详细地址',
  `picture` varchar(18) DEFAULT NULL COMMENT '头像',
  `cover` varchar(18) DEFAULT NULL,
  `rna` varchar(1) NOT NULL DEFAULT '0' COMMENT '实名认证',
  `regTime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `loginTime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '今日首次登录时间',
  `loginDays` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录天数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
