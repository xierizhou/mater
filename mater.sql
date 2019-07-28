/*
 Navicat Premium Data Transfer

 Source Server         : 47.98.172.38
 Source Server Type    : MySQL
 Source Server Version : 50722
 Source Host           : 47.98.172.38:3306
 Source Schema         : mater

 Target Server Type    : MySQL
 Target Server Version : 50722
 File Encoding         : 65001

 Date: 27/07/2019 10:53:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for activitys
-- ----------------------------
DROP TABLE IF EXISTS `activitys`;
CREATE TABLE `activitys`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '活动标题',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0未开启，1正在进行  2过期',
  `material_range` tinyint(1) NOT NULL DEFAULT 0 COMMENT '活动网站范围；0全部素材网站，1指定素材网站',
  `material_range_ids` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '指定素材网站的ids，多个以逗号分开',
  `user_range` tinyint(1) NOT NULL DEFAULT 0 COMMENT '用户范围；0全部用户 1指定用户',
  `user_range_ids` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '指定用户',
  `benefit` int(1) NULL DEFAULT 0 COMMENT '0直接赠送用户素材网站添加次数，不限时间，用完为止；1开放下载，不会增加到用户次数上，但活动这段时间内开放下载，不扣除用户次数',
  `give_number` int(11) NULL DEFAULT NULL COMMENT '赠送次数；如果benefit为0',
  `give_mode` tinyint(1) NULL DEFAULT 0 COMMENT '如果benefit为0，赠送方式；0素材网站范围内其中一个受益，1所有网站受益',
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '说明',
  `start_time` int(11) NOT NULL COMMENT '活动开始时间',
  `end_time` int(11) NOT NULL COMMENT '活动结束时间',
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '活动表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admins_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES (1, 'admin', '$2y$10$SW0szZ8XztdMxyxpNN4NW.racqLuAwyQWyg9AcQ3bPbNCs9KGmJOW', 'YeeK627d7BCWqdP4of3hrQFQCcwk8LqoGqGbNv3QQLBzoMd1w35yVhKNTppU', '2019-06-25 15:38:33', '2019-06-25 15:38:33');

-- ----------------------------
-- Table structure for channel_cookies
-- ----------------------------
DROP TABLE IF EXISTS `channel_cookies`;
CREATE TABLE `channel_cookies`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `channel_id` int(11) NOT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用于区分cookie',
  `cookie` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of channel_cookies
-- ----------------------------
INSERT INTO `channel_cookies` VALUES (2, 3, 'tk', 'tk=1564134326.37', 1564131943, 1564134325);

-- ----------------------------
-- Table structure for channels
-- ----------------------------
DROP TABLE IF EXISTS `channels`;
CREATE TABLE `channels`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '渠道名称，内部名称',
  `alias_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '渠道别名，主要用这个显示给用户看',
  `domain` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '域名',
  `username` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '渠道用户名',
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '密码',
  `state` tinyint(1) NULL DEFAULT NULL COMMENT '0禁用 1正常 2过期',
  `cookie` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '登录的cookie,用于保持登录',
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of channels
-- ----------------------------
INSERT INTO `channels` VALUES (1, 'Whole down', '主线路', 'http://baidule.yuansupic.com', '6277053', '308449', 2, 'sessionid=n52y508uwomuwhy4h86je6lv2gv23plh', '2019-06-29 05:38:42', '2019-07-02 13:38:49');
INSERT INTO `channels` VALUES (2, '唯她素材网', '线路一', 'http://sssc.co', '18820005015', 'wwff00', 1, 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6NDcyMzUsIm1vYmlsZSI6IjE4ODIwMDA1MDE1IiwicGFzc3dvcmQiOiJjYzllYjQ2NDFjYTA1NDVhYjZhNDZmNTJjODFiMWQ1YSIsImlhdCI6MTU2MzI4OTEwOCwiZXhwIjoxNTYzMjkyNzA4fQ.0jJ3RdXHgC7i-6hZa7CqMSN9OEMW5x6jfw41oKc1od4', '2019-07-02 13:38:42', '2019-07-16 14:58:28');
INSERT INTO `channels` VALUES (3, 'yuansupic', 'yuansupic', 'http://15cheng.yuansupic.com', '819171', 'b81adc99', 1, 'sessionid=ou8wsjvkuwml4ci3c82c4q6c4dm1v0yo;', '2019-07-18 14:18:08', '2019-07-22 15:37:10');
INSERT INTO `channels` VALUES (4, '包图官网', 'ibaotu', 'https://ibaotu.com', '1', '1', 1, NULL, '2019-07-27 02:47:21', '2019-07-27 02:47:21');

-- ----------------------------
-- Table structure for emails
-- ----------------------------
DROP TABLE IF EXISTS `emails`;
CREATE TABLE `emails`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '发件人',
  `addressee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '收件人',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
  `is_success` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0等待发送 1发送成功 2发送失败',
  `fail_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '发送失败信息',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '发送的内容',
  `send_time` int(11) NULL DEFAULT NULL COMMENT '发送时间',
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of emails
-- ----------------------------
INSERT INTO `emails` VALUES (1, 'rjou.sye@foxmail.com', '384860859@qq.com', '手绘卡通可爱兔子甜点', 1, NULL, '<table style=\"min-width: 500px;background-color: #fff;padding: 16px;\">\r\n    <tbody>\r\n        <tr style=\"height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);\">\r\n            <td>网站名称：</td>\r\n            <td><a style=\"text-decoration:none;\" target=\"_blank\" href=\"https://www.58pic.com/\">千图网</a></td>\r\n        </tr>\r\n        <tr style=\"height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);\">\r\n            <td>素材标题：</td>\r\n            <td><a style=\"text-decoration:none;\" target=\"_blank\" href=\"https://www.58pic.com/newpic/35181888.html\" title=\"手绘卡通可爱兔子甜点\">手绘卡通可爱兔子甜点</a></td>\r\n        </tr>\r\n        <tr style=\"height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);\">\r\n            <td>素材链接：</td>\r\n            <td><a style=\"text-decoration:none;\" target=\"_blank\" href=\"https://www.58pic.com/newpic/35181888.html\">https://www.58pic.com/newpic/35181888.html</a></td>\r\n        </tr>\r\n        <tr style=\"height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);\">\r\n            <td>下载地址：</td>\r\n            <td>\r\n                                    <a style=\"text-decoration:none;color: #fff;background-color: #2d8cf0;border-color: #2d8cf0;border-radius: 3px;text-align: center;padding: 6px 15px!important;\" target=\"_blank\" href=\"http://razee.oss-cn-shenzhen.aliyuncs.com/58pic/3ab4f1bf9a3859caa8b902f382c0af3f.zip?OSSAccessKeyId=LTAIEoIuxMOfxkpm&amp;Expires=1564211604&amp;Signature=69672cNjQ5LEqMlGdQ3yLsceZOE%3D\"><span style=\"font-size: 12px;\">下载文件</span></a>\r\n                            </td>\r\n        </tr>\r\n        <tr style=\"height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);\">\r\n            <td style=\"text-align: right;\">下载说明：</td>\r\n            <td>\r\n                <span style=\"color:#f24747;font-size:14px;\">下载链接24小时内有效，请尽快下载并保存到您的电脑上，感谢您的配合与支持~</span>\r\n            </td>\r\n        </tr>\r\n\r\n    </tbody>\r\n</table>\r\n\r\n', 1564125207, 1564125207, 1564125207);
INSERT INTO `emails` VALUES (2, 'rjou.sye@foxmail.com', '384860859@qq.com', '手绘卡通可爱兔子甜点', 1, NULL, '<table style=\"min-width: 500px;background-color: #fff;padding: 16px;\">\r\n    <tbody>\r\n        <tr style=\"height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);\">\r\n            <td>网站名称：</td>\r\n            <td><a style=\"text-decoration:none;\" target=\"_blank\" href=\"https://www.58pic.com/\">千图网</a></td>\r\n        </tr>\r\n        <tr style=\"height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);\">\r\n            <td>素材标题：</td>\r\n            <td><a style=\"text-decoration:none;\" target=\"_blank\" href=\"https://www.58pic.com/newpic/35181888.html\" title=\"手绘卡通可爱兔子甜点\">手绘卡通可爱兔子甜点</a></td>\r\n        </tr>\r\n        <tr style=\"height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);\">\r\n            <td>素材链接：</td>\r\n            <td><a style=\"text-decoration:none;\" target=\"_blank\" href=\"https://www.58pic.com/newpic/35181888.html\">https://www.58pic.com/newpic/35181888.html</a></td>\r\n        </tr>\r\n        <tr style=\"height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);\">\r\n            <td>下载地址：</td>\r\n            <td>\r\n                                    <a style=\"text-decoration:none;color: #fff;background-color: #2d8cf0;border-color: #2d8cf0;border-radius: 3px;text-align: center;padding: 6px 15px!important;\" target=\"_blank\" href=\"http://razee.oss-cn-shenzhen.aliyuncs.com/58pic/5d61013f478e8567a472272f816ee0a3.zip?OSSAccessKeyId=LTAIEoIuxMOfxkpm&amp;Expires=1564212239&amp;Signature=GSZZqTj2RJK7i%2BmyBub0ekPIyOU%3D\"><span style=\"font-size: 12px;\">下载文件</span></a>\r\n                            </td>\r\n        </tr>\r\n        <tr style=\"height: 34px;width: 100%;font-size: 12px;line-height: 34px;border-bottom: 1px solid rgba(0,0,0,.1);\">\r\n            <td style=\"text-align: right;\">下载说明：</td>\r\n            <td>\r\n                <span style=\"color:#f24747;font-size:14px;\">下载链接24小时内有效，请尽快下载并保存到您的电脑上，感谢您的配合与支持~</span>\r\n            </td>\r\n        </tr>\r\n\r\n    </tbody>\r\n</table>\r\n\r\n', 1564125841, 1564125841, 1564125841);

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED NULL DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------
INSERT INTO `jobs` VALUES (1, 'default', '{\"displayName\":\"App\\\\Jobs\\\\DownloadMaterialJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\DownloadMaterialJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\DownloadMaterialJob\\\":8:{s:42:\\\"\\u0000App\\\\Jobs\\\\DownloadMaterialJob\\u0000materialFile\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":3:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\MaterialFile\\\";s:2:\\\"id\\\";i:51;s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"\\u0000*\\u0000job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1564059452, 1564059452);
INSERT INTO `jobs` VALUES (2, 'default', '{\"displayName\":\"App\\\\Jobs\\\\DownloadMaterialJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\DownloadMaterialJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\DownloadMaterialJob\\\":8:{s:42:\\\"\\u0000App\\\\Jobs\\\\DownloadMaterialJob\\u0000materialFile\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":3:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\MaterialFile\\\";s:2:\\\"id\\\";i:52;s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"\\u0000*\\u0000job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1564059826, 1564059826);
INSERT INTO `jobs` VALUES (3, 'default', '{\"displayName\":\"App\\\\Jobs\\\\DownloadMaterialJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\DownloadMaterialJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\DownloadMaterialJob\\\":8:{s:42:\\\"\\u0000App\\\\Jobs\\\\DownloadMaterialJob\\u0000materialFile\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":3:{s:5:\\\"class\\\";s:23:\\\"App\\\\Models\\\\MaterialFile\\\";s:2:\\\"id\\\";i:53;s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:6:\\\"\\u0000*\\u0000job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}', 0, NULL, 1564060237, 1564060237);

-- ----------------------------
-- Table structure for material_channels
-- ----------------------------
DROP TABLE IF EXISTS `material_channels`;
CREATE TABLE `material_channels`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of material_channels
-- ----------------------------
INSERT INTO `material_channels` VALUES (4, 4, 1);
INSERT INTO `material_channels` VALUES (8, 8, 1);
INSERT INTO `material_channels` VALUES (9, 9, 1);
INSERT INTO `material_channels` VALUES (11, 2, 2);
INSERT INTO `material_channels` VALUES (17, 1, 2);
INSERT INTO `material_channels` VALUES (18, 3, 2);
INSERT INTO `material_channels` VALUES (19, 5, 2);
INSERT INTO `material_channels` VALUES (20, 7, 2);
INSERT INTO `material_channels` VALUES (21, 6, 2);

-- ----------------------------
-- Table structure for material_file_attachments
-- ----------------------------
DROP TABLE IF EXISTS `material_file_attachments`;
CREATE TABLE `material_file_attachments`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `material_file_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `source` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '源下载',
  `path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '加速下载',
  `is_oss` tinyint(1) NULL DEFAULT 0 COMMENT '是否存放到阿里oss',
  `oss` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT 'oss的文件路径',
  `oss_url_expire` int(11) NULL DEFAULT NULL COMMENT 'oss 链接失效时间',
  `size` double NULL DEFAULT NULL COMMENT '大小 单位b',
  `format` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '文件格式',
  `extra` json NULL COMMENT '其它信息 json格式',
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `material_file_attachments_material_file_id`(`material_file_id`) USING BTREE,
  CONSTRAINT `material_file_attachments_material_file_id` FOREIGN KEY (`material_file_id`) REFERENCES `material_files` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 109 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of material_file_attachments
-- ----------------------------
INSERT INTO `material_file_attachments` VALUES (1, 1, 'JPG', 'http://download.588ku.com/Templet_origin_pic/04/97/36/78d668ee56adfbb615c301f9b8dbe831.jpg?_upd=true&key=bb6bd905d3d310724e51961c4106afbf&t=1562772065', 'http://razee.oss-cn-shenzhen.aliyuncs.com/588ku/0559f43d9ff75b786771383489185dd2.jpg?OSSAccessKeyId=LTAIEoIuxMOfxkpm&Expires=1563293771&Signature=Swl7UMDvkxsaERbZxc4zgaw17Iw%3D', 1, '588ku/0559f43d9ff75b786771383489185dd2.jpg', NULL, 315497, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"http://download.588ku.com/Templet_origin_pic/04/97/36/78d668ee56adfbb615c301f9b8dbe831.jpg?_upd=true&key=bb6bd905d3d310724e51961c4106afbf&t=1562772065\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-16 15:16:11', '2019-07-10 15:16:09');
INSERT INTO `material_file_attachments` VALUES (2, 1, 'PSD', 'https://proxy-vip.588ku.com/back_psd/04/97/36/588ku_f899e7df2c84b9331add8f6a58ddbb8e.zip?st=zmIFh2vkW0C6itpoYMZGjQ&e=1562772365', 'http://razee.oss-cn-shenzhen.aliyuncs.com/588ku/aca48b41aa5db9df0174bb077eb2bfb4.zip?OSSAccessKeyId=LTAIEoIuxMOfxkpm&Expires=1563293771&Signature=GJ%2FhX0bBD1HprBUDWUIhjkzbGDU%3D', 1, '588ku/aca48b41aa5db9df0174bb077eb2bfb4.zip', NULL, 12766518, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"https://proxy-vip.588ku.com/back_psd/04/97/36/588ku_f899e7df2c84b9331add8f6a58ddbb8e.zip?st=zmIFh2vkW0C6itpoYMZGjQ&e=1562772365\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-16 15:16:11', '2019-07-10 15:16:09');
INSERT INTO `material_file_attachments` VALUES (5, 2, 'JPG', 'http://download.588ku.com/Templet_origin_pic/04/94/49/58cc88bef9d0606b5393f1d39cee87f3.jpg?_upd=true&key=f60d6a6622c696d0a878d3518c3b9ecc&t=1559733289', 'http://razee.oss-cn-shenzhen.aliyuncs.com/588ku/82ba42ae55ad5acd9467351d8827fd5e.jpg?OSSAccessKeyId=LTAIEoIuxMOfxkpm&Expires=1563293865&Signature=az6bYSi2vHebYevORpsFLJlxK8w%3D', 1, '588ku/82ba42ae55ad5acd9467351d8827fd5e.jpg', NULL, 764118, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"http://download.588ku.com/Templet_origin_pic/04/94/49/58cc88bef9d0606b5393f1d39cee87f3.jpg?_upd=true&key=f60d6a6622c696d0a878d3518c3b9ecc&t=1559733289\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-16 15:17:45', '2019-07-12 12:50:39');
INSERT INTO `material_file_attachments` VALUES (6, 2, 'PSD', 'http://proxy-vip.588ku.com/back_psd/04/94/49/588ku_6c38251c2ef7d45df6808d2a247d9e98.zip?st=oJGk9NDIfiLDE2-hLGSflg&e=1559733589', 'http://razee.oss-cn-shenzhen.aliyuncs.com/588ku/d029babec3fc7e0e901110dde18954a0.zip?OSSAccessKeyId=LTAIEoIuxMOfxkpm&Expires=1563293865&Signature=Q00BUD%2Fpv3X6bnFVzbtly92sb08%3D', 1, '588ku/d029babec3fc7e0e901110dde18954a0.zip', NULL, 6176830, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"http://proxy-vip.588ku.com/back_psd/04/94/49/588ku_6c38251c2ef7d45df6808d2a247d9e98.zip?st=oJGk9NDIfiLDE2-hLGSflg&e=1559733589\", \"type\": 3, \"status\": 0}}}', '2019-07-16 15:17:45', '2019-07-12 12:50:39');
INSERT INTO `material_file_attachments` VALUES (7, 3, 'JPG', 'http://download.588ku.com/Templet_origin_pic/04/94/49/61921a8ab15bc4812c739a3657a87002.jpg?_upd=true&key=a7c47fd136b649e2f5e74068dad7ebd6&t=1560223564', 'http://razee.oss-cn-shenzhen.aliyuncs.com/588ku/2856e463d18c779e0bcc8e90ffaaa0b8.jpg?OSSAccessKeyId=LTAIEoIuxMOfxkpm&Expires=1563294358&Signature=%2FyjT1kvrNIWjUblRygZYmcp1P4E%3D', 1, '588ku/2856e463d18c779e0bcc8e90ffaaa0b8.jpg', NULL, 4846706, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"http://download.588ku.com/Templet_origin_pic/04/94/49/61921a8ab15bc4812c739a3657a87002.jpg?_upd=true&key=a7c47fd136b649e2f5e74068dad7ebd6&t=1560223564\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-16 15:25:58', '2019-07-12 12:54:03');
INSERT INTO `material_file_attachments` VALUES (8, 3, 'PSD', 'http://proxy-vip.588ku.com/back_psd/04/94/49/588ku_9229e1eabc71ca738aa65e338b3d857d.zip?st=eLafJdRXmb7znr_1-3_U2w&e=1560223864', 'http://razee.oss-cn-shenzhen.aliyuncs.com/588ku/f4c4ee2a980b3f2b585864d4a48f65bf.zip?OSSAccessKeyId=LTAIEoIuxMOfxkpm&Expires=1563294358&Signature=psjUGBc3yyTfrQxwL6eoiLVh9yU%3D', 1, '588ku/f4c4ee2a980b3f2b585864d4a48f65bf.zip', NULL, 1104, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"http://proxy-vip.588ku.com/back_psd/04/94/49/588ku_9229e1eabc71ca738aa65e338b3d857d.zip?st=eLafJdRXmb7znr_1-3_U2w&e=1560223864\", \"type\": 3, \"status\": 0}}}', '2019-07-16 15:25:58', '2019-07-12 12:54:03');
INSERT INTO `material_file_attachments` VALUES (9, 4, 'JPG', 'http://download.588ku.com/Templet_origin_pic/04/94/51/661fa75685b4e121c406c20d49c22c3c.jpg?_upd=true&key=b5e30a1e445ff4db730bbfeeb81d6220&t=1562936455', 'http://razee.oss-cn-shenzhen.aliyuncs.com/588ku/5ef3d39857b87c2d3035c1747ce57d15.jpg?OSSAccessKeyId=LTAIEoIuxMOfxkpm&Expires=1563294338&Signature=OJSFPpdHBb%2FXDVtGRORaXpFUTb4%3D', 1, '588ku/5ef3d39857b87c2d3035c1747ce57d15.jpg', NULL, 4520739, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"http://download.588ku.com/Templet_origin_pic/04/94/51/661fa75685b4e121c406c20d49c22c3c.jpg?_upd=true&key=b5e30a1e445ff4db730bbfeeb81d6220&t=1562936455\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-16 15:25:38', '2019-07-12 12:55:59');
INSERT INTO `material_file_attachments` VALUES (10, 4, 'PSD', 'https://proxy-vip.588ku.com/back_psd/04/94/51/588ku_4e19602b3b82becb4fba30223ee4bce1.zip?st=tIeO-nI2PdO2AvabT7_5lg&e=1562936755', 'http://razee.oss-cn-shenzhen.aliyuncs.com/588ku/f30f8b0aabf7a8190b84ff46d85ba0f0.zip?OSSAccessKeyId=LTAIEoIuxMOfxkpm&Expires=1563294338&Signature=WGibyWBjaSX41Bupishp7ixLsYg%3D', 1, '588ku/f30f8b0aabf7a8190b84ff46d85ba0f0.zip', NULL, 24414852, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"https://proxy-vip.588ku.com/back_psd/04/94/51/588ku_4e19602b3b82becb4fba30223ee4bce1.zip?st=tIeO-nI2PdO2AvabT7_5lg&e=1562936755\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-16 15:25:38', '2019-07-12 12:55:59');
INSERT INTO `material_file_attachments` VALUES (13, 5, 'JPG', 'http://download.588ku.com/Templet_origin_pic/04/93/82/eb23950933400d2790f930f71733e901.jpg?_upd=true&key=2dce7b8e30a9a92e0ad81806bb1dbb3d&t=1562154434', 'http://sonorous.oss-cn-hangzhou.aliyuncs.com/588ku/10/Templet_origin_pic/04/93/82/raqkL_eb23950933400d2790f930f71733e901.jpg?OSSAccessKeyId=LTAI2oF3bE0PwTZS&Expires=1563007345&Signature=MxuxN4z%2BvPvp82RihaKhWuKgqCs%3D', 0, NULL, NULL, 3066227, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"http://download.588ku.com/Templet_origin_pic/04/93/82/eb23950933400d2790f930f71733e901.jpg?_upd=true&key=2dce7b8e30a9a92e0ad81806bb1dbb3d&t=1562154434\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-13 08:37:24', '2019-07-13 08:37:24');
INSERT INTO `material_file_attachments` VALUES (14, 5, 'PSD', 'https://proxy-vip.588ku.com/back_psd/04/93/82/588ku_4c0fc7c24099acbf3d1e7bff8656d2da.rar?st=G438595braPhGFF6MPoDdw&e=1562154734', 'http://sonorous.oss-cn-hangzhou.aliyuncs.com/588ku/5585/back_psd/04/93/82/MzeXW_588ku_4c0fc7c24099acbf3d1e7bff8656d2da.rar?OSSAccessKeyId=LTAI2oF3bE0PwTZS&Expires=1563007345&Signature=UztpP%2F92iKVAg%2FvCtFYD4MdJDu8%3D', 0, NULL, NULL, 17893182, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"https://proxy-vip.588ku.com/back_psd/04/93/82/588ku_4c0fc7c24099acbf3d1e7bff8656d2da.rar?st=G438595braPhGFF6MPoDdw&e=1562154734\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-13 08:37:24', '2019-07-13 08:37:24');
INSERT INTO `material_file_attachments` VALUES (19, 6, 'JPG', 'http://download.588ku.com/back_origin_pic/05/61/35/7a4a03b9c5119543f3f5ec4fd0ab65b1.jpg?_upd=true&key=7905b71199cbfcfa00f2dd25c3d2edee&t=1562151159', 'http://sonorous.oss-cn-hangzhou.aliyuncs.com/588ku/10/back_origin_pic/05/61/35/2zl2a_7a4a03b9c5119543f3f5ec4fd0ab65b1.jpg?OSSAccessKeyId=LTAI2oF3bE0PwTZS&Expires=1563204444&Signature=Roz5LYgh4aePAW%2B7tfAtns7o15w%3D', 0, NULL, NULL, 3369403, NULL, '{\"extra\": {\"data\": {\"id\": 5613589, \"msg\": \"可以下载\", \"uid\": \"27030711\", \"url\": \"http://download.588ku.com/back_origin_pic/05/61/35/7a4a03b9c5119543f3f5ec4fd0ab65b1.jpg?_upd=true&key=7905b71199cbfcfa00f2dd25c3d2edee&t=1562151159\", \"type\": 2, \"isvip\": true, \"status\": 0, \"keyword\": null}}}', '2019-07-15 15:22:23', '2019-07-15 15:22:23');
INSERT INTO `material_file_attachments` VALUES (20, 6, 'PSD', 'https://proxy-vip.588ku.com/back_psd/05/61/35/588ku_3aa904b291ff5ee9c8ce2482c355fa11.rar?st=PXfoX8J54-GQ4Ht_ZkUxxg&e=1562149959', 'http://sonorous.oss-cn-hangzhou.aliyuncs.com/588ku/5585/back_psd/05/61/35/xO0qp_588ku_3aa904b291ff5ee9c8ce2482c355fa11.rar?OSSAccessKeyId=LTAI2oF3bE0PwTZS&Expires=1563204444&Signature=vndryCsifGa%2FFj%2F%2BrU4iUieplHk%3D', 0, NULL, NULL, 17552262, NULL, '{\"extra\": {\"data\": {\"id\": 5613589, \"msg\": \"可以下载\", \"uid\": \"27030711\", \"url\": \"https://proxy-vip.588ku.com/back_psd/05/61/35/588ku_3aa904b291ff5ee9c8ce2482c355fa11.rar?st=PXfoX8J54-GQ4Ht_ZkUxxg&e=1562149959\", \"type\": 2, \"isvip\": true, \"status\": 0, \"keyword\": null}}}', '2019-07-15 15:22:23', '2019-07-15 15:22:23');
INSERT INTO `material_file_attachments` VALUES (57, 7, 'JPG', 'http://download.588ku.com/Templet_origin_pic/04/93/73/39156c7ebc23f7f345b9326045f5b74d.jpg?_upd=true&key=d1116be2d4a9a772ca591c2db443666d&t=1563285517', 'http://sonorous.oss-cn-hangzhou.aliyuncs.com/588ku/10/Templet_origin_pic/04/93/73/6yGnA_39156c7ebc23f7f345b9326045f5b74d.jpg?OSSAccessKeyId=LTAI2oF3bE0PwTZS&Expires=1563286390&Signature=rjz7sR0f2hfO%2BbqyjRylVU3LLZ8%3D', 0, NULL, NULL, 8281330, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"http://download.588ku.com/Templet_origin_pic/04/93/73/39156c7ebc23f7f345b9326045f5b74d.jpg?_upd=true&key=d1116be2d4a9a772ca591c2db443666d&t=1563285517\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-16 14:08:10', '2019-07-16 14:08:10');
INSERT INTO `material_file_attachments` VALUES (58, 7, 'PSD', 'https://proxy-vip.588ku.com/back_psd/04/93/73/588ku_c6c722767d94e828ec7a692718161dac.rar?st=5IxcZmjjzjG34_GY_3srnA&e=1563285817', 'http://sonorous.oss-cn-hangzhou.aliyuncs.com/588ku/5585/back_psd/04/93/73/n5Mw8_588ku_c6c722767d94e828ec7a692718161dac.rar?OSSAccessKeyId=LTAI2oF3bE0PwTZS&Expires=1563286390&Signature=baceZAhnxJ9R4eulMfyA%2BUuqz7k%3D', 0, NULL, NULL, 61867019, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"https://proxy-vip.588ku.com/back_psd/04/93/73/588ku_c6c722767d94e828ec7a692718161dac.rar?st=5IxcZmjjzjG34_GY_3srnA&e=1563285817\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-16 14:08:10', '2019-07-16 14:08:10');
INSERT INTO `material_file_attachments` VALUES (59, 8, 'JPG', 'http://download.588ku.com/Templet_origin_pic/04/93/14/e4973b9675619a22471221c185921ead.jpg?_upd=true&key=420fa1b7c5733af1f2aa2b2c2d9e9dfd&t=1562118614', 'http://sonorous.oss-cn-hangzhou.aliyuncs.com/588ku/10/Templet_origin_pic/04/93/14/DdKwv_e4973b9675619a22471221c185921ead.jpg?OSSAccessKeyId=LTAI2oF3bE0PwTZS&Expires=1563286554&Signature=I0dhiYf3lNmfN22FMWj0%2FOPmHGk%3D', 0, NULL, NULL, 3654767, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"http://download.588ku.com/Templet_origin_pic/04/93/14/e4973b9675619a22471221c185921ead.jpg?_upd=true&key=420fa1b7c5733af1f2aa2b2c2d9e9dfd&t=1562118614\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-16 14:10:54', '2019-07-16 14:10:54');
INSERT INTO `material_file_attachments` VALUES (60, 8, 'PSD', 'https://proxy-vip.588ku.com/back_psd/04/93/14/588ku_400af0db348e337ea27ce2446e60d5fc.zip?st=2Ft7GGBMNMBUM9PzowAVHg&e=1562118914', 'http://sonorous.oss-cn-hangzhou.aliyuncs.com/588ku/5585/back_psd/04/93/14/BdMjl_588ku_400af0db348e337ea27ce2446e60d5fc.zip?OSSAccessKeyId=LTAI2oF3bE0PwTZS&Expires=1563286554&Signature=plNYd%2BFoskkia6peupo6DMuav%2Bc%3D', 0, NULL, NULL, 76332491, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"https://proxy-vip.588ku.com/back_psd/04/93/14/588ku_400af0db348e337ea27ce2446e60d5fc.zip?st=2Ft7GGBMNMBUM9PzowAVHg&e=1562118914\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-16 14:10:54', '2019-07-16 14:10:54');
INSERT INTO `material_file_attachments` VALUES (63, 9, 'JPG', 'http://download.588ku.com/Templet_origin_pic/04/93/14/b19def7dc24b0c5fc3b2d314677895f2.jpg?_upd=true&key=f886432114b9b193a2a7dac507a1e50d&t=1562118589', 'http://sonorous.oss-cn-hangzhou.aliyuncs.com/588ku/10/Templet_origin_pic/04/93/14/G1z8K_b19def7dc24b0c5fc3b2d314677895f2.jpg?OSSAccessKeyId=LTAI2oF3bE0PwTZS&Expires=1563289414&Signature=uwhojbapQ5atWQZgPQsmAvjbRV8%3D', 0, NULL, NULL, 3783944, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"http://download.588ku.com/Templet_origin_pic/04/93/14/b19def7dc24b0c5fc3b2d314677895f2.jpg?_upd=true&key=f886432114b9b193a2a7dac507a1e50d&t=1562118589\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-16 14:58:33', '2019-07-16 14:58:33');
INSERT INTO `material_file_attachments` VALUES (64, 9, 'PSD', 'https://proxy-vip.588ku.com/back_psd/04/93/14/588ku_ca46077e32db85dce6662b8d338a01fe.zip?st=2deRpWbZ9w8BB0feyVfTnA&e=1562118889', 'http://sonorous.oss-cn-hangzhou.aliyuncs.com/588ku/5585/back_psd/04/93/14/vrR2O_588ku_ca46077e32db85dce6662b8d338a01fe.zip?OSSAccessKeyId=LTAI2oF3bE0PwTZS&Expires=1563289414&Signature=rQJpLBr%2FzRM4zv8N8SjxzDhN%2FxE%3D', 0, NULL, NULL, 93561255, NULL, '{\"extra\": {\"data\": {\"msg\": \"可以下载\", \"url\": \"https://proxy-vip.588ku.com/back_psd/04/93/14/588ku_ca46077e32db85dce6662b8d338a01fe.zip?st=2deRpWbZ9w8BB0feyVfTnA&e=1562118889\", \"type\": 3, \"status\": 0, \"keyword\": null}}}', '2019-07-16 14:58:33', '2019-07-16 14:58:33');
INSERT INTO `material_file_attachments` VALUES (65, 10, '', 'https://proxy-vc.58pic.com/58picrar/35/14/24/5d2b4645807b3.zip?uid=578235&st=Nd4uoQ4pMS97xCZ45VMY2Q&e=1563805363&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E5%8E%9F%E5%88%9B%E6%8F%92%E7%94%BB%E5%8D%B0%E8%B1%A1%E5%89%AA%E7%BA%B8%E9%A3%8E%E5%A4%8F%E5%AD%A3%E4%BF%83%E9%94%80%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B735142420.zip', NULL, 0, NULL, NULL, NULL, 'EPS', NULL, '2019-07-22 14:12:44', '2019-07-22 14:12:44');
INSERT INTO `material_file_attachments` VALUES (67, 16, NULL, 'https://proxy-vc.58pic.com/58picrar/32/22/21/5b84a499b823f.zip?uid=552434&st=uj8njIAtP-r98mDUUfMUKw&e=1563806717&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E5%BC%80%E5%AD%A6%E5%AD%A3%E5%AE%A3%E4%BC%A0%E4%BF%83%E9%94%80%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B732222109.zip', 'http://razee.oss-cn-shenzhen.aliyuncs.com/58pic/922ba5a9685172c844bb580b6d0d87da.zip?OSSAccessKeyId=LTAIEoIuxMOfxkpm&Expires=1563813294&Signature=mMFkgnEkBRzusiK7%2Bt900lQGExQ%3D', 1, '58pic/922ba5a9685172c844bb580b6d0d87da.zip', NULL, NULL, NULL, NULL, '2019-07-22 15:34:54', '2019-07-22 14:35:18');
INSERT INTO `material_file_attachments` VALUES (68, 17, NULL, 'https://proxy-vc.58pic.com/58picrar/34/30/51/5ca5b488093f3.zip?uid=774280&st=jLdgsHOyZiDCbaS8qWEytA&e=1563806792&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E5%A4%8F%E6%97%A5%E7%89%B9%E9%A5%AE%E6%B8%85%E5%87%89%E4%B8%80%E5%A4%8F%E6%9E%9C%E6%B1%81%E5%A5%B6%E8%8C%B6%E5%92%96%E5%95%A1%E9%A5%AE%E6%96%99%E4%BF%83%E9%94%80%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B734305137.zip', NULL, 1, '58pic/db10fd74e097ff81b571ac4841715354.zip', NULL, NULL, NULL, NULL, '2019-07-22 14:49:54', '2019-07-22 14:36:33');
INSERT INTO `material_file_attachments` VALUES (69, 18, NULL, 'https://proxy-vc.58pic.com/58picrar/00/13/94/5ad96f37c7b99.zip?uid=1303097&st=zHCCgh9EchhqsI3ox2qqtA&e=1563807589&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E6%96%B0%E9%B2%9C%E7%89%9B%E5%A5%B6%E4%BC%98%E6%83%A0%E8%B4%AD%E6%B5%B7%E6%8A%A5%E8%AE%BE%E8%AE%A1_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B734228391.zip', NULL, 1, '58pic/341dc00d640d5988f2a7cf7ae72842ef.zip', NULL, NULL, NULL, NULL, '2019-07-22 14:49:54', '2019-07-22 14:49:50');
INSERT INTO `material_file_attachments` VALUES (70, 19, NULL, 'https://proxy-vc.58pic.com/58picrar/28/76/19/5b481046ca4f7.zip?uid=2658771&st=1Ujvd1Wuo1sS5zgKYHe-Hg&e=1563807775&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E6%90%9E%E4%BA%8B%E6%83%85%E4%BF%83%E9%94%80%E6%B5%B7%E6%8A%A5%E5%B1%95%E6%9D%BF_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B728761925.zip', NULL, 1, '58pic/6827c8e424c6fe95653a6eb46984ca2f.zip', NULL, NULL, NULL, NULL, '2019-07-22 14:52:58', '2019-07-22 14:52:56');
INSERT INTO `material_file_attachments` VALUES (71, 20, NULL, 'https://proxy-vc.58pic.com/58picrar/00/50/85/5b87a9e987aeb.zip?uid=3068631&st=SoeFbCKcKDCVjqt5u2UQwg&e=1563808274&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E6%94%BE%E8%82%86%E8%B4%AD%E5%AD%A3%E6%9C%AB%E4%BF%83%E9%94%80%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B734286032.zip', NULL, 1, '58pic/4a0224312480b0cdd85b46200c39b698.zip', NULL, NULL, NULL, NULL, '2019-07-22 15:01:17', '2019-07-22 15:01:15');
INSERT INTO `material_file_attachments` VALUES (72, 21, NULL, 'https://proxy-vc.58pic.com/58picrar/00/21/16/5b265de406094.zip?uid=1732351&st=so6v7CAnKkryV7hBerlexA&e=1563808548&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E6%90%9E%E4%BA%8B%E6%83%85%E4%BF%83%E9%94%80%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B734301343.zip', NULL, 1, '58pic/0e09ca11820d1084f4961cb8d1f9a6a1.zip', NULL, NULL, NULL, NULL, '2019-07-22 15:05:52', '2019-07-22 15:05:49');
INSERT INTO `material_file_attachments` VALUES (73, 22, NULL, 'https://proxy-vc.58pic.com/58picrar/01/16/72/b_5cb8335e4bcd3.zip?uid=3028720&st=VCSaqkOU459IANCeAyNpfA&e=1563809220&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E5%8C%96%E5%A6%86%E5%93%81%E6%B5%B7%E6%8A%A5+%E9%9D%A2%E8%86%9C%E6%B5%B7%E6%8A%A5+%E7%9B%B4%E9%80%9A%E8%BD%A6+%E9%92%BB%E5%B1%95_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B725931777.zip', NULL, 1, '58pic/cf7eda83b1c2cb2b2ac090e7df72363a.zip', NULL, NULL, NULL, NULL, '2019-07-22 15:27:23', '2019-07-22 15:17:01');
INSERT INTO `material_file_attachments` VALUES (74, 23, NULL, 'https://proxy-vc.58pic.com/58picrar/28/79/58/5b5310e2afaa2.zip?uid=2842867&st=LuXorxR6J03ld_T07uBqrA&e=1563810213&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E6%B8%85%E5%87%89%E4%B8%80%E5%A4%8F%E5%A4%8F%E6%97%A5%E9%A5%AE%E5%93%81%E4%BF%83%E9%94%80%E6%B5%B7%E6%8A%A5%E8%AE%BE%E8%AE%A1_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B728795887.zip', NULL, 1, '58pic/fc63d2edba799e53bd288e5f3b5f5259.zip', NULL, NULL, NULL, NULL, '2019-07-22 15:34:15', '2019-07-22 15:33:34');
INSERT INTO `material_file_attachments` VALUES (75, 24, NULL, 'https://proxy-vc.58pic.com/58picrar/01/01/15/a_5c7cc25373450.zip?uid=695233&st=UjcyruOyrXYkcFmhREw36A&e=1563810497&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E5%8D%A1%E9%80%9A%E5%B0%91%E5%84%BF%E5%85%B4%E8%B6%A3%E7%BB%98%E7%94%BB%E5%9F%B9%E8%AE%AD%E7%8F%AD%E6%8B%9B%E7%94%9F%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B734417551.zip', 'http://razee.oss-cn-shenzhen.aliyuncs.com/58pic/67a958069cb473cca5bb7e7bfe7ea275.zip?OSSAccessKeyId=LTAIEoIuxMOfxkpm&Expires=1563813569&Signature=Z4OoQ6wQdAEUOx4TkHz7Lt7PtDQ%3D', 1, '58pic/67a958069cb473cca5bb7e7bfe7ea275.zip', NULL, NULL, NULL, NULL, '2019-07-22 15:39:29', '2019-07-22 15:38:18');
INSERT INTO `material_file_attachments` VALUES (76, 25, NULL, 'https://proxy-vc.58pic.com/58picrar/00/13/79/5ad8132123ae7.zip?uid=541083&st=K37YuFGmeKJPEVWWeAC5HQ&e=1563810741&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E9%9F%A9%E5%BC%8F%E6%B0%B4%E5%85%89%E9%92%88%E6%95%B4%E5%BD%A2%E7%BE%8E%E5%AE%B9%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B734227368.zip', NULL, 1, '58pic/c18d41acbbb3652ee09c53dbc36545cd.zip', NULL, NULL, NULL, NULL, '2019-07-22 15:48:21', '2019-07-22 15:42:27');
INSERT INTO `material_file_attachments` VALUES (77, 26, NULL, 'https://proxy-vc.58pic.com/58picrar/28/78/18/5b4f03fb14ac2.zip?uid=673202&st=-WcJ4fta9JkQQFFK36G58g&e=1563810769&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E7%BA%A2%E8%89%B2%E6%B5%AA%E6%BC%AB%E7%88%B1%E5%BF%83%E6%83%85%E4%BA%BA%E8%8A%82%E4%B8%83%E5%A4%95%E4%BF%83%E9%94%80%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B728781862.zip', NULL, 1, '58pic/46aba843825edc6c686c8c14e422acad.zip', NULL, NULL, NULL, NULL, '2019-07-22 15:49:04', '2019-07-22 15:42:50');
INSERT INTO `material_file_attachments` VALUES (78, 27, NULL, 'https://proxy-vc.58pic.com/58picrar/35/03/75/5d0b30c29e1fd.zip?uid=1147157&st=F_btHjKPZ6vDA4Wj7EOS8A&e=1563810805&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E5%A4%A7%E6%9A%91%E4%BA%8C%E5%8D%81%E5%9B%9B%E8%8A%82%E6%B0%94%E6%9A%91%E5%81%87%E8%8D%B7%E8%8A%B1%E5%A4%8F%E5%AD%A3%E8%8E%B2%E8%8A%B1%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B735037569.zip', NULL, 0, NULL, NULL, NULL, NULL, NULL, '2019-07-22 15:43:26', '2019-07-22 15:43:26');
INSERT INTO `material_file_attachments` VALUES (79, 28, NULL, 'https://proxy-vc.58pic.com/58picrar/33/41/54/5c322cee53230.zip?uid=3020820&st=thgGyI2nSh1fKzk-22lH6w&e=1563810847&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E7%AE%80%E7%BA%A6%E5%85%85%E5%80%BC%E9%80%81%E7%A4%BC%E5%A4%A7%E6%B4%BE%E9%80%81%E4%BC%9A%E5%91%98%E5%85%85%E5%80%BC%E4%BF%83%E9%94%80%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B733415436.zip', NULL, 1, '58pic/b8a96a4343d5058e0829629a3142b7bd.zip', NULL, NULL, NULL, NULL, '2019-07-22 15:50:02', '2019-07-22 15:44:08');
INSERT INTO `material_file_attachments` VALUES (93, 42, NULL, 'https://proxy-vc.58pic.com/58picrar/28/85/98/5d24003fc58d2.zip?uid=2254487&st=gtd_htMOCrxZhgLFy36PjA&e=1563885646&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E7%BA%A2%E8%89%B2%E5%A4%A7%E6%B0%94%E7%AE%80%E7%BA%A6%E6%B5%AA%E6%BC%AB%E4%B8%83%E5%A4%95%E4%B8%AD%E5%9B%BD%E6%83%85%E4%BA%BA%E8%8A%82_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B728859891.zip', NULL, 1, '58pic/fbd23b923527db118cda4e9fd1209a66.zip', NULL, NULL, NULL, NULL, '2019-07-23 12:31:35', '2019-07-23 12:30:47');
INSERT INTO `material_file_attachments` VALUES (94, 43, NULL, 'https://proxy-vc.58pic.com/58picrar/28/87/43/5b6b1872d9df7.zip?uid=2251642&st=99P-DRFvkeEd3IrJqhWN6A&e=1563885768&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E4%B8%83%E5%A4%95%E8%8A%82%E4%BF%83%E9%94%80%E6%B5%B7%E6%8A%A5%E8%AE%BE%E8%AE%A1_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B728874317.zip', NULL, 1, '58pic/432dec1e772f076ee96f8a87c5b645cb.zip', NULL, NULL, NULL, NULL, '2019-07-23 12:33:42', '2019-07-23 12:32:49');
INSERT INTO `material_file_attachments` VALUES (97, 46, NULL, 'https://proxy-vc.58pic.com/58picrar/00/27/86/5b4c8a246ed82.zip?uid=2269790&st=yBKuNrkjuKBW323q1glO2g&e=1563886135&n=%E5%8D%83%E5%9B%BE%E7%BD%91_24%E8%8A%82%E6%B0%94%E4%B9%8B%E5%A4%A7%E6%9A%91%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B734231885.zip', NULL, 1, '58pic/ffda287d4b429310cbaf9e7916dc2439.zip', NULL, NULL, NULL, NULL, '2019-07-23 12:39:37', '2019-07-23 12:38:56');
INSERT INTO `material_file_attachments` VALUES (98, 47, NULL, 'https://proxy-vc.58pic.com/58picrar/28/83/90/5b60294d54a29.zip?uid=2251595&st=aV7BHxMf-eYJKyxfsIII4w&e=1563886235&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E6%B5%AA%E6%BC%AB%E4%B8%83%E5%A4%95%E7%B2%89%E8%89%B2%E7%AB%8B%E4%BD%93%E5%89%AA%E7%BA%B8%E7%88%B1%E5%BF%83%E7%83%AD%E6%B0%94%E7%90%83%E6%83%85%E4%BA%BA%E8%8A%82%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B728839024.zip', NULL, 1, '58pic/f5805b7d17f9985ced722b7a573354df.zip', NULL, NULL, NULL, NULL, '2019-07-23 12:41:35', '2019-07-23 12:40:36');
INSERT INTO `material_file_attachments` VALUES (99, 48, NULL, 'https://proxy-vc.58pic.com/58picrar/28/81/71/5b5982c6257b8.zip?uid=2271423&st=7epbzdHFZx3MYz6JfQfzkw&e=1563886347&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E7%B2%89%E8%89%B2%E6%B8%85%E6%96%B0%E6%B5%AA%E6%BC%AB%E4%B8%83%E5%A4%95%E7%88%B1%E8%A6%81%E6%9C%89%E7%A4%BC%E6%83%85%E4%BA%BA%E8%8A%82%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B728817128.zip', NULL, 1, '58pic/4825e580c1a85b5a3c8369a1ead38b86.zip', NULL, NULL, NULL, NULL, '2019-07-23 12:42:58', '2019-07-23 12:42:28');
INSERT INTO `material_file_attachments` VALUES (100, 49, NULL, 'https://proxy-vc.58pic.com/58picrar/28/86/93/5b69b9cf168e9.zip?uid=2255370&st=Laa5DfkKRuAZav90MxxcqA&e=1563886376&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E5%B0%8F%E6%B8%85%E6%96%B0%E4%B8%83%E5%A4%95%E8%8A%82%E6%97%A5%E4%BF%83%E9%94%80%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B728869391.zip', 'http://razee.oss-cn-shenzhen.aliyuncs.com/58pic/99ed92b05097f44c172639a3767f9733.zip?OSSAccessKeyId=LTAIEoIuxMOfxkpm&Expires=1563891194&Signature=taoLLUJJE3BU7s4mi6QVyQoFnfQ%3D', 1, '58pic/99ed92b05097f44c172639a3767f9733.zip', NULL, NULL, NULL, NULL, '2019-07-23 13:13:14', '2019-07-23 12:42:57');
INSERT INTO `material_file_attachments` VALUES (101, 50, NULL, 'https://proxy-vc.58pic.com/58picrar/00/97/54/a_5c4e6726afd03.zip?uid=2251325&st=z3bsdxCNOIXMa3DWQ0l_RA&e=1563886399&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E5%8D%A1%E9%80%9A%E9%A3%8E%E5%AE%9D%E5%AE%9D%E7%99%BE%E6%97%A5%E5%AE%B4%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B734419994.zip', NULL, 1, '58pic/dafed573f79897a79355b4a08501267d.zip', NULL, NULL, NULL, NULL, '2019-07-23 12:43:27', '2019-07-23 12:43:20');
INSERT INTO `material_file_attachments` VALUES (102, 51, NULL, 'https://proxy-tc.58pic.com/58picrar/35/17/28/5d3697e27ce39.zip?uid=1704334&st=yOWRGrfUfsQkTWPhZsY7Nw&e=1564060048&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E5%8E%9F%E5%88%9B%E6%89%8B%E7%BB%98%E8%BD%BB%E9%A3%9F%E6%B2%99%E6%8B%89%E7%BE%8E%E9%A3%9F%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B735172864.zip', NULL, 0, NULL, NULL, NULL, NULL, NULL, '2019-07-25 12:57:31', '2019-07-25 12:57:31');
INSERT INTO `material_file_attachments` VALUES (104, 53, NULL, 'https://proxy-vc.58pic.com/58picrar/35/17/26/5d368521bff4f.zip?uid=2521554&st=JbxUZyOdoDL_YgrckLkuBg&e=1564060836&n=%E5%8D%83%E5%9B%BE%E7%BD%91_%E5%8E%9F%E5%88%9B%E6%89%8B%E7%BB%98%E6%B8%85%E6%96%B0%E7%94%9C%E7%BE%8E%E5%A9%9A%E7%A4%BC%E6%8D%A7%E8%8A%B1%E5%AE%9A%E5%88%B6%E6%B5%B7%E6%8A%A5_%E5%9B%BE%E7%89%87%E7%BC%96%E5%8F%B735172603.zip', NULL, 0, NULL, NULL, NULL, NULL, NULL, '2019-07-25 13:10:37', '2019-07-25 13:10:37');

-- ----------------------------
-- Table structure for material_files
-- ----------------------------
DROP TABLE IF EXISTS `material_files`;
CREATE TABLE `material_files`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `material_id` int(10) UNSIGNED NOT NULL,
  `channel_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '文件名称',
  `item_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '编号',
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '下载页面的URL',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '0失效  1正常',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `material_files_material_id_foreign`(`material_id`) USING BTREE,
  CONSTRAINT `material_files_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 58 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of material_files
-- ----------------------------
INSERT INTO `material_files` VALUES (1, 1, 2, '夏季促销渐变热带植物ins风格清新海报模板下载_千库网(图片id4973658)', '4973658', 'https://588ku.com/moban/4973658.html', 1, '2019-07-10 15:16:09', '2019-07-10 15:16:09');
INSERT INTO `material_files` VALUES (2, 1, 2, '剪纸风清新暑假班招生海报模板下载_千库网(图片id4944928)', '4944928', 'https://588ku.com/moban/4944928.html', 1, '2019-07-12 12:50:35', '2019-07-12 12:50:39');
INSERT INTO `material_files` VALUES (3, 1, 2, '可爱黑板字教育培训班招生海报模板下载_千库网(图片id4944996)', '4944996', 'https://588ku.com/moban/4944996.html', 1, '2019-07-12 12:54:03', '2019-07-12 12:54:03');
INSERT INTO `material_files` VALUES (4, 1, 2, '培训班黄色波普风滑板少年滑板培训暑期招生海报模板下载_千库网(图片id4945185)', '4945185', 'https://588ku.com/moban/4945185.html', 1, '2019-07-12 12:55:59', '2019-07-12 12:55:59');
INSERT INTO `material_files` VALUES (5, 1, 2, '夏季盛惠促销海报模板下载_千库网(图片id4938245)', '4938245', 'https://588ku.com/moban/4938245.html', 1, '2019-07-13 08:37:20', '2019-07-13 08:37:24');
INSERT INTO `material_files` VALUES (6, 1, 2, '卡通教育培训海报背景图片免费下载_广告背景/psd_千库网(图片编号5613589)', '5613589', 'https://588ku.com/ycbeijing/5613589.html', 1, '2019-07-15 15:22:09', '2019-07-15 15:22:23');
INSERT INTO `material_files` VALUES (7, 1, 2, '网立体旋涡邂逅夏天梦幻七彩海报模板下载_千库网(图片id4937358)', '4937358', 'https://588ku.com/moban/4937358.html', 1, '2019-07-16 13:53:41', '2019-07-16 14:08:10');
INSERT INTO `material_files` VALUES (8, 1, 2, '创意中国风格局企业文化海报模板下载_千库网(图片id4931405)', '4931405', 'https://588ku.com/moban/4931405.html', 1, '2019-07-16 14:10:54', '2019-07-16 14:10:54');
INSERT INTO `material_files` VALUES (9, 1, 2, '创意中国风团队企业文化海报模板下载_千库网(图片id4931406)', '4931406', 'https://588ku.com/moban/4931406.html', 1, '2019-07-16 14:58:29', '2019-07-16 14:58:33');
INSERT INTO `material_files` VALUES (10, 2, 3, '原创插画印象剪纸风夏季促销海报', '35142420', 'https://www.58pic.com/newpic/35142420.html', 1, '2019-07-22 14:12:44', '2019-07-22 14:12:44');
INSERT INTO `material_files` VALUES (16, 2, 3, '开学季宣传促销海报', '32222109', 'https://www.58pic.com/newpic/32222109.html', 1, '2019-07-22 14:35:18', '2019-07-22 14:35:18');
INSERT INTO `material_files` VALUES (17, 2, 3, '夏日特饮清凉一夏果汁奶茶咖啡饮料促销海报', '34305137', 'https://www.58pic.com/newpic/34305137.html', 1, '2019-07-22 14:36:33', '2019-07-22 14:36:33');
INSERT INTO `material_files` VALUES (18, 2, 3, '新鲜牛奶优惠购海报设计', '34228391', 'https://www.58pic.com/newpic/34228391.html', 1, '2019-07-22 14:49:50', '2019-07-22 14:49:50');
INSERT INTO `material_files` VALUES (19, 2, 3, '搞事情促销海报展板', '28761925', 'https://www.58pic.com/newpic/28761925.html', 1, '2019-07-22 14:52:56', '2019-07-22 14:52:56');
INSERT INTO `material_files` VALUES (20, 2, 3, '放肆购季末促销海报', '34286032', 'https://www.58pic.com/newpic/34286032.html', 1, '2019-07-22 15:01:15', '2019-07-22 15:01:15');
INSERT INTO `material_files` VALUES (21, 2, 3, '搞事情促销海报', '34301343', 'https://www.58pic.com/newpic/34301343.html', 1, '2019-07-22 15:05:49', '2019-07-22 15:05:49');
INSERT INTO `material_files` VALUES (22, 2, 3, '化妆品海报 面膜海报 直通车 钻展', '25931777', 'https://www.58pic.com/newpic/25931777.html', 1, '2019-07-22 15:17:01', '2019-07-22 15:17:01');
INSERT INTO `material_files` VALUES (23, 2, 3, '清凉一夏夏日饮品促销海报设计', '28795887', 'https://www.58pic.com/newpic/28795887.html', 1, '2019-07-22 15:33:34', '2019-07-22 15:33:34');
INSERT INTO `material_files` VALUES (24, 2, 3, '卡通少儿兴趣绘画培训班招生海报', '34417551', 'https://www.58pic.com/newpic/34417551.html', 1, '2019-07-22 15:38:18', '2019-07-22 15:38:18');
INSERT INTO `material_files` VALUES (25, 2, 3, '韩式水光针整形美容海报', '34227368', 'https://www.58pic.com/newpic/34227368.html', 1, '2019-07-22 15:42:27', '2019-07-22 15:42:27');
INSERT INTO `material_files` VALUES (26, 2, 3, '红色浪漫爱心情人节七夕促销海报', '28781862', 'https://www.58pic.com/newpic/28781862.html', 1, '2019-07-22 15:42:50', '2019-07-22 15:42:50');
INSERT INTO `material_files` VALUES (27, 2, 3, '大暑二十四节气暑假荷花夏季莲花海报', '35037569', 'https://www.58pic.com/newpic/35037569.html', 1, '2019-07-22 15:43:26', '2019-07-22 15:43:26');
INSERT INTO `material_files` VALUES (28, 2, 3, '简约充值送礼大派送会员充值促销海报', '33415436', 'https://www.58pic.com/newpic/33415436.html', 1, '2019-07-22 15:44:08', '2019-07-22 15:44:08');
INSERT INTO `material_files` VALUES (42, 2, 3, '红色大气简约浪漫七夕中国情人节', '28859891', 'https://www.58pic.com/newpic/28859891.html', 1, '2019-07-23 12:30:47', '2019-07-23 12:30:47');
INSERT INTO `material_files` VALUES (43, 2, 3, '七夕节促销海报设计', '28874317', 'https://www.58pic.com/newpic/28874317.html', 1, '2019-07-23 12:32:49', '2019-07-23 12:32:49');
INSERT INTO `material_files` VALUES (46, 2, 3, '24节气之大暑海报', '34231885', 'https://www.58pic.com/newpic/34231885.html', 1, '2019-07-23 12:38:56', '2019-07-23 12:38:56');
INSERT INTO `material_files` VALUES (47, 2, 3, '浪漫七夕粉色立体剪纸爱心热气球情人节海报', '28839024', 'https://www.58pic.com/newpic/28839024.html', 1, '2019-07-23 12:40:36', '2019-07-23 12:40:36');
INSERT INTO `material_files` VALUES (48, 2, 3, '粉色清新浪漫七夕爱要有礼情人节海报', '28817128', 'https://www.58pic.com/newpic/28817128.html', 1, '2019-07-23 12:42:28', '2019-07-23 12:42:28');
INSERT INTO `material_files` VALUES (49, 2, 3, '小清新七夕节日促销海报', '28869391', 'https://www.58pic.com/newpic/28869391.html', 1, '2019-07-23 12:42:57', '2019-07-23 12:42:57');
INSERT INTO `material_files` VALUES (50, 2, 3, '卡通风宝宝百日宴海报', '34419994', 'https://www.58pic.com/newpic/34419994.html', 1, '2019-07-23 12:43:20', '2019-07-23 12:43:20');
INSERT INTO `material_files` VALUES (51, 2, 3, '原创手绘轻食沙拉美食海报', '35172864', 'https://www.58pic.com/newpic/35172864.html', 1, '2019-07-25 12:57:31', '2019-07-25 12:57:31');
INSERT INTO `material_files` VALUES (53, 2, 3, '原创手绘清新甜美婚礼捧花定制海报', '35172603', 'https://www.58pic.com/newpic/35172603.html', 1, '2019-07-25 13:10:37', '2019-07-25 13:10:37');

-- ----------------------------
-- Table structure for material_meals
-- ----------------------------
DROP TABLE IF EXISTS `material_meals`;
CREATE TABLE `material_meals`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for material_prices
-- ----------------------------
DROP TABLE IF EXISTS `material_prices`;
CREATE TABLE `material_prices`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `material_id` int(11) UNSIGNED NOT NULL,
  `price` decimal(10, 2) NOT NULL COMMENT '价格',
  `cycle` int(10) NOT NULL DEFAULT 1 COMMENT '售出周期（单位：天） 0为永久',
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '1正常出售  0下架',
  `unsale_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '下架原因',
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of material_prices
-- ----------------------------
INSERT INTO `material_prices` VALUES (1, '千库网（30天）', 1, 10.00, 30, 1, NULL, 1563288198, 1563288769);

-- ----------------------------
-- Table structure for materials
-- ----------------------------
DROP TABLE IF EXISTS `materials`;
CREATE TABLE `materials`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `domain` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '官网域名',
  `site` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '网站标识',
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'logo',
  `state` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0禁用 1正常 2维护中',
  `state_cause` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '停用原因',
  `instructions` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '下载说明，说明这个网站支持下载哪些',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of materials
-- ----------------------------
INSERT INTO `materials` VALUES (1, '千库网', 'https://588ku.com/', '588ku', NULL, 0, '近期上线', '支持共享、原创、办公(除云简历,字体)', '2019-06-29 05:39:14', '2019-07-16 15:43:09', NULL);
INSERT INTO `materials` VALUES (2, '千图网', 'https://www.58pic.com/', '58pic', NULL, 1, NULL, NULL, '2019-06-29 05:39:40', '2019-07-06 09:41:42', NULL);
INSERT INTO `materials` VALUES (3, '90设计', 'http://90sheji.com/', '90sheji', NULL, 0, '近期上线', NULL, '2019-06-29 05:40:19', '2019-07-16 15:43:18', NULL);
INSERT INTO `materials` VALUES (4, '我图网', 'https://www.ooopic.com/', 'ooopic', NULL, 0, '近期上线', NULL, '2019-06-29 05:40:47', '2019-07-16 15:43:26', NULL);
INSERT INTO `materials` VALUES (5, '觅元素', 'http://www.51yuansu.com/', '51yuansu', NULL, 0, '近期上线', NULL, '2019-06-29 05:41:20', '2019-07-16 15:43:34', NULL);
INSERT INTO `materials` VALUES (6, '包图网', 'https://ibaotu.com/', 'ibaotu', NULL, 0, '近期上线', NULL, '2019-06-29 05:41:43', '2019-07-16 15:46:40', NULL);
INSERT INTO `materials` VALUES (7, '摄图网', 'http://699pic.com/', '699pic', NULL, 0, '近期上线', NULL, '2019-06-29 05:42:10', '2019-07-16 15:46:34', NULL);
INSERT INTO `materials` VALUES (8, '图品汇', 'https://www.88tph.com/', '88tph', NULL, 0, '近期上线', NULL, '2019-06-29 05:42:41', '2019-07-16 15:46:28', NULL);
INSERT INTO `materials` VALUES (9, '全图网', 'http://www.125pic.com/', '125pic', NULL, 0, '近期上线', NULL, '2019-06-29 05:43:44', '2019-07-16 15:46:23', NULL);
INSERT INTO `materials` VALUES (10, '昵图网', 'http://www.nipic.com', 'nipic', NULL, 0, '近期上线', NULL, '2019-07-07 02:12:16', '2019-07-16 15:46:17', NULL);
INSERT INTO `materials` VALUES (11, '六图网', 'https://www.16pic.com', '16pic', NULL, 0, '近期上线', NULL, '2019-07-07 02:13:00', '2019-07-16 15:46:58', NULL);
INSERT INTO `materials` VALUES (12, '觅知网', 'http://www.51miz.com', '51miz', NULL, 0, '近期上线', NULL, '2019-07-07 02:13:34', '2019-07-16 15:47:04', NULL);
INSERT INTO `materials` VALUES (13, '办图网', 'http://www.888ppt.com', '888ppt', NULL, 0, '近期上线', NULL, '2019-07-07 02:13:55', '2019-07-16 15:47:08', NULL);
INSERT INTO `materials` VALUES (14, '花瓣网', 'https://huaban.com', 'huaban', NULL, 0, '近期上线', NULL, '2019-07-07 02:14:48', '2019-07-16 15:47:13', NULL);
INSERT INTO `materials` VALUES (15, '当图网', 'https://www.99ppt.com', '99ppt', NULL, 0, '近期上线', NULL, '2019-07-07 02:15:26', '2019-07-16 15:47:18', NULL);
INSERT INTO `materials` VALUES (16, '图客巴巴', 'http://www.tuke88.com', 'tuke88', NULL, 0, '近期上线', NULL, '2019-07-07 02:17:36', '2019-07-16 15:47:23', NULL);
INSERT INTO `materials` VALUES (17, '图形天下', 'http://www.photophoto.cn/', 'photophoto', NULL, 0, '近期上线', NULL, '2019-07-07 02:19:31', '2019-07-16 15:47:28', NULL);
INSERT INTO `materials` VALUES (18, '515PPT', 'http://www.515ppt.com', '515ppt', NULL, 0, '近期上线', NULL, '2019-07-07 02:20:07', '2019-07-16 15:47:46', NULL);
INSERT INTO `materials` VALUES (19, '熊猫办公', 'https://www.tukuppt.com', 'tukuppt', NULL, 0, '近期上线', NULL, '2019-07-07 02:20:36', '2019-07-16 15:47:38', NULL);
INSERT INTO `materials` VALUES (20, '风云办公', 'http://www.ppt118.com', 'ppt118', NULL, 0, '近期上线', NULL, '2019-07-07 02:20:51', '2019-07-16 15:47:33', NULL);

-- ----------------------------
-- Table structure for meals
-- ----------------------------
DROP TABLE IF EXISTS `meals`;
CREATE TABLE `meals`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '套餐名称',
  `price` decimal(10, 2) NOT NULL COMMENT '套餐价格',
  `type` tinyint(1) NOT NULL COMMENT '0包天，1周，2月，3年，4永久',
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '套餐介绍',
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '套餐表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (2, '2019_06_24_143856_create_admins_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_06_24_151252_create_materials_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_06_24_151446_create_user_download_logs_table', 2);
INSERT INTO `migrations` VALUES (5, '2019_07_10_133906_create_jobs_table', 3);

-- ----------------------------
-- Table structure for notices
-- ----------------------------
DROP TABLE IF EXISTS `notices`;
CREATE TABLE `notices`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sort` int(10) NOT NULL COMMENT '公告排序，数字越小排在越前面',
  `is_popup` tinyint(1) NULL DEFAULT 0 COMMENT '是否弹窗通知',
  `start_time` int(11) NOT NULL COMMENT '开始时间',
  `end_time` int(11) NOT NULL COMMENT '结束时间',
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '公告通知表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` int(11) NOT NULL,
  `order_no` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `total_price` decimal(10, 2) NOT NULL COMMENT '订单总额',
  `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '订单类型，0单网订单 1套餐订单 ',
  `pay_status` tinyint(1) NOT NULL COMMENT '0待支付 1已支付',
  `pay_time` int(11) NOT NULL COMMENT '支付时间',
  `deliver_status` tinyint(1) NOT NULL COMMENT '0未交付订单对应的次数  1已交付',
  `deliver_time` int(11) NOT NULL COMMENT '交货时间',
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pays
-- ----------------------------
DROP TABLE IF EXISTS `pays`;
CREATE TABLE `pays`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '支付名称',
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'logo',
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '支付表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for replace_downloads
-- ----------------------------
DROP TABLE IF EXISTS `replace_downloads`;
CREATE TABLE `replace_downloads`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `replace_id` int(11) UNSIGNED NOT NULL,
  `material_file_id` int(11) NULL DEFAULT 0,
  `email_id` int(11) NULL DEFAULT 0 COMMENT '邮箱id',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '发送的邮箱',
  `pic_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '素材编号',
  `download_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of replace_downloads
-- ----------------------------
INSERT INTO `replace_downloads` VALUES (13, 2, 1, 0, 0, NULL, '35172864', 'https://www.58pic.com/newpic/35172864.html', '原创手绘轻食沙拉美食海报', 1564066147, 1564066147);
INSERT INTO `replace_downloads` VALUES (14, 2, 1, 0, 0, NULL, '35172864', 'https://www.58pic.com/newpic/35172864.html', '原创手绘轻食沙拉美食海报', 1564066539, 1564066539);
INSERT INTO `replace_downloads` VALUES (15, 2, 1, 0, 0, NULL, '35172864', 'https://www.58pic.com/newpic/35172864.html', '原创手绘轻食沙拉美食海报', 1564066598, 1564066598);
INSERT INTO `replace_downloads` VALUES (16, 2, 1, 0, 0, NULL, '35172864', 'https://www.58pic.com/newpic/35172864.html', '原创手绘轻食沙拉美食海报', 1564066794, 1564066794);
INSERT INTO `replace_downloads` VALUES (17, 2, 1, 0, 0, NULL, '35172864', 'https://www.58pic.com/newpic/35172864.html', '原创手绘轻食沙拉美食海报', 1564067285, 1564067285);
INSERT INTO `replace_downloads` VALUES (18, 2, 1, 0, 0, NULL, '35172864', 'https://www.58pic.com/newpic/35172864.html', '原创手绘轻食沙拉美食海报', 1564067562, 1564067562);
INSERT INTO `replace_downloads` VALUES (19, 2, 1, 0, 0, NULL, '35172864', 'https://www.58pic.com/newpic/35172864.html', '原创手绘轻食沙拉美食海报', 1564067644, 1564067644);

-- ----------------------------
-- Table structure for replaces
-- ----------------------------
DROP TABLE IF EXISTS `replaces`;
CREATE TABLE `replaces`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sign` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '接收的邮箱',
  `number` int(11) NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of replaces
-- ----------------------------
INSERT INTO `replaces` VALUES (1, '123', '384860859@qq.com', 3, NULL, 1564067644);

-- ----------------------------
-- Table structure for user_download_logs
-- ----------------------------
DROP TABLE IF EXISTS `user_download_logs`;
CREATE TABLE `user_download_logs`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `material_id` int(10) UNSIGNED NOT NULL,
  `material_file_id` int(10) NULL DEFAULT NULL,
  `source_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户提交的下载URL',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_materials
-- ----------------------------
DROP TABLE IF EXISTS `user_materials`;
CREATE TABLE `user_materials`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `material_id` int(10) UNSIGNED NOT NULL,
  `total` int(11) NOT NULL COMMENT '总次数',
  `current` int(11) NOT NULL COMMENT '当前可用次数',
  `everyday` int(11) NULL DEFAULT NULL COMMENT '每日刷新的次数',
  `start_time` int(11) NOT NULL COMMENT '开始时间',
  `end_time` int(11) NOT NULL COMMENT '结束时间，0表示永久',
  `is_daily_reset` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否每天重置当前可用次数 0重置 1每日重置',
  `status` tinyint(1) NULL DEFAULT NULL COMMENT '状态，1正常，0关闭',
  `created_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_materials.user_id`(`user_id`) USING BTREE,
  CONSTRAINT `user_materials.user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_materials
-- ----------------------------
INSERT INTO `user_materials` VALUES (1, 2, 1, 10, 5, NULL, 1562946655, 0, 0, 1, NULL, 1563290432);
INSERT INTO `user_materials` VALUES (3, 2, 13, 20, 10, NULL, 1562976000, 1564012800, 1, 1, 1562991798, 1562991798);
INSERT INTO `user_materials` VALUES (4, 2, 2, 20, 10, NULL, 1562976000, 0, 1, 1, 1562993078, 1562993078);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 1 COMMENT '0冻结 1正常',
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (2, '123456', '$2y$10$QijyAE/jvYVDKNqQns2OYOUq1DDRBU/YgH3yasL/SeRWW.CAJRm/S', NULL, NULL, 1, 'x62qBHqHkGRccIfBB3S0tNigWOf36NM7RIjnL3H77RccjGCSho6Atufms5cK', '2019-07-06 04:18:44', '2019-07-06 04:18:44');

SET FOREIGN_KEY_CHECKS = 1;
