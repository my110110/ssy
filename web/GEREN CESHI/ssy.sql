/*
 Navicat Premium Data Transfer

 Source Server         : 120.79.2.167
 Source Server Type    : MySQL
 Source Server Version : 50722
 Source Host           : 120.79.2.167:3306
 Source Schema         : ssy

 Target Server Type    : MySQL
 Target Server Version : 50722
 File Encoding         : 65001

 Date: 07/12/2018 10:20:14
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ad
-- ----------------------------
DROP TABLE IF EXISTS `ad`;
CREATE TABLE `ad`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `type` tinyint(4) DEFAULT 101 COMMENT '101 轮播图 102 友情链接',
  `category_id` int(11) DEFAULT 0,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `link` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `i-type-category`(`type`, `category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ad
-- ----------------------------
INSERT INTO `ad` VALUES (1, '百度', 101, 0, '/uploads/ad-img/img_5b21d2d781722.png', 'http://www.baidu.com', 1481640510, 1528943319);
INSERT INTO `ad` VALUES (2, '腾讯', 101, 0, '/uploads/ad-img/img_58500a67014d3.jpg', 'http://www.qq.com', 1481640551, 1481640751);
INSERT INTO `ad` VALUES (3, '网易', 101, 0, '/uploads/ad-img/img_58500a8b4fb51.png', 'http://www.163.com', 1481640587, 1481640587);
INSERT INTO `ad` VALUES (4, '去哪网', 102, 0, '', 'http://www.quna.com', 0, 0);
INSERT INTO `ad` VALUES (5, '携程', 102, 0, '', '', 0, 0);
INSERT INTO `ad` VALUES (6, '马蜂窝', 102, 0, '', '', 0, 0);
INSERT INTO `ad` VALUES (7, '面包旅行', 102, 0, '', '', 0, 0);

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `parent`(`parent`) USING BTREE,
  CONSTRAINT `admin_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `admin_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 39 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES (1, '产品管理', NULL, '/backend/products/index', 0, 0x7B2269636F6E22203A2266612066612D7468227D);
INSERT INTO `admin_menu` VALUES (2, '产品分类', 1, '/backend/category/index?type=2', 1, NULL);
INSERT INTO `admin_menu` VALUES (3, '产品列表', 1, '/backend/products/index', 0, NULL);
INSERT INTO `admin_menu` VALUES (4, '新闻管理', NULL, '/backend/news/index', 1, 0x7B2269636F6E223A2266612066612D6E65777370617065722D6F227D);
INSERT INTO `admin_menu` VALUES (5, '新闻列表', 4, '/backend/news/index', 0, NULL);
INSERT INTO `admin_menu` VALUES (6, '新闻分类', 4, '/backend/category/index?type=1', 1, NULL);
INSERT INTO `admin_menu` VALUES (7, '下载管理', NULL, '/backend/downloads/index', 2, 0x7B2269636F6E223A2266612066612D646F776E6C6F6164227D);
INSERT INTO `admin_menu` VALUES (8, '下载列表', 7, '/backend/downloads/index', 0, NULL);
INSERT INTO `admin_menu` VALUES (9, '下载分类', 7, '/backend/category/index?type=3', 1, NULL);
INSERT INTO `admin_menu` VALUES (10, '照片管理', NULL, '/backend/photos/index', 4, 0x7B2269636F6E223A2266612066612D706963747572652D6F227D);
INSERT INTO `admin_menu` VALUES (11, '相册列表', 10, '/backend/photos/index', 0, NULL);
INSERT INTO `admin_menu` VALUES (12, '相册分类', 10, '/backend/category/index?type=4', 1, NULL);
INSERT INTO `admin_menu` VALUES (13, '用户反馈', NULL, '/backend/feedback/index', 5, 0x7B2269636F6E223A2266612066612D636F6D6D656E74696E67227D);
INSERT INTO `admin_menu` VALUES (14, '网站配置', NULL, '/backend/config/index', 6, 0x7B2269636F6E223A2266612066612D636F67227D);
INSERT INTO `admin_menu` VALUES (15, '基础配置', 14, '/backend/config/base-config', 1, NULL);
INSERT INTO `admin_menu` VALUES (16, '其他配置', 14, '/backend/config/index', 2, NULL);
INSERT INTO `admin_menu` VALUES (17, '轮播图片', 14, '/backend/ad/index', 3, NULL);
INSERT INTO `admin_menu` VALUES (18, '后台配置', NULL, '/backend/rbac/route/index', 7, 0x7B2269636F6E223A2266612066612D62617273227D);
INSERT INTO `admin_menu` VALUES (19, '管理员列表', 18, '/backend/admin-user/index', 1, NULL);
INSERT INTO `admin_menu` VALUES (20, '权限配置', 18, '/backend/rbac/assignment/index', 2, NULL);
INSERT INTO `admin_menu` VALUES (21, '角色列表', 18, '/backend/rbac/role/index', 3, NULL);
INSERT INTO `admin_menu` VALUES (22, '权限列表', 18, '/backend/rbac/permission/index', 4, NULL);
INSERT INTO `admin_menu` VALUES (23, '规则列表', 18, '/backend/rbac/rule/index', 5, NULL);
INSERT INTO `admin_menu` VALUES (24, '路由列表', 18, '/backend/rbac/route/index', 5, NULL);
INSERT INTO `admin_menu` VALUES (25, '后台菜单', 18, '/backend/rbac/menu/index', 7, NULL);
INSERT INTO `admin_menu` VALUES (26, '开发工具', NULL, '/gii/default/index', 8, 0x7B2269636F6E223A2266612066612D7368617265227D);
INSERT INTO `admin_menu` VALUES (27, 'gii', 26, '/gii/default/index', 2, NULL);
INSERT INTO `admin_menu` VALUES (28, 'debug', 26, '/debug/default/index', 1, NULL);
INSERT INTO `admin_menu` VALUES (29, '模板主题配置', 14, '/backend/config/view-config', 2, NULL);
INSERT INTO `admin_menu` VALUES (30, '页面管理', 14, '/backend/page/index', 7, NULL);
INSERT INTO `admin_menu` VALUES (31, '友情链接', 14, '/backend/blogroll/index', 8, NULL);
INSERT INTO `admin_menu` VALUES (32, '实验项目', NULL, '/backend/project/index', NULL, NULL);
INSERT INTO `admin_menu` VALUES (33, '检测指标', NULL, '/backend/detection/index', NULL, NULL);
INSERT INTO `admin_menu` VALUES (34, '常规染色', 33, '/backend/routine/index', NULL, NULL);
INSERT INTO `admin_menu` VALUES (35, '特殊染色', 33, '/backend/particular/index', NULL, NULL);
INSERT INTO `admin_menu` VALUES (37, '蛋白指标', 33, '/backend/pna/index?type=1', NULL, NULL);
INSERT INTO `admin_menu` VALUES (38, '核酸指标', 33, '/backend/pna/index?type=2', NULL, NULL);

-- ----------------------------
-- Table structure for admin_user
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `access_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `roles` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `u-username`(`username`) USING BTREE,
  UNIQUE INDEX `u-email`(`email`) USING BTREE,
  UNIQUE INDEX `u-password-reset-token`(`password_reset_token`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES (1, 'admin', '', '21232f297a57a5a743894a0e4a801fc3', NULL, '739800600@qq.com', 10, '', 0, 1482893156, 1);
INSERT INTO `admin_user` VALUES (4, 'demo', '', 'fe01ce2a7fbac8fafaed7c982a04e229', NULL, 'demo@demo.com', 10, '', 1481431804, 1481431804, 0);
INSERT INTO `admin_user` VALUES (5, 'user', '0', '81dc9bdb52d04dc20036dbd8313ed055', NULL, '41943655@qq.com', 10, '', 1531295070, 1531295070, 1);

-- ----------------------------
-- Table structure for auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment`  (
  `item_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`, `user_id`) USING BTREE,
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('Administrator', '1', 1482897657);
INSERT INTO `auth_assignment` VALUES ('AdministratorAccess', '1', 1482897661);
INSERT INTO `auth_assignment` VALUES ('Visitor', '4', 1482897661);
INSERT INTO `auth_assignment` VALUES ('VisitorAccess', '4', 1482897661);

-- ----------------------------
-- Table structure for auth_item
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE,
  INDEX `rule_name`(`rule_name`) USING BTREE,
  INDEX `idx-auth_item-type`(`type`) USING BTREE,
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('/backend/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/ad/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/ad/create', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/ad/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/ad/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/ad/update', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/ad/upload', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/ad/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/admin-user/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/admin-user/create', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/admin-user/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/admin-user/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/admin-user/update', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/admin-user/upload', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/admin-user/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/blogroll/*', 2, NULL, NULL, NULL, 1490367199, 1490367199);
INSERT INTO `auth_item` VALUES ('/backend/blogroll/create', 2, NULL, NULL, NULL, 1490367193, 1490367193);
INSERT INTO `auth_item` VALUES ('/backend/blogroll/delete', 2, NULL, NULL, NULL, 1490367197, 1490367197);
INSERT INTO `auth_item` VALUES ('/backend/blogroll/index', 2, NULL, NULL, NULL, 1490367188, 1490367188);
INSERT INTO `auth_item` VALUES ('/backend/blogroll/update', 2, NULL, NULL, NULL, 1490367195, 1490367195);
INSERT INTO `auth_item` VALUES ('/backend/blogroll/view', 2, NULL, NULL, NULL, 1490367191, 1490367191);
INSERT INTO `auth_item` VALUES ('/backend/category/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/category/create', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/category/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/category/index', 2, NULL, NULL, NULL, 1482977677, 1482977677);
INSERT INTO `auth_item` VALUES ('/backend/category/index?type=1', 2, NULL, NULL, NULL, 1482977712, 1482977712);
INSERT INTO `auth_item` VALUES ('/backend/category/index?type=2', 2, NULL, NULL, NULL, 1482977717, 1482977717);
INSERT INTO `auth_item` VALUES ('/backend/category/index?type=3', 2, NULL, NULL, NULL, 1482977721, 1482977721);
INSERT INTO `auth_item` VALUES ('/backend/category/index?type=4', 2, NULL, NULL, NULL, 1482977728, 1482977728);
INSERT INTO `auth_item` VALUES ('/backend/category/update', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/category/upload', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/category/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/config/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/config/base-config', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/config/create', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/config/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/config/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/config/update', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/config/upload', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/config/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/config/view-config', 2, NULL, NULL, NULL, 1483066838, 1483066838);
INSERT INTO `auth_item` VALUES ('/backend/default/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/default/clear-cache', 2, NULL, NULL, NULL, 1490367249, 1490367249);
INSERT INTO `auth_item` VALUES ('/backend/default/edit-password', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/default/error', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/default/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/default/login', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/default/logout', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/default/ueditor', 2, NULL, NULL, NULL, 1490367249, 1490367249);
INSERT INTO `auth_item` VALUES ('/backend/detection/*', 2, NULL, NULL, NULL, 1528688617, 1528688617);
INSERT INTO `auth_item` VALUES ('/backend/detection/create', 2, NULL, NULL, NULL, 1528688617, 1528688617);
INSERT INTO `auth_item` VALUES ('/backend/detection/del', 2, NULL, NULL, NULL, 1528688617, 1528688617);
INSERT INTO `auth_item` VALUES ('/backend/detection/delete', 2, NULL, NULL, NULL, 1528688617, 1528688617);
INSERT INTO `auth_item` VALUES ('/backend/detection/delete_all', 2, NULL, NULL, NULL, 1528688617, 1528688617);
INSERT INTO `auth_item` VALUES ('/backend/detection/index', 2, NULL, NULL, NULL, 1528688617, 1528688617);
INSERT INTO `auth_item` VALUES ('/backend/detection/update', 2, NULL, NULL, NULL, 1528688617, 1528688617);
INSERT INTO `auth_item` VALUES ('/backend/detection/uploadfile', 2, NULL, NULL, NULL, 1528688617, 1528688617);
INSERT INTO `auth_item` VALUES ('/backend/detection/view', 2, NULL, NULL, NULL, 1528688617, 1528688617);
INSERT INTO `auth_item` VALUES ('/backend/downloads/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/downloads/check', 2, NULL, NULL, NULL, 1490367249, 1490367249);
INSERT INTO `auth_item` VALUES ('/backend/downloads/create', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/downloads/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/downloads/delete-all', 2, NULL, NULL, NULL, 1490367249, 1490367249);
INSERT INTO `auth_item` VALUES ('/backend/downloads/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/downloads/un-check', 2, NULL, NULL, NULL, 1490367249, 1490367249);
INSERT INTO `auth_item` VALUES ('/backend/downloads/update', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/downloads/upload', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/downloads/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/feedback/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/feedback/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/feedback/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/feedback/upload', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/feedback/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/news/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/news/check', 2, NULL, NULL, NULL, 1490367231, 1490367231);
INSERT INTO `auth_item` VALUES ('/backend/news/create', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/news/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/news/delete-all', 2, NULL, NULL, NULL, 1490367236, 1490367236);
INSERT INTO `auth_item` VALUES ('/backend/news/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/news/un-check', 2, NULL, NULL, NULL, 1490367233, 1490367233);
INSERT INTO `auth_item` VALUES ('/backend/news/update', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/news/upload', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/news/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/page/*', 2, NULL, NULL, NULL, 1483164471, 1483164471);
INSERT INTO `auth_item` VALUES ('/backend/page/create', 2, NULL, NULL, NULL, 1483164471, 1483164471);
INSERT INTO `auth_item` VALUES ('/backend/page/delete', 2, NULL, NULL, NULL, 1483164471, 1483164471);
INSERT INTO `auth_item` VALUES ('/backend/page/index', 2, NULL, NULL, NULL, 1483164471, 1483164471);
INSERT INTO `auth_item` VALUES ('/backend/page/update', 2, NULL, NULL, NULL, 1483164471, 1483164471);
INSERT INTO `auth_item` VALUES ('/backend/page/upload', 2, NULL, NULL, NULL, 1483164471, 1483164471);
INSERT INTO `auth_item` VALUES ('/backend/page/view', 2, NULL, NULL, NULL, 1483164471, 1483164471);
INSERT INTO `auth_item` VALUES ('/backend/particular/*', 2, NULL, NULL, NULL, 1528861228, 1528861228);
INSERT INTO `auth_item` VALUES ('/backend/particular/index', 2, NULL, NULL, NULL, 1528861338, 1528861338);
INSERT INTO `auth_item` VALUES ('/backend/photos/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/photos/check', 2, NULL, NULL, NULL, 1490367238, 1490367238);
INSERT INTO `auth_item` VALUES ('/backend/photos/create', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/photos/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/photos/delete-all', 2, NULL, NULL, NULL, 1490367242, 1490367242);
INSERT INTO `auth_item` VALUES ('/backend/photos/delete-detail', 2, NULL, NULL, NULL, 1490367249, 1490367249);
INSERT INTO `auth_item` VALUES ('/backend/photos/edit-detail', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/photos/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/photos/set-cover', 2, NULL, NULL, NULL, 1490367249, 1490367249);
INSERT INTO `auth_item` VALUES ('/backend/photos/un-check', 2, NULL, NULL, NULL, 1490367240, 1490367240);
INSERT INTO `auth_item` VALUES ('/backend/photos/update', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/photos/upload', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/photos/upload-photo', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/photos/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/pna/index', 2, NULL, NULL, NULL, 1528964551, 1528964551);
INSERT INTO `auth_item` VALUES ('/backend/pna/index?type=1', 2, NULL, NULL, NULL, 1528964674, 1528964674);
INSERT INTO `auth_item` VALUES ('/backend/pna/index?type=2', 2, NULL, NULL, NULL, 1528964812, 1528964812);
INSERT INTO `auth_item` VALUES ('/backend/pna/index.html?type=1', 2, NULL, NULL, NULL, 1528964624, 1528964624);
INSERT INTO `auth_item` VALUES ('/backend/pna/index.html?type=2', 2, NULL, NULL, NULL, 1528964630, 1528964630);
INSERT INTO `auth_item` VALUES ('/backend/products/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/products/check', 2, NULL, NULL, NULL, 1490367249, 1490367249);
INSERT INTO `auth_item` VALUES ('/backend/products/create', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/products/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/products/delete-all', 2, NULL, NULL, NULL, 1490367249, 1490367249);
INSERT INTO `auth_item` VALUES ('/backend/products/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/products/un-check', 2, NULL, NULL, NULL, 1490367249, 1490367249);
INSERT INTO `auth_item` VALUES ('/backend/products/update', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/products/upload', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/products/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/project/index', 2, NULL, NULL, NULL, 1526889827, 1526889827);
INSERT INTO `auth_item` VALUES ('/backend/rbac/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/assignment/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/assignment/assign', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/assignment/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/assignment/revoke', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/assignment/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/default/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/default/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/menu/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/menu/create', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/menu/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/menu/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/menu/update', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/menu/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/permission/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/permission/assign', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/permission/create', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/permission/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/permission/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/permission/remove', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/permission/update', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/permission/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/role/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/role/assign', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/role/create', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/role/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/role/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/role/remove', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/role/update', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/role/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/route/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/route/assign', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/route/create', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/route/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/route/refresh', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/route/remove', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/rule/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/rule/create', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/rule/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/rule/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/rule/update', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/rule/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/user/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/user/activate', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/user/change-password', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/user/delete', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/user/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/user/login', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/user/logout', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/user/request-password-reset', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/user/reset-password', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/user/signup', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/rbac/user/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/backend/routine/*', 2, NULL, NULL, NULL, 1528858886, 1528858886);
INSERT INTO `auth_item` VALUES ('/backend/routine/index', 2, NULL, NULL, NULL, 1528858874, 1528858874);
INSERT INTO `auth_item` VALUES ('/backend/special/index', 2, NULL, NULL, NULL, 1528700379, 1528700379);
INSERT INTO `auth_item` VALUES ('/debug/*', 2, NULL, NULL, NULL, 1482977163, 1482977163);
INSERT INTO `auth_item` VALUES ('/debug/default/*', 2, NULL, NULL, NULL, 1482977163, 1482977163);
INSERT INTO `auth_item` VALUES ('/debug/default/db-explain', 2, NULL, NULL, NULL, 1482977163, 1482977163);
INSERT INTO `auth_item` VALUES ('/debug/default/download-mail', 2, NULL, NULL, NULL, 1482977163, 1482977163);
INSERT INTO `auth_item` VALUES ('/debug/default/index', 2, NULL, NULL, NULL, 1482977163, 1482977163);
INSERT INTO `auth_item` VALUES ('/debug/default/toolbar', 2, NULL, NULL, NULL, 1482977163, 1482977163);
INSERT INTO `auth_item` VALUES ('/debug/default/view', 2, NULL, NULL, NULL, 1482977163, 1482977163);
INSERT INTO `auth_item` VALUES ('/gii/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/gii/default/*', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/gii/default/action', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/gii/default/diff', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/gii/default/index', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/gii/default/preview', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('/gii/default/view', 2, NULL, NULL, NULL, 1482896720, 1482896720);
INSERT INTO `auth_item` VALUES ('Administrator', 1, '超级管理员', NULL, NULL, 1482896582, 1482898405);
INSERT INTO `auth_item` VALUES ('AdministratorAccess', 2, '超级管理员权限', NULL, NULL, 1482897169, 1482898428);
INSERT INTO `auth_item` VALUES ('Visitor', 1, '后台参观者', 'VisitorRule', NULL, 1482897794, 1482899002);
INSERT INTO `auth_item` VALUES ('VisitorAccess', 2, '浏览者权限，只读权限', 'VisitorRule', NULL, 1482897866, 1482898974);
INSERT INTO `auth_item` VALUES ('管理员权限', 2, '管理员权限', NULL, NULL, 1531294615, 1531294666);

-- ----------------------------
-- Table structure for auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child`  (
  `parent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`, `child`) USING BTREE,
  INDEX `child`(`child`) USING BTREE,
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/ad/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/create');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/ad/create');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/ad/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/ad/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/update');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/ad/update');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/upload');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/ad/upload');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/ad/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/ad/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/create');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/create');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/update');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/update');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/upload');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/upload');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/admin-user/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/admin-user/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/category/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/category/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/category/create');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/category/create');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/category/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/category/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/category/update');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/category/update');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/category/upload');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/category/upload');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/category/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/category/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/config/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/config/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/config/base-config');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/config/base-config');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/config/create');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/config/create');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/config/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/config/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/config/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/config/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/config/update');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/config/update');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/config/upload');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/config/upload');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/config/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/config/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/config/view-config');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/default/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/default/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/default/edit-password');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/default/edit-password');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/default/error');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/default/error');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/default/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/default/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/default/login');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/default/login');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/default/logout');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/default/logout');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/create');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/create');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/update');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/update');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/upload');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/upload');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/downloads/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/downloads/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/feedback/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/feedback/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/feedback/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/feedback/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/feedback/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/feedback/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/feedback/upload');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/feedback/upload');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/feedback/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/feedback/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/news/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/news/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/news/create');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/news/create');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/news/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/news/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/news/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/news/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/news/update');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/news/update');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/news/upload');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/news/upload');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/news/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/news/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/photos/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/create');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/photos/create');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/photos/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/edit-detail');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/photos/edit-detail');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/photos/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/update');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/photos/update');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/upload');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/photos/upload');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/upload-photo');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/photos/upload-photo');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/photos/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/photos/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/products/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/products/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/products/create');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/products/create');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/products/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/products/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/products/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/products/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/products/update');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/products/update');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/products/upload');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/products/upload');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/products/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/products/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/assignment/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/assignment/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/assignment/assign');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/assignment/assign');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/assignment/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/assignment/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/assignment/revoke');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/assignment/revoke');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/assignment/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/assignment/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/default/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/default/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/default/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/default/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/menu/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/menu/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/menu/create');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/menu/create');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/menu/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/menu/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/menu/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/menu/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/menu/update');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/menu/update');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/menu/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/menu/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/assign');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/assign');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/create');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/create');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/remove');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/remove');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/update');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/update');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/permission/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/permission/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/assign');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/assign');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/create');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/create');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/remove');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/remove');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/update');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/update');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/role/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/role/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/route/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/route/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/route/assign');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/route/assign');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/route/create');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/route/create');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/route/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/route/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/route/refresh');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/route/refresh');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/route/remove');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/route/remove');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/rule/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/rule/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/rule/create');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/rule/create');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/rule/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/rule/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/rule/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/rule/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/rule/update');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/rule/update');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/rule/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/rule/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/*');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/activate');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/activate');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/change-password');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/change-password');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/delete');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/delete');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/index');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/login');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/login');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/logout');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/logout');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/request-password-reset');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/request-password-reset');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/reset-password');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/reset-password');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/signup');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/signup');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/backend/rbac/user/view');
INSERT INTO `auth_item_child` VALUES ('VisitorAccess', '/backend/rbac/user/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/debug/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/debug/default/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/debug/default/db-explain');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/debug/default/download-mail');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/debug/default/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/debug/default/toolbar');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/debug/default/view');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/gii/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/gii/default/*');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/gii/default/action');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/gii/default/diff');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/gii/default/index');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/gii/default/preview');
INSERT INTO `auth_item_child` VALUES ('AdministratorAccess', '/gii/default/view');

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule`  (
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `data` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of auth_rule
-- ----------------------------
INSERT INTO `auth_rule` VALUES ('VisitorRule', 'O:36:\"app\\modules\\backend\\rbac\\VisitorRule\":3:{s:4:\"name\";s:11:\"VisitorRule\";s:9:\"createdAt\";i:1482898941;s:9:\"updatedAt\";i:1482898941;}', 1482898941, 1482898941);

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类名',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT '父id',
  `path` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '完整的父id 用/分开',
  `type` tinyint(4) NOT NULL COMMENT '1.news 2 products 3 download 4 photo',
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `i-type-pid`(`type`, `pid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES (1, '游学研学', 0, '1', 2, '', '', '', 1481360463, 1527649355);
INSERT INTO `category` VALUES (2, '默认分类', 0, '1', 1, '/uploads/products-img/img_58f32726aa3df.png', '测试', '测试，测试测试', 1481367786, 1527649355);
INSERT INTO `category` VALUES (3, '新闻分类2', 2, '2', 1, '', '', '', 1481372394, 1499598678);
INSERT INTO `category` VALUES (4, '旅行度假', 0, '1', 2, '/uploads/products-img/img_5b2201cfd89f5.png', '', '', 1481609361, 1528955343);
INSERT INTO `category` VALUES (5, '下载文档', 0, '1', 3, '', '', '', 1482155225, 1527649356);
INSERT INTO `category` VALUES (6, '企业环境', 0, '1', 4, '', '', '', 1482559711, 1527649356);
INSERT INTO `category` VALUES (7, '商务考察', 0, '1', 2, '', '', '', 1490457590, 1527649356);
INSERT INTO `category` VALUES (8, '测试修改path', 0, '1', 1, '', '', '', 1498831600, 1527649356);
INSERT INTO `category` VALUES (9, '测试修改path2', 3, '1', 1, '', '', '', 1498832464, 1527649356);
INSERT INTO `category` VALUES (10, '修改path3', 9, '9', 1, '', '', '', 1498832583, 1499598673);
INSERT INTO `category` VALUES (11, '测试', 1, '1', 2, '', '123', '123', 1527649355, 1527649355);

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '名称',
  `number` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '货号 ',
  `company` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '公司名称',
  `http` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '官方网址',
  `method` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '配置方法',
  `savetion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '保存方法',
  `rid` int(11) DEFAULT NULL COMMENT '试剂ID',
  `isdel` tinyint(1) DEFAULT 0 COMMENT '是否删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES (3, NULL, 'sw12134', '市三院1', 'https://www.yiiframework.com/doc/api/2.0/yii-base-viewnotfoundexception', '12321', '123', 2, 0);
INSERT INTO `company` VALUES (4, NULL, 'wwe1214141', '市三院2', 'https://www.baidu.com/s?wd=yii_queue&ie=UTF-8', '打的', '真空', 2, 1);
INSERT INTO `company` VALUES (5, NULL, 'we12313', '市三院2', 'https://www.baidu.com/s?wd=%E5%9C%A8%E7%BA%BF%E7%BF%BB%E8%AF%91&ie=UTF-8', '勾兑', '冷藏', 2, 1);
INSERT INTO `company` VALUES (6, NULL, '23we123131', '德州', 'http://fanyi.baidu.com/#zh/en/%E6%A3%80%E6%B5%8B%E6%96%B9%E6%B3%95', '搅拌', '冷藏', 6, 0);
INSERT INTO `company` VALUES (7, NULL, 'qw123445', '市五院', 'http://ssy.local.cn/backend/company/create.html?id=7', '搅拌', '冷藏', 7, 0);
INSERT INTO `company` VALUES (8, NULL, 'wq1212', '十特殊染色1', 'https://www.yiichina.com/tutorial/1405', '123', '123', 11, 0);
INSERT INTO `company` VALUES (9, NULL, 'wq1213', '是安远', 'http://www.yiichina.com/question/206', '配置方法', '配置方法', 7, 0);
INSERT INTO `company` VALUES (10, NULL, '1212', '测试数据1', 'http://ssy.local.cn/backend/reagent/view.html?id=2', '凉拌', '冷藏', 2, 0);
INSERT INTO `company` VALUES (11, NULL, '1221', '测试数据2', 'http://ssy.local.cn/backend/reagent/view.html?id=2', '凉拌', '冷藏', 2, 0);
INSERT INTO `company` VALUES (12, NULL, '1212', '测试数据1', 'http://ssy.local.cn/backend/reagent/view.html?id=2', '凉拌', '冷藏', 21, 0);
INSERT INTO `company` VALUES (13, NULL, '1221', '测试数据2', 'http://ssy.local.cn/backend/reagent/view.html?id=2', '凉拌', '冷藏', 21, 0);

-- ----------------------------
-- Table structure for config
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '字段名英文',
  `label` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '字段标注',
  `value` varchar(3000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '字段值',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `iu-name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of config
-- ----------------------------
INSERT INTO `config` VALUES (2, 'contact_us', '联系我们', '<p>公司: 在北京网络科技</p><p>联系人: 李sss</p><p>QQ: 739800600</p><p>电话: 1304351</p><p>E-mail: 739800600@qq.com</p><p>地址: 北京市丰台区大红门</p>', 1481350005, 1482902162);
INSERT INTO `config` VALUES (3, 'contact_us_page_id', '联系我们', '1', 1481355647, 1483169811);
INSERT INTO `config` VALUES (4, 'jianjie', '企业简介', '北京雄鹰国际旅行社是新时代投资管理集团旗下的专业旅游平台,依托集团广泛而强大的资源和团队，雄鹰国旅专注于游学交流，商务考察，专项旅行，帆船体验，机票代理等，致力于通过旅行提高青少年的品格与素养，为旅行者提供专业化，个性化的优质服务testtesttest', 1490458199, 1490458199);
INSERT INTO `config` VALUES (5, 'gongyi', '公益广告', '<script type=\"text/javascript\"> var yibo_id =40276;</script><script src=\"http://yibo.iyiyun.com/yibo.js?random=309727\" type=\"text/javascript\"></script>', 1494309812, 1494309845);
INSERT INTO `config` VALUES (6, 'top_right_data', '头部右侧数据', '电话:13240702278,17346512591', 1507598988, 1507598988);

-- ----------------------------
-- Table structure for content
-- ----------------------------
DROP TABLE IF EXISTS `content`;
CREATE TABLE `content`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '类型1news,2product3photo',
  `category_id` int(11) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '缩略图',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0不显示1显示',
  `admin_user_id` int(11) NOT NULL DEFAULT 0,
  `hits` int(11) NOT NULL DEFAULT 0 COMMENT '浏览数点击数',
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `i-type-status-title`(`type`, `status`, `title`) USING BTREE,
  INDEX `i-update`(`updated_at`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of content
-- ----------------------------
INSERT INTO `content` VALUES (1, '测试1', 1, 0, '', '测试测试222', '', 1, 0, 0, 0, 1481269292);
INSERT INTO `content` VALUES (7, '新闻2', 1, 3, '', '吃豆腐的房地产', '', 0, 0, 0, 1481264976, 1481379895);
INSERT INTO `content` VALUES (9, 'dfdsfadfdsfdsfds', 1, 0, '', 'dfsdds', '', 0, 0, 0, 1481265228, 1481265228);
INSERT INTO `content` VALUES (10, 'dfsdfds312321的所得税法', 1, 0, '', '的范德萨发的', '', 0, 1, 0, 1481265362, 1481265362);
INSERT INTO `content` VALUES (11, '测试你好', 1, 0, '', '三大市场', '', 1, 1, 0, 1481265454, 1481265454);
INSERT INTO `content` VALUES (13, 'sdfdsvds', 1, 0, '', 'dsfadsfdsa adfdasfd', '', 0, 1, 0, 1481265650, 1481265650);
INSERT INTO `content` VALUES (14, 'dfsdfds312321的所得税法dsfdsf', 1, 0, '', 'fdsdsfsdfds', '', 0, 1, 0, 1481268136, 1481268136);
INSERT INTO `content` VALUES (15, '测试测试测试', 1, 0, '', '测试测试222', '', 0, 1, 0, 1481268506, 1481268506);
INSERT INTO `content` VALUES (16, '电风扇的范德萨', 1, 0, '', '东方闪电', '', 0, 1, 0, 1481268645, 1481268645);
INSERT INTO `content` VALUES (17, 'ceshi', 1, 2, '', '测试', '', 1, 1, 0, 1481294417, 1482486244);
INSERT INTO `content` VALUES (18, '测试测试', 1, 0, '', '测试3333333', '', 1, 1, 1, 1481294436, 1481294436);
INSERT INTO `content` VALUES (19, '测试测试测试', 1, 2, '', '测试测试', '', 1, 1, 14, 1481294458, 1482120320);
INSERT INTO `content` VALUES (22, '测试测试测试', 2, 1, '/uploads/products-img/img_584d57438ddb0.jpg', '测试测试测试', '', 1, 1, 0, 1481463619, 1481463619);
INSERT INTO `content` VALUES (23, '测试产品22222222222222', 2, 1, '/uploads/products-img/img_584d5d65a0855.jpg', '测试产品', '', 1, 1, 0, 1481465189, 1481465189);
INSERT INTO `content` VALUES (24, '飒飒的范德萨范德萨似懂非懂是', 2, 1, '/uploads/products-img/img_58575c9b83b7b.png', '<p>似懂非懂是付的是</p><p><br></p>', '', 1, 1, 3, 1481465708, 1482120751);
INSERT INTO `content` VALUES (25, '美国代购2016 MOTHER 女士磨边牛仔裤', 2, 1, '/uploads/products-img/img_584eb27571659.jpg', '重度磨损和猫须褶皱为这款褪色 MOTHER 牛仔裤带来做旧效果。5 口袋设计。钮扣和拉链门襟。', '', 1, 1, 6, 1481552501, 1481552688);
INSERT INTO `content` VALUES (26, '关于公司考勤制度', 3, 5, '', '<p>关于公司考勤制度</p>', '', 1, 1, 0, 1482155706, 1482157422);
INSERT INTO `content` VALUES (27, '测试', 3, 5, '', '', '', 0, 1, 0, 1482200020, 1482202904);
INSERT INTO `content` VALUES (28, '继承测试', 1, 2, '', '继承测试', 'gggg', 1, 1, 10, 1482291369, 1510469205);
INSERT INTO `content` VALUES (30, '办公环境', 4, 6, '', '', '', 1, 1, 8, 1482560413, 1482560413);
INSERT INTO `content` VALUES (31, '测试相册', 4, 6, '', '测试', '测试', 1, 1, 0, 1482654720, 1482654720);
INSERT INTO `content` VALUES (32, 'cccc', 3, 5, '', '', 'ssss', 0, 1, 0, 1489731591, 1494326191);
INSERT INTO `content` VALUES (34, '1312', 3, 5, '', '', '123', 0, 1, 0, 1528942723, 1528942723);

-- ----------------------------
-- Table structure for content_detail
-- ----------------------------
DROP TABLE IF EXISTS `content_detail`;
CREATE TABLE `content_detail`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `detail` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `params` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `file_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `i-content`(`content_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 42 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of content_detail
-- ----------------------------
INSERT INTO `content_detail` VALUES (1, 1, '测试detail,123232,45454545', '', '', 1481264096, 1481269292);
INSERT INTO `content_detail` VALUES (3, 7, '测试测试', '', '', 1481264976, 1481379895);
INSERT INTO `content_detail` VALUES (4, 9, 'dsfdsfdsfdsfdsdfsdfds', '', '', 1481265228, 1481265228);
INSERT INTO `content_detail` VALUES (5, 10, '打算vdsvdsdsfadf是打发第三方打发第三方', '', '', 1481265362, 1481265362);
INSERT INTO `content_detail` VALUES (6, 11, '是的撒FDSAD', '', '', 1481265454, 1481265454);
INSERT INTO `content_detail` VALUES (7, 13, 'dfadsfda', '', '', 1481265650, 1481265650);
INSERT INTO `content_detail` VALUES (8, 14, 'dsfdsfdsfdsfds', '', '', 1481268136, 1481268136);
INSERT INTO `content_detail` VALUES (9, 15, '电风扇的范德萨发生的', '', '', 1481268506, 1481268506);
INSERT INTO `content_detail` VALUES (10, 16, '大多数是范德萨', '', '', 1481268645, 1481268645);
INSERT INTO `content_detail` VALUES (11, 17, '<p><img src=\"/uploads/redactor-img/1/892f7f6043-9c1ab2f5-f848-4e09-bb3e-9b10c2938520.png\" alt=\"892f7f6043-9c1ab2f5-f848-4e09-bb3e-9b10c2938520.png\"/>测试测试</p>', '', '', 1481294417, 1482486244);
INSERT INTO `content_detail` VALUES (12, 18, '测试测试测试', '', '', 1481294436, 1481294436);
INSERT INTO `content_detail` VALUES (13, 19, '<p>水电费的所得税法</p><p><img src=\"/uploads/redactor-img/1/892f7f6043-9c1ab2f5-f848-4e09-bb3e-9b10c2938520.png\"></p><p><br></p><p><img></p>', '', '', 1481294458, 1482120320);
INSERT INTO `content_detail` VALUES (14, 20, '<p><img></p><p><img src=\"/uploads/redactor-img/1/3c779817e7-9c1ab2f5-f848-4e09-bb3e-9b10c2938520.png\"></p><p><img></p><p><img></p><p>发货相关问题</p><p>SEND ABOUT</p><p>购买来源：本店所有商品均为海外购，所有海外购商品均从（美国、欧洲、香港）正品专柜、官网、百货公司购买，正品保证，请放心选购。</p><p>邮寄方式：本店商品均为海外直发，欧洲商家一般经由我们香港仓、澳门仓等中转再转发国内快递发往您；美国商家一般采用美国直邮方式到国内自动转为EMS直接发往您。</p><p>物流显示：因淘宝物流显示问题，本店商品到达国内才会转为发货状态并显示国内物流单号。一般商品到货时间为2-4周。因而当您的订单淘宝未显示发货，请不要心急，商品都在正常国际运输中，我们全程为您监控物流进程，如有异常会及时通知您。如有疑问，可以咨询在线客服，请勿催单哦！</p><p>特别提醒：以上发货及运送时间均为理论时效，但偶有意外如恶劣天气、清关延误、节假日等国际物流的不确定因素请理性看待。</p><p>退换货政策详解</p><p>RETURN POLICY</p><p>商品签收： 确认签收前，请务必 本人签收 ，并当场拍照验货。如遇 严重质量问题或商品错发 请保留商品问题照片及物流签收有效凭证联系 在线客服处理。 如签收后发现严重质量问题请在签收时间起 48小时内 联系处理， 过后恕不负责，且需保持商品完好无损 （产品包装、吊牌、配件保持原样情况下）。 本店不接受任何形式的拒收 ，如因拒收产生一切后果由收件人负责。</p><p>退换说明： 本店不支持退换货，除严重商品质量问题和商品错发外。</p><p>码数、型号、颜色、款式、均由顾客自行决定，客服建议只供参考，不对此负责，不作为退换货理由。</p><p>所有主观原因(但不限于)：面料与想象有差距，例如厚薄或透明度、手感软硬等。不适合自己、穿上不好看、没想象中漂亮。个人认为做工不好等。细微瑕疵、线头、不明显或可去除的画粉痕迹、极好处理的小脱线，存在于鞋底的污迹或刮痕，不明显处的走线不直、偶尔有烫钻装饰的脱落、细微的印花脱落开裂、羽毛制品轻量掉毛，因运输造成的不平整或皱折、不同显示器解析度和颜色质量造成的网上图片与实物颜色存在一定色差、主观认为不是正品等，均不属于质量问题，不支持退换货。</p><p>退货地址：由于我公司为海外公司，商品均为海外直发， 退货需退回指定的海外物流仓库，详情请咨询在线客服。若因寄到非指定的退货地址，造成商品退换货失败，客户需自行承担后果。</p><p>差价问题：关于打折商品购买之后再度打折，或原来价格商品购买之后打折的情况，本店不退差价。</p><p>关税问题：  如遇海关查验，按照海关规定，收件人为办理清关和交纳税金的责任人。 税金产生后无法办理退货退款 。 为保证清关的顺利， 请填写收件人姓名的时候务必使用真实姓名 ，如使用假名将无法正常完成清关，导致扣件等情况，一切后果将由收件人承担。</p><p>如协商一致退货，请务必遵守如下规则：</p><p>本店不接受未经沟通自主邮寄包裹的退换货，如自行邮寄一律拒收。</p><p>本店不接受任何到付件，寄送包裹需要亲先行垫付邮费。</p><p>请务必保持退货商品的标签吊牌包装等的商品完整性。</p><p>寄出包裹后，请联系客服告知物流公司和运单号码，方便客服查询。</p>', '', '', 1481455753, 1482071209);
INSERT INTO `content_detail` VALUES (15, 21, 'sadsadsadasdas122333333', '', '', 1481463544, 1481552670);
INSERT INTO `content_detail` VALUES (16, 22, '测试测试测试', '', '', 1481463619, 1481463619);
INSERT INTO `content_detail` VALUES (17, 23, '测试测试测试', '', '', 1481465189, 1481465189);
INSERT INTO `content_detail` VALUES (18, 24, '<p>sdsadsadasdsaasdsadcas</p><p><img src=\"/uploads/redactor-img/1/99ebc906c2-a165a89a-83d3-4882-948c-a551be1bb769.jpg\"></p>', '', '', 1481465708, 1482120751);
INSERT INTO `content_detail` VALUES (19, 25, '商品由美国百货公司发货，下单即采购。约1~2周到货。\r\n商品货号：s1569032116\r\n商品说明：\r\n重度磨损和猫须褶皱为这款褪色 MOTHER 牛仔裤带来做旧效果。5 口袋设计。钮扣和拉链门襟。\r\n\r\n面料: 弹性牛仔布。\r\n98% 棉 / 2% 弹性纤维。\r\n冷水洗涤。\r\n美国制造。\r\n进口面料。\r\n\r\n尺寸\r\n裆高: 9.75 英寸 / 25 厘米\r\n裤子内长: 28.75 英寸 / 73 厘米\r\n裤脚口: 11.75 英寸 / 30 厘米\r\n所列尺寸以 27 号为标准 2010 年，受到突破传统牛仔裤的启发，业内专家 Lela Tillem (Citizens of Humanity) 和 Tim Kaeding (7 For All Mankind) 推出了 MOTHER 牛仔服饰：精致裁剪、超软织物的奢华牛仔裤系列。MOTHER 牛仔裤将显长腿部的外型、创新的水洗工艺、完美的修身效果和令人难以置信的舒适感融入到高度演变的奢华牛仔系列中。这款高级牛仔裤适合并修饰各种体型。 查看所有 MOTHER 的评论\r\n售后服务：香港仓库收到日期计起30天可以申请退换货,final sale不退不换,商家运费$35\r\n最后更新：2016-10-27 22:03', '', '', 1481552501, 1481552688);
INSERT INTO `content_detail` VALUES (20, 26, '<p>关于公司考勤制度</p>', '', '/uploads/downloads/yiicms5857e77c7167d.zip', 1482155706, 1482157422);
INSERT INTO `content_detail` VALUES (21, 27, '<p>测试测试<span class=\"redactor-invisible-space\">测试<span class=\"redactor-invisible-space\">测试<span class=\"redactor-invisible-space\">测试<span class=\"redactor-invisible-space\">测试<span class=\"redactor-invisible-space\"></span></span></span></span></span></p>', '', '/uploads/downloads/yiicms585893d4e19c8.zip', 1482200020, 1482202904);
INSERT INTO `content_detail` VALUES (22, 28, '<p>继承测试</p>', '', '', 1482291369, 1482291661);
INSERT INTO `content_detail` VALUES (23, 29, '<p>产品继承</p>', '<p>产品继承</p>', '', NULL, 1482325074);
INSERT INTO `content_detail` VALUES (24, 30, '', '', '/uploads/photos/30/img_585e2a68b0fe2.jpg', 1482566248, 1482566248);
INSERT INTO `content_detail` VALUES (25, 30, '', '', '/uploads/photos/30/img_585e2abda64a2.jpg', 1482566333, 1482566333);
INSERT INTO `content_detail` VALUES (26, 30, '', '', '/uploads/photos/30/img_585f60a17b4fa.jpg', 1482645665, 1482645665);
INSERT INTO `content_detail` VALUES (27, 30, '', '', '/uploads/photos/30/img_585f60a888c8a.jpg', 1482645672, 1482645672);
INSERT INTO `content_detail` VALUES (28, 30, '', '', '/uploads/photos/30/img_585f60bbb3340.jpg', 1482645691, 1482645691);
INSERT INTO `content_detail` VALUES (29, 30, '', '', '/uploads/photos/30/img_585f73b9d439b.jpg', 1482650553, 1482650553);
INSERT INTO `content_detail` VALUES (30, 30, '', '', '/uploads/photos/30/img_585f7414e39c8.jpg', 1482650644, 1482650644);
INSERT INTO `content_detail` VALUES (31, 30, '', '', '/uploads/photos/30/img_585f7a31d66e1.jpg', 1482652209, 1482652209);
INSERT INTO `content_detail` VALUES (32, 30, '', '', '/uploads/photos/30/img_585f7a84578d6.jpg', 1482652292, 1482652292);
INSERT INTO `content_detail` VALUES (33, 30, '', '', '/uploads/photos/30/img_585f7afeb8410.jpg', 1482652414, 1482652414);
INSERT INTO `content_detail` VALUES (34, 30, '', '', '/uploads/photos/30/img_585f7c8f432bd.png', 1482652815, 1482652815);
INSERT INTO `content_detail` VALUES (35, 30, '', '', '/uploads/photos/30/img_585f7cabe31fd.jpg', 1482652843, 1482652843);
INSERT INTO `content_detail` VALUES (36, 31, 'ceshi', '', '/uploads/photos/31/img_585f8410249c6.jpg', 1482654736, 1482913682);
INSERT INTO `content_detail` VALUES (37, 31, '测试2', '', '/uploads/photos/31/img_585f84183ea3b.jpg', 1482654744, 1482822674);
INSERT INTO `content_detail` VALUES (38, 31, 'ceshi34', '', '/uploads/photos/31/img_585f8410249c6.jpg', 1482655165, 1482913687);
INSERT INTO `content_detail` VALUES (39, 32, '<p>ssss</p>', '', '/uploads/downloads/yiicms58cb8007d61e7.rar', 1489731591, 1489731591);
INSERT INTO `content_detail` VALUES (40, 33, '<p>是打发第三方</p>', '<p>胜多负少订单上</p>', '', 1494325122, 1494325122);
INSERT INTO `content_detail` VALUES (41, 34, '<p>123213123</p>', '', '/uploads/downloads/yiicms5b21d083241a8.rar', 1528942723, 1528942723);

-- ----------------------------
-- Table structure for feedback
-- ----------------------------
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject` varchar(125) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `phone` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `body` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL DEFAULT 0,
  `updated_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of feedback
-- ----------------------------
INSERT INTO `feedback` VALUES (1, '测试测试', '李先生', '13240702278', '739800600@qq.com', '你好你好你好', 1481433870, 1481433870);
INSERT INTO `feedback` VALUES (2, '你好', '你好', '', '739800600@qq.com', '你好，你好', 1481434463, 1481434463);
INSERT INTO `feedback` VALUES (3, 'sddfsfsfds', 'dsfsdfsdds', '', '739800600@qq.com', 'sdfdsfds', 1501242456, 1501242456);
INSERT INTO `feedback` VALUES (4, 'ddddddd', 'ddddd', '', '739800600@qq.com', 'dsfsdfds', 1501242645, 1501242645);
INSERT INTO `feedback` VALUES (5, 'dsfsdfdsfsd', 'dddd', '', '739800600@qq.com', 'dsfsdfdsfds', 1501397774, 1501397774);

-- ----------------------------
-- Table structure for group
-- ----------------------------
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '分组ID',
  `group_retrieve` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '项目分组检索号',
  `pro_id` int(11) NOT NULL COMMENT '所属项目id',
  `group_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '项目分组描述',
  `group_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '项目分组名称',
  `group_sample_count` int(11) DEFAULT NULL COMMENT '项目分组样品个数',
  `group_sample_handle_type` tinyint(1) DEFAULT NULL COMMENT '细胞的处理方式',
  `group_experiment_type` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '组织的实验流程',
  `group_add_time` datetime(0) DEFAULT NULL COMMENT '添加时间',
  `group_add_user` int(11) DEFAULT NULL COMMENT '添加人',
  `group_change_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '修改时间',
  `group_change_user` int(11) DEFAULT NULL COMMENT '修改人',
  `group_del_time` datetime(0) DEFAULT NULL COMMENT '项目删除时间',
  `isdel` tinyint(1) DEFAULT 0 COMMENT '删除',
  `group_del_user` int(11) DEFAULT NULL COMMENT '删除人',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '样本图片',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of group
-- ----------------------------
INSERT INTO `group` VALUES (8, 'PSEG1527904851', 17, '切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片切片', '分组1', 12, NULL, '切片', '2018-06-02 06:41:26', 1, '2018-06-24 03:08:47', 1, '2018-06-02 03:48:46', 0, 1, NULL);
INSERT INTO `group` VALUES (9, 'PSEG1527911243', 17, '切片', '分组2', 2, NULL, '切片', '2018-06-02 03:47:23', 1, '2018-06-02 11:50:03', NULL, '2018-06-02 03:48:27', 0, 1, NULL);
INSERT INTO `group` VALUES (10, 'PSEG1529637692', 18, '项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述项目分组描述', '分组3', 23, NULL, '切片', '2018-06-22 03:21:32', 1, '2018-06-24 02:34:29', 1, NULL, 0, NULL, NULL);
INSERT INTO `group` VALUES (11, 'PSEG1529740476D2', 25, '描述', '导入分组1', 3, NULL, '切片', '2018-06-23 07:54:36', 1, '2018-06-23 15:54:36', NULL, NULL, 0, NULL, NULL);
INSERT INTO `group` VALUES (12, 'PSEG1531795578A0', 17, '3', '测试分组', 1, NULL, '2', '2018-07-17 02:46:18', 1, '2018-07-17 10:46:18', NULL, NULL, 0, NULL, '/uploads/products-img/img_5b4d587a22128.png');

-- ----------------------------
-- Table structure for hedyeing
-- ----------------------------
DROP TABLE IF EXISTS `hedyeing`;
CREATE TABLE `hedyeing`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `retrieve` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '检测指标检索号',
  `section_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '切片名称',
  `section_type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '切片类型',
  `section_thickness` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '切片厚度',
  `section_preprocessing` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '切片预处理',
  `testflow` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '实验流程',
  `img` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '图片路径',
  `place` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '存放位置',
  `add_user` int(11) DEFAULT NULL,
  `add_time` datetime(0) DEFAULT NULL,
  `change_user` int(11) DEFAULT NULL,
  `change_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `isdel` int(11) DEFAULT NULL,
  `del_time` datetime(0) DEFAULT NULL,
  `del_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for kit
-- ----------------------------
DROP TABLE IF EXISTS `kit`;
CREATE TABLE `kit`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '名称',
  `number` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '货号 ',
  `company` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '公司名称',
  `http` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '官方网址',
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '类型',
  `savetion` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '保存方法',
  `rid` int(11) DEFAULT NULL COMMENT '试剂ID',
  `isdel` tinyint(1) DEFAULT 0 COMMENT '是否删除',
  `retrieve` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '检索号',
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '说明书',
  `pdf` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '说明书路径',
  `pdf_real` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '说明书路径',
  `add_time` datetime(0) DEFAULT NULL COMMENT '添加时间',
  `change_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '修改时间',
  `change_user` int(11) DEFAULT NULL COMMENT '修改人',
  `del_time` datetime(0) DEFAULT NULL COMMENT '删除时间',
  `tid` int(11) DEFAULT NULL COMMENT '检测方法id',
  `typeid` tinyint(1) DEFAULT NULL COMMENT '1抗体  2核酸试剂盒 3商品试剂',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kit
-- ----------------------------
INSERT INTO `kit` VALUES (12, '商品试剂1', '12313', '市三院', 'http://ssy.yiiweb.cn/backend/kit/create.html?id=3&type=testmethod', 'testmethod', '', 1, 0, 'TER1528946036', '', 'uploads/pdf/TER1528946036.pdf', NULL, '2018-06-14 14:30:58', '2018-06-22 17:13:13', NULL, NULL, 3, 3);
INSERT INTO `kit` VALUES (13, '商品试剂2', 'wq121314', '十五圆茶楼', 'http://ssy.yiiweb.cn/backend/kit/create.html?id=3&type=testmethod', 'testmethod', NULL, 1, 1, 'TER1528947706', '', 'uploads/pdf/TER1528947706.pdf', NULL, '2018-06-14 14:30:58', '2018-06-22 17:13:14', NULL, NULL, 3, 3);
INSERT INTO `kit` VALUES (14, '抗体1', '12313123', '市三院', 'https://mail.qq.com/cgi-bin/frame_html?sid=SM7KIW8ZnD8XW0Ea&url=%2Fcgi-bin%2Fmail_list%3Fsid%3DSM7KIW8ZnD8XW0Ea%26topmails%3D0&r=5c3c2b65a88776f8c9f3ba4cf2c793d4', 'pna', NULL, 2, 0, 'TER1529379432', '', 'uploads/pdf/TER1529379432.pdf', NULL, '2018-06-21 15:22:12', '2018-06-24 19:00:17', NULL, NULL, 2, 1);
INSERT INTO `kit` VALUES (15, '检测试剂盒1', 'wqs1213', '市三院', 'https://mail.qq.com/cgi-bin/frame_html?sid=SM7KIW8ZnD8XW0Ea&url=%2Fcgi-bin%2Fmail_list%3Fsid%3DSM7KIW8ZnD8XW0Ea%26topmails%3D0&r=5c3c2b65a88776f8c9f3ba4cf2c793d4', 'pna', NULL, 1, 0, 'TER1529390873', '', 'uploads/pdf/TER1529390873.pdf', NULL, '2018-06-19 06:47:53', '2018-06-22 22:37:00', NULL, NULL, 2, 2);
INSERT INTO `kit` VALUES (16, '商品试剂盒21', 'wa12313', '品试剂盒21', 'file:///C:/Users/Administrator/%E5%9B%BE%E7%89%87%E6%96%87%E6%A1%A3.pdf', 'testmethod', NULL, 1, 1, 'TER1529502041', '', 'uploads/pdf/TER1529502041.pdf', NULL, '2018-06-20 13:40:41', '2018-06-23 22:23:00', NULL, NULL, 3, 3);
INSERT INTO `kit` VALUES (17, '抗体2', '公司名称', '公司名称', 'http://ssy.local.cn/backend/kit/create.html?id=3&type=pna', 'pna', NULL, 3, 0, 'TER1529594532', '', 'uploads/pdf/TER1529594532.jpg', NULL, '2018-06-21 15:22:12', '2018-06-22 17:12:11', NULL, NULL, 3, 1);
INSERT INTO `kit` VALUES (18, '核酸试剂盒2', 'w21213', '公司名称', 'http://ssy.yiiweb.cn/backend/kit/create.html?id=1&type=pna&typeid=2', 'pna', NULL, 1, 0, 'TER1529658662', '', NULL, NULL, '2018-06-22 09:11:02', '2018-06-22 17:11:02', NULL, NULL, 1, 2);
INSERT INTO `kit` VALUES (19, '测试数据', '蛋白指标1', '测试数据', '31', 'pna', NULL, 5, 0, 'ETR1529761340D2', NULL, NULL, NULL, '2018-06-23 13:42:20', '2018-06-24 19:00:37', NULL, NULL, 5, 1);
INSERT INTO `kit` VALUES (20, '测试数据', '蛋白指标1', '测试数据', '31', 'pna', NULL, 5, 0, 'ETR1529761386D2', NULL, NULL, NULL, '2018-06-23 13:43:06', '2018-06-24 19:00:49', NULL, NULL, 5, 1);
INSERT INTO `kit` VALUES (21, '测试数据', '蛋白指标1', '测试数据', '31', 'pna', NULL, 4, 0, 'ETR1529761495D2', NULL, NULL, NULL, '2018-06-23 13:44:55', '2018-06-24 19:00:52', NULL, NULL, 4, 2);
INSERT INTO `kit` VALUES (22, '测试数据', '蛋白指标1', '测试数据', '31', 'testmethod', NULL, 3, 1, 'ETR1529763427D2', NULL, NULL, NULL, '2018-06-23 14:17:07', '2018-06-23 22:22:54', NULL, NULL, 4, 3);
INSERT INTO `kit` VALUES (23, '测试数据', '蛋白指标1', '测试数据', '31', 'testmethod', NULL, 3, 0, 'ETR1529763771D2', NULL, NULL, NULL, '2018-06-23 14:22:51', '2018-06-23 22:22:45', NULL, NULL, 4, 3);
INSERT INTO `kit` VALUES (24, '测试数据', '蛋白指标1', '测试数据', '31', 'testmethod', NULL, 2, 0, 'ETR1529763806D2', NULL, NULL, NULL, '2018-06-23 14:23:26', '2018-06-23 22:23:20', NULL, NULL, 1, 3);
INSERT INTO `kit` VALUES (25, '测试数据', '蛋白指标1', '测试数据', '31', 'pna', NULL, 2, 0, 'ETR1529837957D2', '', 'uploads/pdf/ETR1529837957D2.pdf', NULL, '2018-06-24 10:59:17', '2018-06-24 18:59:30', NULL, NULL, 2, 1);

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration`  (
  `version` varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m140209_132017_init', 1494032883);
INSERT INTO `migration` VALUES ('m140403_174025_create_account_table', 1494032883);
INSERT INTO `migration` VALUES ('m140504_113157_update_tables', 1494032884);
INSERT INTO `migration` VALUES ('m140504_130429_create_token_table', 1494032884);
INSERT INTO `migration` VALUES ('m140506_102106_rbac_init', 1482895903);
INSERT INTO `migration` VALUES ('m140830_171933_fix_ip_field', 1494032884);
INSERT INTO `migration` VALUES ('m140830_172703_change_account_table_name', 1494032884);
INSERT INTO `migration` VALUES ('m141222_110026_update_ip_field', 1494032884);
INSERT INTO `migration` VALUES ('m141222_135246_alter_username_length', 1494032884);
INSERT INTO `migration` VALUES ('m150614_103145_update_social_account_table', 1494032884);
INSERT INTO `migration` VALUES ('m150623_212711_fix_username_notnull', 1494032884);
INSERT INTO `migration` VALUES ('m151218_234654_add_timezone_to_profile', 1494032884);
INSERT INTO `migration` VALUES ('m160929_103127_add_last_login_at_to_user_table', 1494032884);

-- ----------------------------
-- Table structure for nucleicacid
-- ----------------------------
DROP TABLE IF EXISTS `nucleicacid`;
CREATE TABLE `nucleicacid`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `retrieve` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '检测指标检索号',
  `section_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '切片名称',
  `section_type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '切片类型',
  `section_thickness` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '切片厚度',
  `section_preprocessing` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '切片预处理',
  `testflow` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '实验流程',
  `img` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '图片路径',
  `place` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '存放位置',
  `add_user` int(11) DEFAULT NULL,
  `add_time` datetime(0) DEFAULT NULL,
  `change_user` int(11) DEFAULT NULL,
  `change_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `isdel` int(11) DEFAULT NULL,
  `del_time` datetime(0) DEFAULT NULL,
  `del_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for operatelog
-- ----------------------------
DROP TABLE IF EXISTS `operatelog`;
CREATE TABLE `operatelog`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `operate` tinyint(1) NOT NULL COMMENT '操作',
  `object` int(11) NOT NULL COMMENT '对象',
  `user` int(11) NOT NULL COMMENT '操作人',
  `objectname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '对象名称',
  `operate_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '操作时间',
  `operate_kind` varchar(24) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '对象类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 217 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of operatelog
-- ----------------------------
INSERT INTO `operatelog` VALUES (1, 1, 8, 1, '分组1', '2018-06-02 10:00:32', '2');
INSERT INTO `operatelog` VALUES (2, 1, 9, 1, '分组2', '2018-06-02 11:47:04', '2');
INSERT INTO `operatelog` VALUES (3, 4, 9, 1, '分组2', '2018-06-02 11:48:08', '2');
INSERT INTO `operatelog` VALUES (4, 4, 8, 1, '分组1', '2018-06-02 11:48:27', '2');
INSERT INTO `operatelog` VALUES (5, 3, 8, 1, '分组11', '2018-06-02 14:40:50', '2');
INSERT INTO `operatelog` VALUES (6, 3, 8, 1, '分组1', '2018-06-02 14:41:07', '2');
INSERT INTO `operatelog` VALUES (7, 1, 1, 1, '样本1', '2018-06-04 15:03:43', '4');
INSERT INTO `operatelog` VALUES (8, 3, 1, 1, '样本2', '2018-06-04 17:12:09', 'sample');
INSERT INTO `operatelog` VALUES (9, 1, 1, 1, '样本组织1', '2018-06-05 15:10:05', 'stace');
INSERT INTO `operatelog` VALUES (10, 3, 1, 1, '样本组织11', '2018-06-05 15:38:00', 'stace');
INSERT INTO `operatelog` VALUES (11, 3, 1, 1, '样本组织11', '2018-06-05 15:38:14', 'stace');
INSERT INTO `operatelog` VALUES (12, 4, 1, 1, '样本组织11', '2018-06-05 15:39:23', 'stace');
INSERT INTO `operatelog` VALUES (13, 4, 1, 1, '样本2', '2018-06-05 15:42:13', 'sample');
INSERT INTO `operatelog` VALUES (14, 1, 2, 1, '样本1', '2018-06-05 15:43:28', 'sample');
INSERT INTO `operatelog` VALUES (15, 1, 2, 1, '样本细胞1', '2018-06-05 15:43:56', 'stace');
INSERT INTO `operatelog` VALUES (16, 1, 5, 1, '常规染色指标1', '2018-06-13 11:14:08', 'routine');
INSERT INTO `operatelog` VALUES (18, 1, 1, 1, '试剂1', '2018-06-12 14:58:58', 'reagent');
INSERT INTO `operatelog` VALUES (19, 1, 2, 1, '试剂2', '2018-06-12 14:59:55', 'reagent');
INSERT INTO `operatelog` VALUES (20, 3, 1, 1, '试剂3', '2018-06-12 15:11:02', 'reagent');
INSERT INTO `operatelog` VALUES (22, 3, 1, 1, '试剂1', '2018-06-12 15:15:45', 'reagent');
INSERT INTO `operatelog` VALUES (23, 4, 1, 1, '试剂1', '2018-06-12 15:21:20', 'reagent');
INSERT INTO `operatelog` VALUES (24, 3, 3, 1, '市三院1', '2018-06-13 11:07:57', 'company');
INSERT INTO `operatelog` VALUES (25, 1, 5, 1, '市三院2', '2018-06-13 11:08:32', 'company');
INSERT INTO `operatelog` VALUES (26, 4, 5, 1, '市三院2', '2018-06-13 11:09:07', 'company');
INSERT INTO `operatelog` VALUES (27, 1, 6, 1, '检测指标2', '2018-06-13 11:11:36', 'routine');
INSERT INTO `operatelog` VALUES (28, 1, 3, 1, '试剂2', '2018-06-13 11:15:18', 'reagent');
INSERT INTO `operatelog` VALUES (29, 3, 2, 1, '试剂1', '2018-06-13 11:16:27', 'reagent');
INSERT INTO `operatelog` VALUES (30, 1, 1, 1, '检测指标3', '2018-06-13 14:18:22', 'particular');
INSERT INTO `operatelog` VALUES (31, 1, 2, 1, '检测指标4', '2018-06-13 14:19:49', 'particular');
INSERT INTO `operatelog` VALUES (32, 3, 2, 1, '检测指标5', '2018-06-13 14:21:34', 'particular');
INSERT INTO `operatelog` VALUES (33, 3, 1, 1, '检测指标4', '2018-06-13 15:21:07', 'particular');
INSERT INTO `operatelog` VALUES (36, 1, 1, 1, '检测方法1', '2018-06-13 15:42:20', 'testmethod');
INSERT INTO `operatelog` VALUES (37, 3, 1, 1, '检测方法2', '2018-06-13 15:51:04', 'testmethod');
INSERT INTO `operatelog` VALUES (38, 1, 2, 1, '检测方法1', '2018-06-13 15:51:27', 'testmethod');
INSERT INTO `operatelog` VALUES (39, 4, 2, 1, '检测方法1', '2018-06-13 15:52:14', 'testmethod');
INSERT INTO `operatelog` VALUES (40, 1, 4, 1, '测试试剂3', '2018-06-13 17:14:02', 'reagent');
INSERT INTO `operatelog` VALUES (41, 3, 4, 1, '测试试剂1', '2018-06-13 17:16:58', 'reagent');
INSERT INTO `operatelog` VALUES (42, 3, 2, 1, '试剂4', '2018-06-13 17:17:51', 'reagent');
INSERT INTO `operatelog` VALUES (43, 1, 5, 1, '自配试剂1', '2018-06-13 17:19:24', 'reagent');
INSERT INTO `operatelog` VALUES (44, 1, 6, 1, '检测试剂11', '2018-06-13 17:29:39', 'reagent');
INSERT INTO `operatelog` VALUES (45, 1, 6, 1, '德州', '2018-06-13 17:30:22', 'company');
INSERT INTO `operatelog` VALUES (46, 1, 3, 1, '检测方法2', '2018-06-13 21:32:15', 'testmethod');
INSERT INTO `operatelog` VALUES (47, 1, 7, 1, '检测试剂13', '2018-06-13 21:42:28', 'reagent');
INSERT INTO `operatelog` VALUES (48, 1, 7, 1, '市五院', '2018-06-13 21:49:42', 'company');
INSERT INTO `operatelog` VALUES (49, 1, 9, 1, '市三院', '2018-06-14 11:01:16', 'company');
INSERT INTO `operatelog` VALUES (50, 1, 10, 1, '市三院', '2018-06-14 11:04:22', 'company');
INSERT INTO `operatelog` VALUES (51, 1, 11, 1, '市三院', '2018-06-14 11:06:29', 'company');
INSERT INTO `operatelog` VALUES (52, 1, 12, 1, '市三院', '2018-06-14 14:29:29', 'kit');
INSERT INTO `operatelog` VALUES (53, 1, 13, 1, '商品试剂2', '2018-06-14 11:41:29', 'kit');
INSERT INTO `operatelog` VALUES (54, 3, 13, 1, '十五圆茶楼', '2018-06-14 14:28:55', 'kit');
INSERT INTO `operatelog` VALUES (55, 3, 13, 1, '十五圆茶楼', '2018-06-14 14:28:52', 'kit');
INSERT INTO `operatelog` VALUES (56, 3, 13, 1, '十五圆茶楼', '2018-06-14 14:28:49', 'kit');
INSERT INTO `operatelog` VALUES (57, 4, 13, 1, '十五圆茶楼', '2018-06-14 14:15:17', 'kit');
INSERT INTO `operatelog` VALUES (58, 4, 5, 1, '自配试剂1', '2018-06-14 15:33:03', 'reagent');
INSERT INTO `operatelog` VALUES (59, 1, 1, 1, '核酸指标1', '2018-06-15 11:13:37', 'pna');
INSERT INTO `operatelog` VALUES (60, 1, 2, 1, '蛋白指标1', '2018-06-15 11:14:21', 'pna');
INSERT INTO `operatelog` VALUES (61, 3, 2, 1, '蛋白指标2', '2018-06-15 11:24:44', 'pna');
INSERT INTO `operatelog` VALUES (62, 3, 2, 1, '蛋白指标1', '2018-06-15 11:25:19', 'pna');
INSERT INTO `operatelog` VALUES (63, 3, 2, 1, '蛋白指标1', '2018-06-15 11:25:42', 'pna');
INSERT INTO `operatelog` VALUES (64, 1, 14, 1, '抗体1', '2018-06-19 11:36:56', 'kit');
INSERT INTO `operatelog` VALUES (65, 1, 15, 1, '检测试剂盒1', '2018-06-19 14:47:36', 'kit');
INSERT INTO `operatelog` VALUES (66, 1, 3, 1, '测试样品', '2018-06-19 15:26:06', 'sample');
INSERT INTO `operatelog` VALUES (67, 1, 3, 1, '组织细胞1', '2018-06-19 15:26:32', 'stace');
INSERT INTO `operatelog` VALUES (68, 1, 2, 1, '1231', '2018-06-20 11:36:39', 'sdyeing');
INSERT INTO `operatelog` VALUES (69, 1, 3, 1, '123', '2018-06-20 11:39:35', 'sdyeing');
INSERT INTO `operatelog` VALUES (70, 1, 4, 1, '123123', '2018-06-20 11:43:56', 'sdyeing');
INSERT INTO `operatelog` VALUES (71, 1, 5, 1, '实验结果1', '2018-06-20 16:20:05', 'sdyeing');
INSERT INTO `operatelog` VALUES (72, 1, 8, 1, '检测试剂23', '2018-06-20 21:27:11', 'reagent');
INSERT INTO `operatelog` VALUES (73, 1, 9, 1, '检测试剂21', '2018-06-20 21:29:31', 'reagent');
INSERT INTO `operatelog` VALUES (74, 3, 8, 1, '检测试剂22', '2018-06-20 21:32:12', 'reagent');
INSERT INTO `operatelog` VALUES (75, 1, 16, 1, '商品试剂盒21', '2018-06-20 21:40:38', 'kit');
INSERT INTO `operatelog` VALUES (76, 1, 6, 1, '特殊染色切片1', '2018-06-20 22:13:44', 'sdyeing');
INSERT INTO `operatelog` VALUES (77, 1, 7, 1, '特殊染色切片2', '2018-06-20 22:18:06', 'sdyeing');
INSERT INTO `operatelog` VALUES (78, 1, 8, 1, '核酸切片', '2018-06-21 10:19:26', 'sdyeing');
INSERT INTO `operatelog` VALUES (79, 1, 10, 1, '常规染色试剂1', '2018-06-21 13:35:07', 'reagent');
INSERT INTO `operatelog` VALUES (80, 1, 11, 1, '特殊染色试剂1', '2018-06-21 13:35:36', 'reagent');
INSERT INTO `operatelog` VALUES (81, 1, 8, 1, '十特殊染色1', '2018-06-21 13:36:12', 'company');
INSERT INTO `operatelog` VALUES (82, 1, 9, 1, '是安远', '2018-06-21 13:51:58', 'company');
INSERT INTO `operatelog` VALUES (83, 1, 9, 1, '常规染色实验结果2', '2018-06-21 14:24:20', 'sdyeing');
INSERT INTO `operatelog` VALUES (84, 1, 10, 1, '特殊染色切片2', '2018-06-21 14:34:24', 'sdyeing');
INSERT INTO `operatelog` VALUES (85, 1, 11, 1, '蛋白切片1', '2018-06-21 15:10:57', 'sdyeing');
INSERT INTO `operatelog` VALUES (86, 4, 7, 1, '特殊染色切片2', '2018-06-21 15:33:41', 'sdyeing');
INSERT INTO `operatelog` VALUES (87, 3, 5, 1, '实验结果1', '2018-06-21 15:55:56', 'sdyeing');
INSERT INTO `operatelog` VALUES (88, 3, 5, 1, '常规染色切片1', '2018-06-21 15:56:21', 'sdyeing');
INSERT INTO `operatelog` VALUES (89, 3, 6, 1, '特殊染色切片1', '2018-06-21 16:26:09', 'sdyeing');
INSERT INTO `operatelog` VALUES (90, 3, 6, 1, '特殊染色切片1', '2018-06-21 16:27:18', 'sdyeing');
INSERT INTO `operatelog` VALUES (91, 3, 6, 1, '特殊染色切片1', '2018-06-21 16:32:12', 'sdyeing');
INSERT INTO `operatelog` VALUES (92, 3, 6, 1, '特殊染色切片1', '2018-06-21 17:02:28', 'sdyeing');
INSERT INTO `operatelog` VALUES (93, 3, 6, 1, '特殊染色切片1', '2018-06-21 17:08:17', 'sdyeing');
INSERT INTO `operatelog` VALUES (94, 3, 6, 1, '特殊染色切片1', '2018-06-21 17:14:54', 'sdyeing');
INSERT INTO `operatelog` VALUES (95, 3, 6, 1, '特殊染色切片1', '2018-06-21 17:22:16', 'sdyeing');
INSERT INTO `operatelog` VALUES (96, 3, 6, 1, '特殊染色切片1', '2018-06-21 17:25:40', 'sdyeing');
INSERT INTO `operatelog` VALUES (97, 3, 6, 1, '特殊染色切片1', '2018-06-21 17:26:33', 'sdyeing');
INSERT INTO `operatelog` VALUES (98, 3, 6, 1, '特殊染色切片1', '2018-06-21 17:26:49', 'sdyeing');
INSERT INTO `operatelog` VALUES (99, 3, 6, 1, '特殊染色切片1', '2018-06-21 17:26:58', 'sdyeing');
INSERT INTO `operatelog` VALUES (100, 3, 6, 1, '特殊染色切片1', '2018-06-21 17:27:43', 'sdyeing');
INSERT INTO `operatelog` VALUES (101, 3, 6, 1, '特殊染色切片1', '2018-06-21 17:31:28', 'sdyeing');
INSERT INTO `operatelog` VALUES (102, 3, 6, 1, '特殊染色切片1', '2018-06-21 17:43:12', 'sdyeing');
INSERT INTO `operatelog` VALUES (103, 3, 6, 1, '特殊染色切片1', '2018-06-21 17:43:25', 'sdyeing');
INSERT INTO `operatelog` VALUES (104, 3, 6, 1, '特殊染色切片1', '2018-06-21 17:43:34', 'sdyeing');
INSERT INTO `operatelog` VALUES (105, 3, 5, 1, '常规染色切片1', '2018-06-21 23:03:05', 'sdyeing');
INSERT INTO `operatelog` VALUES (106, 3, 5, 1, '常规染色切片1', '2018-06-21 23:06:45', 'sdyeing');
INSERT INTO `operatelog` VALUES (107, 3, 5, 1, '常规染色切片1', '2018-06-21 23:10:07', 'sdyeing');
INSERT INTO `operatelog` VALUES (108, 3, 5, 1, '常规染色切片1', '2018-06-21 23:11:31', 'sdyeing');
INSERT INTO `operatelog` VALUES (109, 3, 5, 1, '常规染色切片1', '2018-06-21 23:11:53', 'sdyeing');
INSERT INTO `operatelog` VALUES (110, 1, 3, 1, '蛋白指标2', '2018-06-21 23:20:02', 'pna');
INSERT INTO `operatelog` VALUES (111, 1, 17, 1, '抗体1', '2018-06-21 23:22:07', 'kit');
INSERT INTO `operatelog` VALUES (112, 3, 17, 1, '公司名称', '2018-06-21 23:32:03', 'kit');
INSERT INTO `operatelog` VALUES (113, 3, 11, 1, '蛋白切片1', '2018-06-21 23:37:29', 'sdyeing');
INSERT INTO `operatelog` VALUES (114, 1, 10, 1, '分组3', '2018-06-22 11:21:33', 'group');
INSERT INTO `operatelog` VALUES (115, 3, 10, 1, '分组3', '2018-06-22 11:21:54', 'group');
INSERT INTO `operatelog` VALUES (116, 3, 1, 1, '样本2', '2018-06-22 14:25:03', 'sample');
INSERT INTO `operatelog` VALUES (117, 3, 2, 1, '样本2', '2018-06-22 14:32:29', 'sample');
INSERT INTO `operatelog` VALUES (118, 3, 1, 1, '样本2', '2018-06-22 14:35:30', 'sample');
INSERT INTO `operatelog` VALUES (119, 3, 1, 1, '样本2', '2018-06-22 14:36:12', 'sample');
INSERT INTO `operatelog` VALUES (120, 3, 1, 1, '样本2', '2018-06-22 14:37:00', 'sample');
INSERT INTO `operatelog` VALUES (121, 3, 1, 1, '样本3', '2018-06-22 14:42:58', 'sample');
INSERT INTO `operatelog` VALUES (122, 3, 8, 1, '分组11', '2018-06-22 14:44:28', 'group');
INSERT INTO `operatelog` VALUES (123, 3, 8, 1, '分组111', '2018-06-22 14:46:52', 'group');
INSERT INTO `operatelog` VALUES (124, 3, 8, 1, '分组1', '2018-06-22 14:47:10', 'group');
INSERT INTO `operatelog` VALUES (125, 3, 1, 1, '样本4', '2018-06-22 14:47:31', 'sample');
INSERT INTO `operatelog` VALUES (126, 3, 1, 1, '样本组织11', '2018-06-22 15:00:43', 'stace');
INSERT INTO `operatelog` VALUES (127, 1, 12, 1, '常规染色切片4', '2018-06-22 16:56:11', 'sdyeing');
INSERT INTO `operatelog` VALUES (128, 1, 13, 1, '特殊染色切片2', '2018-06-22 16:57:01', 'sdyeing');
INSERT INTO `operatelog` VALUES (129, 1, 14, 1, '蛋白切片2', '2018-06-22 16:57:42', 'sdyeing');
INSERT INTO `operatelog` VALUES (130, 1, 18, 1, '核酸试剂盒2', '2018-06-22 17:11:02', 'kit');
INSERT INTO `operatelog` VALUES (131, 1, 24, 1, '实验项目3的子项目', '2018-06-23 11:51:41', 'project');
INSERT INTO `operatelog` VALUES (132, 3, 24, 1, '实验项目3的子项目', '2018-06-23 11:52:33', 'project');
INSERT INTO `operatelog` VALUES (133, 1, 25, 1, '实验项目3的子项目', '2018-06-23 11:53:37', 'project');
INSERT INTO `operatelog` VALUES (134, 1, 26, 1, '实验项目3的子项目', '2018-06-23 14:07:45', 'project');
INSERT INTO `operatelog` VALUES (135, 1, 27, 1, '实验项目3的子项目', '2018-06-23 14:13:16', 'project');
INSERT INTO `operatelog` VALUES (136, 4, 27, 1, '实验项目3的子项目', '2018-06-23 14:13:32', 'project');
INSERT INTO `operatelog` VALUES (137, 4, 26, 1, '实验项目3的子项目', '2018-06-23 14:14:48', 'project');
INSERT INTO `operatelog` VALUES (138, 4, 24, 1, '实验项目3的子项目', '2018-06-23 14:15:00', 'project');
INSERT INTO `operatelog` VALUES (139, 1, 11, 1, '导入分组1', '2018-06-23 15:54:36', 'group');
INSERT INTO `operatelog` VALUES (140, 1, 4, 1, '导入样本', '2018-06-23 16:22:10', 'sample');
INSERT INTO `operatelog` VALUES (141, 1, 5, 1, '导入样本', '2018-06-23 16:22:44', 'sample');
INSERT INTO `operatelog` VALUES (142, 4, 5, 1, '导入样本', '2018-06-23 16:22:49', 'sample');
INSERT INTO `operatelog` VALUES (143, 1, 4, 1, '导入标本', '2018-06-23 16:32:54', 'stace');
INSERT INTO `operatelog` VALUES (144, 1, 5, 1, '导入实验结果', '2018-06-23 16:50:50', 'stace');
INSERT INTO `operatelog` VALUES (145, 4, 5, 1, '导入实验结果', '2018-06-23 16:51:40', 'stace');
INSERT INTO `operatelog` VALUES (146, 1, 6, 1, '导入实验结果', '2018-06-23 16:51:48', 'stace');
INSERT INTO `operatelog` VALUES (147, 4, 6, 1, '导入实验结果', '2018-06-23 16:51:55', 'stace');
INSERT INTO `operatelog` VALUES (148, 1, 16, 1, '导入实验结果', '2018-06-23 17:06:14', 'sdyeing');
INSERT INTO `operatelog` VALUES (149, 1, 7, 1, '导入常规染色指标', '2018-06-23 20:18:50', 'routine');
INSERT INTO `operatelog` VALUES (150, 1, 3, 1, '导入特殊染色指标', '2018-06-23 20:27:38', 'particular');
INSERT INTO `operatelog` VALUES (151, 1, 4, 1, '导入检测方法', '2018-06-23 20:40:55', 'testmethod');
INSERT INTO `operatelog` VALUES (152, 1, 4, 1, '导入蛋白核算指标', '2018-06-23 21:03:53', 'pna');
INSERT INTO `operatelog` VALUES (153, 1, 5, 1, '导入蛋白核算指标', '2018-06-23 21:04:19', 'pna');
INSERT INTO `operatelog` VALUES (154, 1, 19, 1, '测试数据', '2018-06-23 21:45:36', 'kit');
INSERT INTO `operatelog` VALUES (155, 1, 20, 1, '测试数据', '2018-06-23 21:45:39', 'kit');
INSERT INTO `operatelog` VALUES (156, 1, 21, 1, '测试数据', '2018-06-23 21:45:43', 'kit');
INSERT INTO `operatelog` VALUES (157, 1, 12, 1, '检测指标测试', '2018-06-23 22:01:47', 'reagent');
INSERT INTO `operatelog` VALUES (160, 1, 15, 1, '测试数据1', '2018-06-23 22:04:20', 'reagent');
INSERT INTO `operatelog` VALUES (161, 1, 16, 1, '测试数据2', '2018-06-23 22:04:20', 'reagent');
INSERT INTO `operatelog` VALUES (164, 1, 19, 1, '测试数据1', '2018-06-23 22:08:44', 'reagent');
INSERT INTO `operatelog` VALUES (165, 1, 20, 1, '测试数据2', '2018-06-23 22:08:44', 'reagent');
INSERT INTO `operatelog` VALUES (166, 1, 21, 1, '测试数据1', '2018-06-23 22:11:03', 'reagent');
INSERT INTO `operatelog` VALUES (167, 1, 22, 1, '测试数据2', '2018-06-23 22:11:03', 'reagent');
INSERT INTO `operatelog` VALUES (168, 1, 22, 1, '测试数据', '2018-06-23 22:17:01', 'kit');
INSERT INTO `operatelog` VALUES (169, 4, 19, 1, '测试数据1', '2018-06-23 22:17:33', 'reagent');
INSERT INTO `operatelog` VALUES (170, 4, 20, 1, '测试数据2', '2018-06-23 22:18:11', 'reagent');
INSERT INTO `operatelog` VALUES (171, 1, 23, 1, '测试数据', '2018-06-23 22:22:45', 'kit');
INSERT INTO `operatelog` VALUES (172, 4, 22, 1, '测试数据', '2018-06-23 22:22:54', 'kit');
INSERT INTO `operatelog` VALUES (173, 4, 16, 1, '品试剂盒21', '2018-06-23 22:23:00', 'kit');
INSERT INTO `operatelog` VALUES (174, 1, 24, 1, '测试数据', '2018-06-23 22:23:20', 'kit');
INSERT INTO `operatelog` VALUES (175, 1, 23, 1, '测试数据1', '2018-06-23 22:23:45', 'reagent');
INSERT INTO `operatelog` VALUES (176, 1, 24, 1, '测试数据2', '2018-06-23 22:23:45', 'reagent');
INSERT INTO `operatelog` VALUES (177, 1, 25, 1, '测试数据1', '2018-06-23 22:24:09', 'reagent');
INSERT INTO `operatelog` VALUES (178, 1, 26, 1, '测试数据2', '2018-06-23 22:24:09', 'reagent');
INSERT INTO `operatelog` VALUES (179, 1, 10, 1, '测试数据1', '2018-06-23 22:40:27', 'company');
INSERT INTO `operatelog` VALUES (180, 1, 11, 1, '测试数据2', '2018-06-23 22:40:27', 'company');
INSERT INTO `operatelog` VALUES (181, 1, 12, 1, '测试数据1', '2018-06-23 22:42:32', 'company');
INSERT INTO `operatelog` VALUES (182, 1, 13, 1, '测试数据2', '2018-06-23 22:42:32', 'company');
INSERT INTO `operatelog` VALUES (183, 3, 1, 1, '检测方法21', '2018-06-23 22:58:15', 'testmethod');
INSERT INTO `operatelog` VALUES (184, 3, 14, 1, '实验项目2', '2018-06-24 09:13:59', 'project');
INSERT INTO `operatelog` VALUES (185, 3, 15, 1, '实验项目1', '2018-06-24 09:15:31', 'project');
INSERT INTO `operatelog` VALUES (186, 3, 23, 1, '实验项目3', '2018-06-24 09:15:58', 'project');
INSERT INTO `operatelog` VALUES (187, 3, 10, 1, '分组3', '2018-06-24 10:34:23', 'group');
INSERT INTO `operatelog` VALUES (188, 3, 18, 1, '项目2的子项目2', '2018-06-24 10:34:42', 'project');
INSERT INTO `operatelog` VALUES (189, 3, 8, 1, '分组1', '2018-06-24 11:08:41', 'group');
INSERT INTO `operatelog` VALUES (190, 3, 17, 1, '项目2的子项目1', '2018-06-24 11:09:21', 'project');
INSERT INTO `operatelog` VALUES (191, 3, 14, 1, '市三院', '2018-06-24 18:56:52', 'kit');
INSERT INTO `operatelog` VALUES (192, 1, 25, 1, '测试数据', '2018-06-24 18:59:17', 'kit');
INSERT INTO `operatelog` VALUES (193, 3, 25, 1, '测试数据', '2018-06-24 18:59:30', 'kit');
INSERT INTO `operatelog` VALUES (194, 3, 5, 1, '常规染色切片1', '2018-06-24 19:02:19', 'sdyeing');
INSERT INTO `operatelog` VALUES (195, 4, 4, 1, '导入样本', '2018-06-28 15:10:45', 'sample');
INSERT INTO `operatelog` VALUES (196, 1, 6, 1, '导入样本', '2018-06-28 15:14:32', 'sample');
INSERT INTO `operatelog` VALUES (197, 4, 6, 1, '导入样本', '2018-06-28 15:18:15', 'sample');
INSERT INTO `operatelog` VALUES (198, 1, 7, 1, '导入样本', '2018-06-28 15:18:30', 'sample');
INSERT INTO `operatelog` VALUES (199, 3, 5, 1, '常规染色指标121', '2018-07-06 16:53:19', 'routine');
INSERT INTO `operatelog` VALUES (200, 3, 14, 1, '实验项目22', '2018-07-06 16:53:44', 'project');
INSERT INTO `operatelog` VALUES (201, 3, 14, 1, '实验项目221', '2018-07-06 16:56:15', 'project');
INSERT INTO `operatelog` VALUES (202, 1, 12, 1, '测试分组', '2018-07-17 10:46:18', 'group');
INSERT INTO `operatelog` VALUES (203, 1, 27, 1, '12', '2018-07-17 18:32:35', 'reagent');
INSERT INTO `operatelog` VALUES (204, 3, 5, 1, '常规染色切片1', '2018-07-18 11:30:28', 'sdyeing');
INSERT INTO `operatelog` VALUES (205, 3, 5, 1, '常规染色切片1', '2018-07-18 11:31:17', 'sdyeing');
INSERT INTO `operatelog` VALUES (206, 4, 15, 1, '测试数据1', '2018-07-23 11:43:52', 'reagent');
INSERT INTO `operatelog` VALUES (207, 4, 6, 1, '检测指标2', '2018-11-16 10:51:17', 'routine');
INSERT INTO `operatelog` VALUES (208, 4, 5, 1, '常规染色指标121', '2018-11-16 10:51:23', 'routine');
INSERT INTO `operatelog` VALUES (209, 3, 7, 1, 'H&E染色', '2018-11-16 10:52:27', 'routine');
INSERT INTO `operatelog` VALUES (210, 4, 3, 1, '导入特殊染色指标', '2018-11-16 11:01:19', 'particular');
INSERT INTO `operatelog` VALUES (211, 4, 2, 1, '检测指标5', '2018-11-16 11:01:22', 'particular');
INSERT INTO `operatelog` VALUES (212, 3, 1, 1, '脂肪', '2018-11-16 11:01:40', 'particular');
INSERT INTO `operatelog` VALUES (213, 3, 3, 1, '油红O染色', '2018-11-16 11:02:09', 'testmethod');
INSERT INTO `operatelog` VALUES (214, 3, 3, 1, '油红O染色', '2018-11-16 11:04:36', 'testmethod');
INSERT INTO `operatelog` VALUES (215, 4, 11, 1, '特殊染色试剂1', '2018-11-16 11:05:43', 'reagent');
INSERT INTO `operatelog` VALUES (216, 3, 7, 1, 'H&E染色1', '2018-11-20 15:39:11', 'routine');

-- ----------------------------
-- Table structure for page
-- ----------------------------
DROP TABLE IF EXISTS `page`;
CREATE TABLE `page`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `keyword` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `template` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模板路径',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of page
-- ----------------------------
INSERT INTO `page` VALUES (1, '关于我们', '', '关于我们', '关于我们', 'page', '<p><iframe class=\"ueditor_baidumap\" src=\"http://dev.qy.com/assets/7a0b751e/dialogs/map/show.html#center=116.404,39.915&zoom=10&width=530&height=340&markers=116.404,39.915&markerStyles=l,A\" frameborder=\"0\" width=\"534\" height=\"344\"></iframe></p>', 1483165325, 1483170261);

-- ----------------------------
-- Table structure for particular
-- ----------------------------
DROP TABLE IF EXISTS `particular`;
CREATE TABLE `particular`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `retrieve` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '编号',
  `change_user` int(11) DEFAULT NULL COMMENT '修改人',
  `add_time` datetime(0) DEFAULT NULL COMMENT '添加时间',
  `del_time` datetime(0) DEFAULT NULL COMMENT '删除时间',
  `change_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '修改时间',
  `isdel` tinyint(1) DEFAULT 0 COMMENT '是否删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of particular
-- ----------------------------
INSERT INTO `particular` VALUES (1, '脂肪', 'ETS1528870458', NULL, '2018-06-13 06:18:38', NULL, '2018-11-16 11:01:40', 0);
INSERT INTO `particular` VALUES (2, '检测指标5', 'ETS1528870797', NULL, '2018-06-13 06:20:06', NULL, '2018-11-16 11:01:22', 1);
INSERT INTO `particular` VALUES (3, '导入特殊染色指标', 'ETS1529756768D2', NULL, '2018-06-23 12:26:08', NULL, '2018-11-16 11:01:19', 1);

-- ----------------------------
-- Table structure for pna
-- ----------------------------
DROP TABLE IF EXISTS `pna`;
CREATE TABLE `pna`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `retrieve` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '检索号',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '检测指标名称',
  `OfficialSymbol` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '官方符号',
  `OfficialFullName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '官方名称',
  `GeneID` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '基因ID',
  `function` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '功能',
  `NCBIgd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'NCBI基因数据库\n网址',
  `GeneGards` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'GeneGards网址',
  `standard` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '阳性结果判定标准',
  `cells` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '阳性对照组织/细胞',
  `isdel` tinyint(1) DEFAULT 0,
  `add_time` datetime(0) DEFAULT NULL,
  `del_time` datetime(0) DEFAULT NULL,
  `change_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `change_user` int(11) DEFAULT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1 蛋白  2  核酸',
  PRIMARY KEY (`id`, `name`, `retrieve`, `GeneID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pna
-- ----------------------------
INSERT INTO `pna` VALUES (1, 'ETN1529032434', '核酸指标1', '1728931646', '核酸指标1', '2313', '基因/核酸功能', 'https://baike.baidu.com/item/DAO/2900358?fr=aladdin', 'https://baike.baidu.com/item/DAO/2900358?fr=aladdin', '阳性结果判定标准', '阳性对照组织/细胞', 0, '2018-06-15 03:13:54', NULL, '2018-06-15 11:13:37', NULL, 2);
INSERT INTO `pna` VALUES (2, 'ETP1529032478', '蛋白指标1', '1231441', '蛋白指标1', '31', '基因/核酸功能', 'http://www.yiichina.com/news/141', 'http://www.yiichina.com/news/141', '阳性结果判定标准', '阳性结果判定标准', 0, '2018-06-15 03:14:38', NULL, '2018-06-15 11:25:19', NULL, 1);
INSERT INTO `pna` VALUES (3, 'ETP1529594406', '蛋白指标2', '21313', '官方名称', '123123', '基因/核酸功能', 'https://cn.bing.com/search?q=%e5%a6%82%e4%bd%95%e5%9c%a8+windows+10+%e4%b8%', 'https://cn.bing.com/search?q=%e5%a6%82%e4%bd%95%e5%9c%a8+windo', '阳性结果判定标准', '阳性对照组织/细胞', 0, '2018-06-21 15:20:06', NULL, '2018-06-21 23:20:02', NULL, 1);
INSERT INTO `pna` VALUES (4, 'ETN1529759039D2', '导入蛋白核算指标', '1231441', '蛋白指标1', '31', '基因/核酸功能', 'http://www.yiichina.com/news/141', 'http://www.yiichina.com/news/141', '阳性结果判定标准', '阳性结果判定标准', 0, '2018-06-23 13:03:59', NULL, '2018-06-23 21:03:53', NULL, 2);
INSERT INTO `pna` VALUES (5, 'ETP1529759065D2', '导入蛋白核算指标', '1231441', '蛋白指标1', '31', '基因/核酸功能', 'http://www.yiichina.com/news/141', 'http://www.yiichina.com/news/141', '阳性结果判定标准', '阳性结果判定标准', 0, '2018-06-23 13:04:25', NULL, '2018-06-23 21:04:19', NULL, 1);

-- ----------------------------
-- Table structure for principal
-- ----------------------------
DROP TABLE IF EXISTS `principal`;
CREATE TABLE `principal`  (
  `pro_id` int(11) NOT NULL COMMENT '项目id',
  `name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `department` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '科室',
  `email` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '邮箱',
  `telphone` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '电话',
  `status` tinyint(1) DEFAULT 0 COMMENT '状态',
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of principal
-- ----------------------------
INSERT INTO `principal` VALUES (8, '小猪佩琪', '儿科', 'peiqi@qq.com', '152564748485', 0, 1);
INSERT INTO `principal` VALUES (14, '小猪乔治', '骨科', 'qiaozhi@qq.com', '15264858641', 0, 2);
INSERT INTO `principal` VALUES (15, '小猪佩奇1', '儿科', 'xiaozhu@qq.com', '15264525365', 0, 3);
INSERT INTO `principal` VALUES (16, '小猪佩琪', '儿科', 'peiqi@qq.com', '15264525365', 0, 4);
INSERT INTO `principal` VALUES (17, '乔治', '儿科', 'qiaozhi@qq.com', '16354789654', 0, 5);
INSERT INTO `principal` VALUES (15, '小猪佩琪2号', '血液科', 'peiqi2@qq.com', '17654234567', 0, 6);
INSERT INTO `principal` VALUES (18, '乔治', '儿科', 'qiaozhi@qq.com', '16587589526', 0, 7);
INSERT INTO `principal` VALUES (23, '乔治', '儿科', 'qiaozhi@qq.com', '16354789654', 0, 8);
INSERT INTO `principal` VALUES (24, '乔治1', '儿科1', 'qiaozhi@qq.com', '16354789654', 0, 9);
INSERT INTO `principal` VALUES (25, '乔治1', '儿科1', 'qiaozhi@qq.com', '16354789654', 0, 10);
INSERT INTO `principal` VALUES (26, '乔治1', '儿科1', 'qiaozhi@qq.com', '16354789654', 0, 11);
INSERT INTO `principal` VALUES (27, '乔治1', '儿科1', 'qiaozhi@qq.com', '16354789654', 0, 12);

-- ----------------------------
-- Table structure for project
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project`  (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '实验项目id',
  `pro_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '实验项目名称',
  `pro_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '实验项目描述',
  `pro_keywords` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '实验项目关键词',
  `pro_kind_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '实验项目种属id',
  `pro_sample_count` int(11) DEFAULT NULL COMMENT '实验样本总数 ',
  `pro_add_time` datetime(0) NOT NULL COMMENT '项目录入时间',
  `pro_update_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '项目更新时间',
  `pro_pid` int(11) NOT NULL DEFAULT 0 COMMENT '项目父级id',
  `pro_retrieve` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '项目检索号',
  `isdel` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否被删除 1删除  0未被删除',
  `pro_user` int(11) DEFAULT NULL COMMENT '项目添加人',
  `pro_change_user` int(11) DEFAULT NULL COMMENT '项目修改人',
  `pro_del_time` datetime(0) DEFAULT NULL COMMENT '项目删除时间',
  `pro_del_user` int(11) DEFAULT NULL COMMENT '项目删除人',
  `level` int(11) DEFAULT NULL COMMENT '等级',
  PRIMARY KEY (`pro_id`) USING BTREE,
  INDEX `search`(`pro_name`, `pro_retrieve`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of project
-- ----------------------------
INSERT INTO `project` VALUES (14, '实验项目221', '这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目这是小猪乔治的项目', '项目2', '组织', 2, '2018-05-23 08:30:20', '2018-07-06 16:56:15', 0, 'PDS20180523083020', 0, 1, 1, NULL, NULL, NULL);
INSERT INTO `project` VALUES (15, '实验项目1', '这是一个小猪佩奇的体检项目，研究方向待定这是一个小猪佩奇的体检项目，研究方向待定这是一个小猪佩奇的体检项目，研究方向待定这是一个小猪佩奇的体检项目，研究方向待定这是一个小猪佩奇的体检项目，研究方向待定这是一个小猪佩奇的体检项目，研究方向待定这是一个小猪佩奇的体检项目，研究方向待定这是一个小猪佩奇的体检项目，研究方向待定这是一个小猪佩奇的体检项目，研究方向待定这是一个小猪佩奇的体检项目，研究方向待定', '项目1', '细胞', 2, '2018-05-23 08:44:35', '2018-06-24 09:15:31', 0, 'PDS20180523084435', 0, 1, 1, NULL, NULL, NULL);
INSERT INTO `project` VALUES (16, '项目1的子项目1', '这是小猪佩奇项目的子项目', '项目1的子项目', '组织', 2, '2018-05-29 13:56:54', '2018-06-05 11:28:51', 15, 'PDS20180529135654', 0, 1, 1, NULL, NULL, NULL);
INSERT INTO `project` VALUES (17, '项目2的子项目1', '这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目这是 项目2的  子项目', '项目2的子项目', '细胞', 3, '2018-05-30 08:58:35', '2018-06-24 11:09:21', 14, 'PDS20180530085835', 0, 1, 1, NULL, NULL, NULL);
INSERT INTO `project` VALUES (18, '项目2的子项目2', '验项目2的子项目2验项目2的子项目2验项目2的子项目2验项目2的子项目2验项目2的子项目2验项目2的子项目2验项目2的子项目2验项目2的子项目2验项目2的子项目2验项目2的子项目2验项目2的子项目2验项目2的子项目2验项目2的子项目2验项目2的子项目2', '实验项目2的子项目2', '组织', 2, '2018-05-31 06:34:32', '2018-06-24 10:34:42', 14, 'PDS20180531063432', 0, 1, 1, NULL, NULL, NULL);
INSERT INTO `project` VALUES (23, '实验项目3', '这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目这是一个实验项目', '项目3', '细胞', 3, '2018-06-23 03:44:05', '2018-06-24 09:15:58', 0, 'PDS1529725445D2', 0, 1, 1, NULL, NULL, NULL);
INSERT INTO `project` VALUES (24, '实验项目3的子项目', '这是一个实验项目', '项目1的子项目3', '细胞', 3, '2018-06-23 03:51:40', '2018-06-23 14:15:00', 14, 'PDS1529725900D2', 1, 1, 1, '2018-06-23 06:14:59', 1, NULL);
INSERT INTO `project` VALUES (25, '实验项目3的子项目', '这是一个实验项目', '项目3的子项目', '细胞', 3, '2018-06-23 03:53:36', '2018-06-23 11:53:37', 23, 'PDS1529726016D2', 0, 1, NULL, NULL, NULL, NULL);
INSERT INTO `project` VALUES (26, '实验项目3的子项目', '这是一个实验项目', '项目3的子项目', '细胞', 3, '2018-06-23 06:07:44', '2018-06-23 14:14:47', 23, 'PDS1529734064D2', 1, 1, NULL, '2018-06-23 06:14:47', 1, NULL);
INSERT INTO `project` VALUES (27, '实验项目3的子项目', '这是一个实验项目', '项目3的子项目', '细胞', 3, '2018-06-23 06:13:15', '2018-06-23 14:13:32', 23, 'PDS1529734395D2', 1, 1, NULL, '2018-06-23 06:13:31', 1, NULL);

-- ----------------------------
-- Table structure for protein
-- ----------------------------
DROP TABLE IF EXISTS `protein`;
CREATE TABLE `protein`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `retrieve` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '检测指标检索号',
  `section_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '切片名称',
  `section_type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '切片类型',
  `section_thickness` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '切片厚度',
  `section_preprocessing` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '切片预处理',
  `testflow` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '实验流程',
  `img` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '图片路径',
  `place` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '存放位置',
  `add_user` int(11) DEFAULT NULL,
  `add_time` datetime(0) DEFAULT NULL,
  `change_user` int(11) DEFAULT NULL,
  `change_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `isdel` int(11) DEFAULT NULL,
  `del_time` datetime(0) DEFAULT NULL,
  `del_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for reagent
-- ----------------------------
DROP TABLE IF EXISTS `reagent`;
CREATE TABLE `reagent`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '名称',
  `retrieve` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '检索号',
  `isdel` tinyint(1) DEFAULT 0 COMMENT '是否删除',
  `change_user` int(11) DEFAULT NULL COMMENT '修改人',
  `del_time` datetime(0) DEFAULT NULL COMMENT '删除时间',
  `add_time` datetime(0) DEFAULT NULL COMMENT '录入时间',
  `change_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `sid` int(11) DEFAULT NULL COMMENT '染色检测指标ID',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '类型',
  `tid` int(11) DEFAULT NULL COMMENT '检测方法id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of reagent
-- ----------------------------
INSERT INTO `reagent` VALUES (1, '试剂1', 'ETR1528786747', 1, 1, '2018-06-12 07:21:38', '2018-06-12 06:59:16', '2018-06-13 17:17:24', 5, 'routine', NULL);
INSERT INTO `reagent` VALUES (2, '试剂4', 'ETR1528786807', 0, 1, '2018-06-12 07:12:31', '2018-06-12 07:00:13', '2018-06-13 09:18:08', 5, 'routine', NULL);
INSERT INTO `reagent` VALUES (3, '试剂2', 'ETR1528859727', 0, NULL, NULL, '2018-06-13 03:15:35', '2018-06-13 17:17:21', 5, 'routine', NULL);
INSERT INTO `reagent` VALUES (4, '测试试剂1', 'ETR1528881242', 0, 1, NULL, '2018-06-13 09:14:19', '2018-06-13 09:17:15', 5, 'routine', NULL);
INSERT INTO `reagent` VALUES (5, '自配试剂1', 'ETR1528881568', 1, NULL, '2018-06-14 07:33:20', '2018-06-13 09:19:41', '2018-06-20 21:33:33', 1, 'testmethod', 3);
INSERT INTO `reagent` VALUES (6, '检测试剂11', 'ETR1528882187', 0, NULL, NULL, '2018-06-13 09:29:56', '2018-06-13 17:29:39', 6, 'routine', NULL);
INSERT INTO `reagent` VALUES (7, '检测试剂13', 'ETR1528897327', 0, NULL, NULL, '2018-06-13 13:42:30', '2018-06-20 21:34:22', 1, 'testmethod', 3);
INSERT INTO `reagent` VALUES (8, '检测试剂22', 'ETR1529501218', 0, 1, NULL, '2018-06-20 13:27:14', '2018-06-20 13:32:16', 2, 'testmethod', 1);
INSERT INTO `reagent` VALUES (9, '检测试剂21', 'ETR1529501338', 0, NULL, NULL, '2018-06-20 13:29:35', '2018-06-20 21:29:31', 2, 'testmethod', 1);
INSERT INTO `reagent` VALUES (10, '常规染色试剂1', 'ETR1529559293', 0, NULL, NULL, '2018-06-21 05:35:06', '2018-06-21 13:35:07', 5, 'routine', 5);
INSERT INTO `reagent` VALUES (11, '特殊染色试剂1', 'ETR1529559327', 1, NULL, '2018-11-16 03:05:43', '2018-06-21 05:35:36', '2018-11-16 11:05:43', 1, 'testmethod', 3);
INSERT INTO `reagent` VALUES (12, '检测指标测试', 'ETR1529762502A6', 0, NULL, NULL, '2018-06-23 14:01:53', '2018-06-23 22:01:47', 5, 'routine', 5);
INSERT INTO `reagent` VALUES (15, '测试数据1', 'ETR1529762665D2', 1, NULL, '2018-07-23 03:43:51', '2018-06-23 14:04:25', '2018-07-23 11:43:52', 5, 'routine', 5);
INSERT INTO `reagent` VALUES (16, '测试数据2', 'ETR1529762666D3', 0, NULL, NULL, '2018-06-23 14:04:26', '2018-06-23 22:04:20', 5, 'routine', 5);
INSERT INTO `reagent` VALUES (19, '测试数据1', 'ETR1529762930D2', 1, NULL, '2018-06-23 14:17:39', '2018-06-23 14:08:50', '2018-06-23 22:17:33', 3, 'testmethod', 4);
INSERT INTO `reagent` VALUES (20, '测试数据2', 'ETR1529762930D3', 1, NULL, '2018-06-23 14:18:17', '2018-06-23 14:08:50', '2018-06-23 22:18:11', 3, 'testmethod', 4);
INSERT INTO `reagent` VALUES (21, '测试数据1', 'ETR1529763068D2', 0, NULL, NULL, '2018-06-23 14:11:08', '2018-06-23 22:11:02', 3, 'testmethod', 4);
INSERT INTO `reagent` VALUES (22, '测试数据2', 'ETR1529763069D3', 0, NULL, NULL, '2018-06-23 14:11:09', '2018-06-23 22:11:03', 3, 'testmethod', 4);
INSERT INTO `reagent` VALUES (23, '测试数据1', 'ETR1529763831D2', 0, NULL, NULL, '2018-06-23 14:23:51', '2018-06-23 22:23:45', 2, 'testmethod', 1);
INSERT INTO `reagent` VALUES (24, '测试数据2', 'ETR1529763831D3', 0, NULL, NULL, '2018-06-23 14:23:51', '2018-06-23 22:23:45', 2, 'testmethod', 1);
INSERT INTO `reagent` VALUES (25, '测试数据1', 'ETR1529763855D2', 0, NULL, NULL, '2018-06-23 14:24:15', '2018-06-23 22:24:09', 7, 'routine', 7);
INSERT INTO `reagent` VALUES (26, '测试数据2', 'ETR1529763855D3', 0, NULL, NULL, '2018-06-23 14:24:15', '2018-06-23 22:24:09', 7, 'routine', 7);
INSERT INTO `reagent` VALUES (27, '12', 'ETR1531823545A5', 0, NULL, NULL, '2018-07-17 10:32:34', '2018-07-17 18:32:34', 5, 'routine', 5);

-- ----------------------------
-- Table structure for routine
-- ----------------------------
DROP TABLE IF EXISTS `routine`;
CREATE TABLE `routine`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `retrieve` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '检索编号',
  `axiom` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '常规染色检测原理',
  `process` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '流程',
  `add_time` datetime(0) DEFAULT NULL COMMENT '新增时间',
  `change_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '修改时间',
  `del_time` datetime(0) DEFAULT NULL COMMENT '删除时间',
  `isdel` tinyint(1) DEFAULT 0 COMMENT '是否删除',
  `name` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of routine
-- ----------------------------
INSERT INTO `routine` VALUES (5, 'PDS1528771310', '常规染色指标1', '常规染色指标1', '2018-06-12 02:41:50', '2018-11-16 10:51:23', NULL, 1, '常规染色指标121');
INSERT INTO `routine` VALUES (6, 'ETS1528859512', '检测指标2', '检测指标2', '2018-06-13 03:11:52', '2018-11-16 10:51:17', NULL, 1, '检测指标2');
INSERT INTO `routine` VALUES (7, 'ETS1529756239D2', '测试导入', '常规H&E染色参考实验流程', '2018-06-23 12:17:19', '2018-11-20 15:40:47', NULL, 0, 'H&E染色2');

-- ----------------------------
-- Table structure for sample
-- ----------------------------
DROP TABLE IF EXISTS `sample`;
CREATE TABLE `sample`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '图片',
  `retrieve` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '检索号',
  `descript` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '描述',
  `gid` int(11) DEFAULT NULL COMMENT '分组ID',
  `pid` int(11) DEFAULT NULL COMMENT '项目ID',
  `add_user` int(11) DEFAULT NULL COMMENT '添加时间',
  `add_time` datetime(0) DEFAULT NULL COMMENT '修改时间',
  `isdel` tinyint(1) DEFAULT 0 COMMENT '是否删除',
  `change_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '修改时间',
  `change_user` int(11) DEFAULT NULL COMMENT '修改人',
  `del_user` int(11) DEFAULT NULL COMMENT '删除人',
  `del_time` datetime(0) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sample
-- ----------------------------
INSERT INTO `sample` VALUES (1, '样本4', NULL, 'PSEG1528095842', '样本2', 8, 17, 1, '2018-06-04 07:04:02', 0, '2018-06-22 06:47:31', 1, 1, '2018-06-05 07:42:31');
INSERT INTO `sample` VALUES (2, '样本2', NULL, 'PSEG1528184626', '样本2', 8, 17, 1, '2018-06-05 07:43:46', 0, '2018-06-22 06:32:28', 1, NULL, NULL);
INSERT INTO `sample` VALUES (3, '测试样品', NULL, 'PSEG1529393182', '描述', 9, 17, 1, '2018-06-19 07:26:22', 0, '2018-06-19 15:26:06', NULL, NULL, NULL);
INSERT INTO `sample` VALUES (4, '导入样本', NULL, 'PSEG1529742129D2', '测试导入', 8, 17, 1, '2018-06-23 08:22:09', 1, '2018-06-28 17:06:06', NULL, 1, '2018-06-28 07:10:45');
INSERT INTO `sample` VALUES (5, '导入样本', NULL, 'PSEG1529742163D2', '测试导入', 8, 17, 1, '2018-06-23 08:22:43', 1, '2018-06-28 17:06:25', NULL, 1, '2018-06-23 08:22:48');
INSERT INTO `sample` VALUES (6, '导入样本', NULL, 'PSEG1530170072D2', '测试导入', 8, 17, 1, '2018-06-28 07:14:32', 1, '2018-06-28 17:06:28', NULL, 1, '2018-06-28 07:18:15');
INSERT INTO `sample` VALUES (7, '导入样本', NULL, 'PSEG1530170310D2', '测试导入', 8, 17, 1, '2018-06-28 07:18:30', 0, '2018-06-28 15:18:30', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for sdyeing
-- ----------------------------
DROP TABLE IF EXISTS `sdyeing`;
CREATE TABLE `sdyeing`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `retrieve` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '检测指标检索号',
  `section_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '切片名称',
  `section_type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '切片类型',
  `section_thickness` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '切片厚度',
  `section_preprocessing` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '切片预处理',
  `testflow` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '实验流程',
  `img` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '图片路径',
  `place` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '存放位置',
  `add_user` int(11) DEFAULT NULL,
  `add_time` datetime(0) DEFAULT NULL,
  `change_user` int(11) DEFAULT NULL,
  `change_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `isdel` int(11) DEFAULT 0,
  `del_time` datetime(0) DEFAULT NULL,
  `del_user` int(11) DEFAULT NULL,
  `nid` int(11) DEFAULT NULL COMMENT '检测指标id',
  `ntype` tinyint(1) DEFAULT NULL COMMENT '检测指标类型1常规H&E染色2特殊染色3蛋白4核算',
  `kit` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '检测试剂盒/抗体',
  `rgid` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '其他试剂',
  `attention` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '注意事项',
  `yid` int(11) DEFAULT NULL COMMENT '样品id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sdyeing
-- ----------------------------
INSERT INTO `sdyeing` VALUES (5, 'ERHE1529482805', '常规染色切片1', '冰冻切片', '0.1mm', '切片预处理', '<p><img src=\"/uploads/redactor-img/20180624/1529838135665836.jpg\" title=\"1529838135665836.jpg\" alt=\"image-1.jpg\"/></p><p><br/></p><p><br/></p>', '/uploads/products-img/img_5b4eb4858f82c.png', '存放位置', NULL, '2018-06-20 08:20:05', NULL, '2018-07-18 11:31:17', 0, NULL, NULL, 5, 1, '', '[\"2\",\"3\"]', NULL, 1);
INSERT INTO `sdyeing` VALUES (6, 'ERHE1529504028', '特殊染色切片1', '冰冻切片', '0.011mm', '切片预处理', '<p>213</p>', '/uploads/products-img/img_5b2b628c37652.png', '存放位置', NULL, '2018-06-20 14:13:48', NULL, '2018-06-21 17:43:25', 0, NULL, NULL, 1, 2, '[\"12\"]', '', NULL, 1);
INSERT INTO `sdyeing` VALUES (7, 'ERHE1529504290', '特殊染色切片2', '冰冻切片', '0.01mm', '切片预处理', '<p>13213</p>', '/uploads/products-img/img_5b2a6222a4533.jpg', '存放位置', NULL, '2018-06-20 14:18:10', NULL, '2018-06-21 15:32:57', 1, NULL, NULL, 1, 3, '[\"12\",\"16\"]', '[\"7\"]', NULL, 1);
INSERT INTO `sdyeing` VALUES (8, 'ERHE1529547566', '核酸切片', '冰冻切片', '12', '切片预处理', '<p>123</p>', '/uploads/products-img/img_5b2b0b2e5a4ec.png', '存放位置', NULL, '2018-06-21 02:19:26', NULL, '2018-06-21 10:54:12', 0, NULL, NULL, 1, 4, '[\"15\"]', '', '<p>123<br/></p>', 1);
INSERT INTO `sdyeing` VALUES (10, 'ERHE1529562863', '特殊染色切片2', '冰冻切片', '0.01mm', '切片预处理', '<p>123123</p>', '/uploads/products-img/img_5b2b46efee712.png', '存放位置', NULL, '2018-06-21 06:34:23', NULL, '2018-06-21 14:34:24', 0, NULL, NULL, 6, 1, NULL, '[\"6\"]', NULL, 1);
INSERT INTO `sdyeing` VALUES (11, 'ERP1529565056', '蛋白切片1', '冰冻切片', '12', '12', '<p>123123</p>', '/uploads/products-img/img_5b2b4f809e275.png', '12', NULL, '2018-06-21 07:10:56', NULL, '2018-06-21 23:37:29', 0, NULL, NULL, 3, 3, '[\"17\"]', '', '<p>注意事情</p>', 1);
INSERT INTO `sdyeing` VALUES (12, 'ERHE1529657771', '常规染色切片4', '冰冻切片', '0.01', '切片预处理', '<p>123123</p>', '/uploads/products-img/img_5b2cb9ab2b68e.png', '存放位置', NULL, '2018-06-22 08:56:11', NULL, '2018-06-22 16:56:11', 0, NULL, NULL, 5, 1, NULL, '[\"2\",\"3\"]', NULL, 2);
INSERT INTO `sdyeing` VALUES (13, 'ERSS1529657820', '特殊染色切片2', '冰冻切片', '0.01', '切片预处理', '<p>123123</p>', '/uploads/products-img/img_5b2cb9dcd07b0.png', '切片预处理', NULL, '2018-06-22 08:57:00', NULL, '2018-06-22 16:57:01', 0, NULL, NULL, 1, 2, '[\"12\",\"16\"]', '[\"7\",\"11\"]', NULL, 2);
INSERT INTO `sdyeing` VALUES (14, 'ERP1529657862', '蛋白切片2', '冰冻切片', '12', '切片预处理', '', '', '', NULL, '2018-06-22 08:57:42', NULL, '2018-06-22 16:57:42', 0, NULL, NULL, 3, 3, '[\"17\"]', '', '', 2);
INSERT INTO `sdyeing` VALUES (16, 'ERHE1529744773D2', '导入实验结果', '冰冻切片', '测试导入', '样本组织1', NULL, NULL, '冷冻室', 1, '2018-06-23 09:06:13', NULL, '2018-06-23 17:18:16', 0, NULL, NULL, NULL, 1, NULL, NULL, NULL, 4);

-- ----------------------------
-- Table structure for stace
-- ----------------------------
DROP TABLE IF EXISTS `stace`;
CREATE TABLE `stace`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '描述',
  `retrieve` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '检索号',
  `postion` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '部位',
  `handle` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '处理方式',
  `place` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '存放位置',
  `sid` int(11) DEFAULT NULL COMMENT '所属样品id',
  `isdel` tinyint(1) DEFAULT 0 COMMENT '是否删除',
  `add_time` datetime(0) DEFAULT NULL COMMENT '添加时间',
  `add_user` int(11) DEFAULT NULL COMMENT '添加人',
  `change_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '修改时间',
  `change_user` int(11) DEFAULT NULL COMMENT '修改人',
  `del_time` datetime(0) DEFAULT NULL COMMENT '删除时间',
  `del_user` int(11) DEFAULT NULL COMMENT '删除人',
  `result_retrieve` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '实验结果检索号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stace
-- ----------------------------
INSERT INTO `stace` VALUES (1, '样本组织11', '样本组织1', 'PSEG1528182624', '样本组织1', '取材', '样本组织1', 1, 0, '2018-06-05 07:10:24', 1, '2018-06-22 07:00:42', 1, '2018-06-05 07:39:42', 1, 'ERHE1528182624');
INSERT INTO `stace` VALUES (2, '样本细胞1', '样本细胞1', 'PSEG1528184654', '样本细胞1', '固定', '1', 1, 0, '2018-06-05 07:44:14', 1, '2018-06-06 14:58:37', NULL, NULL, NULL, 'ERHE1528184654');
INSERT INTO `stace` VALUES (3, '组织细胞1', '组织细胞1', 'PSEG1529393208', '组织细胞1', '取材', '组织细胞1', 3, 0, '2018-06-19 07:26:48', 1, '2018-06-19 15:26:32', NULL, NULL, NULL, 'ERHE1529393208');
INSERT INTO `stace` VALUES (4, '导入标本', '测试导入', 'ERHE1529742773D2', '样本组织1', '取材', '样本组织1', 4, 0, '2018-06-23 08:32:53', 1, '2018-06-23 16:32:54', NULL, NULL, NULL, NULL);
INSERT INTO `stace` VALUES (5, '导入实验结果', '测试导入', 'ERHE1529743850D2', '样本组织1', '冷冻室', '样本组织1', 4, 1, '2018-06-23 08:50:50', 1, '2018-06-23 16:51:40', NULL, '2018-06-23 08:51:39', 1, NULL);
INSERT INTO `stace` VALUES (6, '导入实验结果', '测试导入', 'ERHE1529743907D2', '样本组织1', '冷冻室', '样本组织1', 4, 1, '2018-06-23 08:51:47', 1, '2018-06-23 16:51:55', NULL, '2018-06-23 08:51:54', 1, NULL);

-- ----------------------------
-- Table structure for testmethod
-- ----------------------------
DROP TABLE IF EXISTS `testmethod`;
CREATE TABLE `testmethod`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `retrieve` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '检索号',
  `positive` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '阳性对照',
  `negative` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '阴性对照',
  `judge` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '结果判断',
  `matters` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '注意事项',
  `add_time` datetime(0) DEFAULT NULL COMMENT '添加时间',
  `change_time` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '修改时间',
  `chang_user` int(11) DEFAULT NULL COMMENT '修改人',
  `isdel` tinyint(1) DEFAULT 0 COMMENT '是否删除',
  `del_time` datetime(0) DEFAULT NULL COMMENT '删除时间',
  `pid` int(11) DEFAULT NULL COMMENT '指标ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of testmethod
-- ----------------------------
INSERT INTO `testmethod` VALUES (1, '检测方法21', 'ETM1528875757', '阳性对照', '阴性对照', '结果判断', '注意事项', '2018-06-13 07:42:37', '2018-06-23 22:58:15', NULL, 0, NULL, 2);
INSERT INTO `testmethod` VALUES (2, '检测方法1', 'ETM1528876304', '阳性对照', '阳性对照', '阳性对照', '阳性对照', '2018-06-13 07:51:44', '2018-06-13 15:52:13', NULL, 1, NULL, 2);
INSERT INTO `testmethod` VALUES (3, '油红O染色', 'ETM1528896737', '阳性对照', '阳性对照', '阳性对照', '阳性对照', '2018-06-13 13:32:17', '2018-11-16 11:02:09', NULL, 0, NULL, 1);
INSERT INTO `testmethod` VALUES (4, '导入检测方法', 'ETM1529757661D2', '阳性对照', '阴性对照', '结果判断', '注意事项', '2018-06-23 12:41:01', '2018-06-23 20:40:55', NULL, 0, NULL, 3);

SET FOREIGN_KEY_CHECKS = 1;
