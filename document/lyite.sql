/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : lyite

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 14/07/2019 16:05:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ly_config
-- ----------------------------
DROP TABLE IF EXISTS `ly_config`;
CREATE TABLE `ly_config`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '键',
  `value` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '值',
  `remark` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注',
  `deleted_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `key`(`key`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '系统配置数据表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ly_file
-- ----------------------------
DROP TABLE IF EXISTS `ly_file`;
CREATE TABLE `ly_file`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '文件名',
  `ext` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '文件后缀',
  `size` int(11) NULL DEFAULT NULL COMMENT '文件大小（byte）',
  `save_path` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '文件地址',
  `deleted_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '文件表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ly_file
-- ----------------------------
INSERT INTO `ly_file` VALUES (1, 'Ly.jpg', 'jpg', 9097, 'http://file.lyite.com/20190309_1552110236_5c83529c0c009.jpg', NULL, 1552110236, 1552110236);

-- ----------------------------
-- Table structure for ly_font_icon
-- ----------------------------
DROP TABLE IF EXISTS `ly_font_icon`;
CREATE TABLE `ly_font_icon`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '中文名',
  `code` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '代码',
  `font_class` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字体样式类',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `deleted_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 141 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'layui字体图标' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ly_font_icon
-- ----------------------------
INSERT INTO `ly_font_icon` VALUES (1, '半星', '&#xe6c9;', 'layui-icon-rate-half', 110, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (2, '星星-空心', '&#xe67b;', 'layui-icon-rate', 2, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (3, '星星-实心', '&#xe67a;', 'layui-icon-rate-solid', 3, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (4, '手机', '&#xe678;', 'layui-icon-cellphone', 4, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (5, '验证码', '&#xe679;', 'layui-icon-vercode', 5, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (6, '微信', '&#xe677;', 'layui-icon-login-wechat', 6, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (7, 'QQ', '&#xe676;', 'layui-icon-login-qq', 7, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (8, '微博', '&#xe675;', 'layui-icon-login-weibo', 8, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (9, '密码', '&#xe673;', 'layui-icon-password', 9, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (10, '用户名', '&#xe66f;', 'layui-icon-username', 10, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (11, '刷新-粗', '&#xe9aa;', 'layui-icon-refresh-3', 11, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (12, '授权', '&#xe672;', 'layui-icon-auz', 12, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (13, '左向右伸缩菜单', '&#xe66b;', 'layui-icon-spread-left', 13, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (14, '右向左伸缩菜单', '&#xe668;', 'layui-icon-shrink-right', 14, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (15, '雪花', '&#xe6b1;', 'layui-icon-snowflake', 15, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (16, '提示说明', '&#xe702;', 'layui-icon-tips', 16, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (17, '便签', '&#xe66e;', 'layui-icon-note', 17, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (18, '主页', '&#xe68e;', 'layui-icon-home', 18, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (19, '高级', '&#xe674;', 'layui-icon-senior', 19, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (20, '刷新', '&#xe669;', 'layui-icon-refresh', 20, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (21, '刷新', '&#xe666;', 'layui-icon-refresh-1', 21, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (22, '旗帜', '&#xe66c;', 'layui-icon-flag', 22, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (23, '主题', '&#xe66a;', 'layui-icon-theme', 23, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (24, '消息-通知', '&#xe667;', 'layui-icon-notice', 24, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (25, '网站', '&#xe7ae;', 'layui-icon-website', 25, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (26, '控制台', '&#xe665;', 'layui-icon-console', 26, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (27, '表情-惊讶', '&#xe664;', 'layui-icon-face-surprised', 27, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (28, '设置-空心', '&#xe716;', 'layui-icon-set', 28, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (29, '模板', '&#xe656;', 'layui-icon-template-1', 29, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (30, '应用', '&#xe653;', 'layui-icon-app', 30, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (31, '模板', '&#xe663;', 'layui-icon-template', 31, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (32, '赞', '&#xe6c6;', 'layui-icon-praise', 32, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (33, '踩', '&#xe6c5;', 'layui-icon-tread', 33, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (34, '男', '&#xe662;', 'layui-icon-male', 34, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (35, '女', '&#xe661;', 'layui-icon-female', 35, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (36, '相机-空心', '&#xe660;', 'layui-icon-camera', 36, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (37, '相机-实心', '&#xe65d;', 'layui-icon-camera-fill', 37, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (38, '菜单-水平', '&#xe65f;', 'layui-icon-more', 38, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (39, '菜单-垂直', '&#xe671;', 'layui-icon-more-vertical', 39, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (40, '金额-人民币', '&#xe65e;', 'layui-icon-rmb', 40, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (41, '金额-美元', '&#xe659;', 'layui-icon-dollar', 41, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (42, '钻石-等级', '&#xe735;', 'layui-icon-diamond', 42, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (43, '火', '&#xe756;', 'layui-icon-fire', 43, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (44, '返回', '&#xe65c;', 'layui-icon-return', 44, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (45, '位置-地图', '&#xe715;', 'layui-icon-location', 45, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (46, '办公-阅读', '&#xe705;', 'layui-icon-read', 46, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (47, '调查', '&#xe6b2;', 'layui-icon-survey', 47, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (48, '表情-微笑', '&#xe6af;', 'layui-icon-face-smile', 48, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (49, '表情-哭泣', '&#xe69c;', 'layui-icon-face-cry', 49, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (50, '购物车', '&#xe698;', 'layui-icon-cart-simple', 50, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (51, '购物车', '&#xe657;', 'layui-icon-cart', 51, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (52, '下一页', '&#xe65b;', 'layui-icon-next', 52, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (53, '上一页', '&#xe65a;', 'layui-icon-prev', 53, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (54, '上传-空心-拖拽', '&#xe681;', 'layui-icon-upload-drag', 54, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (55, '上传-实心', '&#xe67c;', 'layui-icon-upload', 55, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (56, '下载-圆圈', '&#xe601;', 'layui-icon-download-circle', 56, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (57, '组件', '&#xe857;', 'layui-icon-component', 57, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (58, '文件-粗', '&#xe655;', 'layui-icon-file-b', 58, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (59, '用户', '&#xe770;', 'layui-icon-user', 59, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (60, '发现-实心', '&#xe670;', 'layui-icon-find-fill', 60, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (61, 'loading', '&#xe63d;', 'layui-icon-loading', 61, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (62, 'loading', '&#xe63e;', 'layui-icon-loading-1', 62, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (63, '添加', '&#xe654;', 'layui-icon-add-1', 63, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (64, '播放', '&#xe652;', 'layui-icon-play', 64, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (65, '暂停', '&#xe651;', 'layui-icon-pause', 65, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (66, '音频-耳机', '&#xe6fc;', 'layui-icon-headset', 66, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (67, '视频', '&#xe6ed;', 'layui-icon-video', 67, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (68, '语音-声音', '&#xe688;', 'layui-icon-voice', 68, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (69, '消息-通知-喇叭', '&#xe645;', 'layui-icon-speaker', 69, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (70, '删除线', '&#xe64f;', 'layui-icon-fonts-del', 70, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (71, '代码', '&#xe64e;', 'layui-icon-fonts-code', 71, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (72, 'HTML', '&#xe64b;', 'layui-icon-fonts-html', 72, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (73, '字体加粗', '&#xe62b;', 'layui-icon-fonts-strong', 73, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (74, '删除链接', '&#xe64d;', 'layui-icon-unlink', 74, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (75, '图片', '&#xe64a;', 'layui-icon-picture', 75, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (76, '链接', '&#xe64c;', 'layui-icon-link', 76, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (77, '表情-笑-粗', '&#xe650;', 'layui-icon-face-smile-b', 77, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (78, '左对齐', '&#xe649;', 'layui-icon-align-left', 78, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (79, '右对齐', '&#xe648;', 'layui-icon-align-right', 79, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (80, '居中对齐', '&#xe647;', 'layui-icon-align-center', 80, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (81, '字体-下划线', '&#xe646;', 'layui-icon-fonts-u', 81, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (82, '字体-斜体', '&#xe644;', 'layui-icon-fonts-i', 82, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (83, 'Tabs 选项卡', '&#xe62a;', 'layui-icon-tabs', 83, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (84, '单选框-选中', '&#xe643;', 'layui-icon-radio', 84, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (85, '单选框-候选', '&#xe63f;', 'layui-icon-circle', 85, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (86, '编辑', '&#xe642;', 'layui-icon-edit', 86, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (87, '分享', '&#xe641;', 'layui-icon-share', 87, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (88, '删除', '&#xe640;', 'layui-icon-delete', 88, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (89, '表单', '&#xe63c;', 'layui-icon-form', 89, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (90, '手机-细体', '&#xe63b;', 'layui-icon-cellphone-fine', 90, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (91, '聊天 对话 沟通', '&#xe63a;', 'layui-icon-dialogue', 91, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (92, '文字格式化', '&#xe639;', 'layui-icon-fonts-clear', 92, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (93, '窗口', '&#xe638;', 'layui-icon-layer', 93, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (94, '日期', '&#xe637;', 'layui-icon-date', 94, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (95, '水 下雨', '&#xe636;', 'layui-icon-water', 95, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (96, '代码-圆圈', '&#xe635;', 'layui-icon-code-circle', 96, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (97, '轮播组图', '&#xe6b1;', 'layui-icon-carousel', 97, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (98, '翻页', '&#xe633;', 'layui-icon-prev-circle', 98, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (99, '布局', '&#xe632;', 'layui-icon-layouts', 99, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (100, '工具', '&#xe631;', 'layui-icon-util', 100, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (101, '选择模板', '&#xe630;', 'layui-icon-templeate-1', 101, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (102, '上传-圆圈', '&#xe62f;', 'layui-icon-upload-circle', 102, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (103, '树', '&#xe62e;', 'layui-icon-tree', 103, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (104, '表格', '&#xe62d;', 'layui-icon-table', 104, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (105, '图表', '&#xe62c;', 'layui-icon-chart', 105, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (106, '图标 报表 屏幕', '&#xe629;', 'layui-icon-chart-screen', 106, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (107, '引擎', '&#xe628;', 'layui-icon-engine', 107, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (108, '下三角', '&#xe625;', 'layui-icon-triangle-d', 108, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (109, '右三角', '&#xe623;', 'layui-icon-triangle-r', 109, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (110, '文件', '&#xe621;', 'layui-icon-file', 1, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (111, '设置-小型', '&#xe620;', 'layui-icon-set-sm', 111, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (112, '添加-圆圈', '&#xe61f;', 'layui-icon-add-circle', 112, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (113, '404', '&#xe61c;', 'layui-icon-404', 113, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (114, '关于', '&#xe60b;', 'layui-icon-about', 114, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (115, '箭头 向上', '&#xe619;', 'layui-icon-up', 115, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (116, '箭头 向下', '&#xe61a;', 'layui-icon-down', 116, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (117, '箭头 向左', '&#xe603;', 'layui-icon-left', 117, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (118, '箭头 向右', '&#xe602;', 'layui-icon-right', 118, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (119, '圆点', '&#xe617;', 'layui-icon-circle-dot', 119, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (120, '搜索', '&#xe615;', 'layui-icon-search', 120, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (121, '设置-实心', '&#xe614;', 'layui-icon-set-fill', 121, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (122, '群组', '&#xe613;', 'layui-icon-group', 122, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (123, '好友', '&#xe612;', 'layui-icon-friends', 123, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (124, '回复 评论 实心', '&#xe611;', 'layui-icon-reply-fill', 124, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (125, '菜单 隐身 实心', '&#xe60f;', 'layui-icon-menu-fill', 125, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (126, '记录', '&#xe60e;', 'layui-icon-log', 126, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (127, '图片-细体', '&#xe60d;', 'layui-icon-picture-fine', 127, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (128, '表情-笑-细体', '&#xe60c;', 'layui-icon-face-smile-fine', 128, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (129, '列表', '&#xe60a;', 'layui-icon-list', 129, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (130, '发布 纸飞机', '&#xe609;', 'layui-icon-release', 130, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (131, '对 OK', '&#xe605;', 'layui-icon-ok', 131, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (132, '帮助', '&#xe607;', 'layui-icon-help', 132, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (133, '客服', '&#xe606;', 'layui-icon-chat', 133, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (134, 'top 置顶', '&#xe604;', 'layui-icon-top', 134, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (135, '收藏-空心', '&#xe600;', 'layui-icon-star', 135, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (136, '收藏-实心', '&#xe658;', 'layui-icon-star-fill', 136, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (137, '关闭-实心', '&#x1007;', 'layui-icon-close-fill', 137, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (138, '关闭-空心', '&#x1006;', 'layui-icon-close', 138, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (139, '正确正确', '&#x1005;', 'layui-icon-ok-circle', 139, NULL, 1543068572, 1543068572);
INSERT INTO `ly_font_icon` VALUES (140, '添加-圆圈-细体', '&#xe608;', 'layui-icon-add-circle-fine', 140, NULL, 1543068572, 1543068572);

-- ----------------------------
-- Table structure for ly_left_nav
-- ----------------------------
DROP TABLE IF EXISTS `ly_left_nav`;
CREATE TABLE `ly_left_nav`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '父级导航栏id',
  `sort` int(11) NOT NULL DEFAULT 1 COMMENT '导航栏排序',
  `target` tinyint(4) NOT NULL DEFAULT 2 COMMENT '新窗口打开：1-是；2-否',
  `status` tinyint(4) NOT NULL DEFAULT 2 COMMENT '使用：1-启用；2-停用',
  `title` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '导航栏名称',
  `icon_id` int(11) NOT NULL DEFAULT 110 COMMENT '导航栏图标id',
  `url` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `deleted_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `parent_id`(`parent_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '后台左侧导航栏表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ly_left_nav
-- ----------------------------
INSERT INTO `ly_left_nav` VALUES (1, 0, 2, 2, 1, '菜单管理', 121, '', NULL, 1557411829, 1542291601);
INSERT INTO `ly_left_nav` VALUES (2, 0, 999, 1, 1, 'layui/Demo', 76, 'http://www.layui.com/demo/', NULL, 1544348728, 1542291601);
INSERT INTO `ly_left_nav` VALUES (3, 1, 1, 2, 1, '菜单列表', 104, 'admin.nav.leftNavTable', NULL, 1542299255, 1542291601);
INSERT INTO `ly_left_nav` VALUES (4, 3, 1, 2, 1, '编辑排序', 86, 'admin.nav.updateSort', NULL, 1542299255, 1542291601);
INSERT INTO `ly_left_nav` VALUES (5, 3, 2, 2, 1, '新窗口打开编辑', 93, 'admin.nav.updateTarget', NULL, 1542898751, 1542898751);
INSERT INTO `ly_left_nav` VALUES (6, 3, 3, 2, 1, '启用/停用操作', 74, 'admin.nav.updateStatus', NULL, 1542899163, 1542899109);
INSERT INTO `ly_left_nav` VALUES (7, 3, 4, 2, 1, '删除数据', 88, 'admin.nav.delDataIds', NULL, 1543503495, 1543503495);
INSERT INTO `ly_left_nav` VALUES (8, 3, 5, 2, 1, '新增/编辑提交', 86, 'admin.nav.leftNavEditSubmit', NULL, 1543503599, 1543503599);
INSERT INTO `ly_left_nav` VALUES (9, 0, 3, 2, 1, '用户管理', 59, '', NULL, 1557411833, 1543504118);
INSERT INTO `ly_left_nav` VALUES (10, 9, 1, 2, 1, '用户组', 122, 'admin.user.groupPage', NULL, 1543849055, 1543849028);
INSERT INTO `ly_left_nav` VALUES (11, 9, 2, 2, 1, '用户', 123, 'admin.user.userPage', NULL, 1543933415, 1543933391);
INSERT INTO `ly_left_nav` VALUES (12, 10, 1, 2, 1, '更新用户组排序', 110, 'admin.user.updateGroupSort', NULL, 1544110150, 1544110150);
INSERT INTO `ly_left_nav` VALUES (13, 10, 2, 2, 1, '删除用户组', 88, 'admin.user.delUserGroupData', NULL, 1544110641, 1544110189);
INSERT INTO `ly_left_nav` VALUES (14, 10, 3, 2, 1, '保存用户组数据', 110, 'admin.user.groupEditSubmit', NULL, 1544110261, 1544110261);
INSERT INTO `ly_left_nav` VALUES (15, 11, 1, 2, 1, '更新用户排序', 110, 'admin.user.updateUserSort', NULL, 1544110397, 1544110397);
INSERT INTO `ly_left_nav` VALUES (16, 11, 2, 2, 1, '更新用户状态', 110, 'admin.user.updateUserStatus', NULL, 1544110415, 1544110415);
INSERT INTO `ly_left_nav` VALUES (17, 11, 3, 2, 1, '删除用户', 110, 'admin.user.delUserData', NULL, 1544110429, 1544110429);
INSERT INTO `ly_left_nav` VALUES (18, 11, 4, 2, 1, '重置用户密码', 110, 'admin.user.resetUserPassword', NULL, 1544110449, 1544110449);
INSERT INTO `ly_left_nav` VALUES (19, 11, 5, 2, 1, '保存用户数据', 110, 'admin.user.userEditSubmit', NULL, 1544110467, 1544110467);
INSERT INTO `ly_left_nav` VALUES (20, 10, 4, 2, 1, '用户组权限分配', 12, 'admin.nav.saveUserGroupPermission', NULL, 1544110687, 1544110687);
INSERT INTO `ly_left_nav` VALUES (21, 9, 3, 2, 1, '用户登录日志', 126, 'admin.user.userLoginLogPage', NULL, 1544449015, 1544449015);
INSERT INTO `ly_left_nav` VALUES (22, 0, 4, 2, 1, '重庆大学生视频大赛', 67, '', NULL, 1557411837, 1545492823);
INSERT INTO `ly_left_nav` VALUES (23, 22, 1, 2, 1, '报名列表', 104, 'admin.videoContest.applyPage', NULL, 1545492852, 1545492852);
INSERT INTO `ly_left_nav` VALUES (24, 23, 1, 2, 1, '删除数据', 88, 'admin.videoContest.delVideoContestData', NULL, 1545492877, 1545492877);
INSERT INTO `ly_left_nav` VALUES (25, 0, 1, 2, 1, '系统设置', 121, '', NULL, 1557335637, 1557335637);
INSERT INTO `ly_left_nav` VALUES (26, 25, 1, 2, 1, '系统配置', 129, 'admin.config.indexPage', NULL, 1557335693, 1557335693);
INSERT INTO `ly_left_nav` VALUES (27, 26, 1, 2, 1, '数据编辑提交', 86, 'admin.config.configEditSubmit', NULL, 1557335732, 1557335732);

-- ----------------------------
-- Table structure for ly_user
-- ----------------------------
DROP TABLE IF EXISTS `ly_user`;
CREATE TABLE `ly_user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `phone` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `password` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '用户状态：1-启用；2-禁用',
  `sort` tinyint(4) NOT NULL DEFAULT 1 COMMENT '排序',
  `g_id` int(11) NOT NULL DEFAULT 0 COMMENT '组id',
  `header_id` int(11) NULL DEFAULT NULL COMMENT '头像id',
  `deleted_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `name`(`name`) USING BTREE,
  INDEX `email`(`email`) USING BTREE,
  INDEX `phone`(`phone`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ly_user_group
-- ----------------------------
DROP TABLE IF EXISTS `ly_user_group`;
CREATE TABLE `ly_user_group`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '组名',
  `sort` tinyint(4) NOT NULL DEFAULT 1 COMMENT '排序',
  `nav_ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '组拥有的权限',
  `deleted_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `name`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户与组关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ly_user_group
-- ----------------------------
INSERT INTO `ly_user_group` VALUES (1, '超级管理组', 1, '1,3,4,5,6,7,8,25,26,27,9,10,12,13,14,20,11,15,16,17,18,19,21,22,23,24,2', NULL, 1557335754, 1543849585);

-- ----------------------------
-- Table structure for ly_user_login_log
-- ----------------------------
DROP TABLE IF EXISTS `ly_user_login_log`;
CREATE TABLE `ly_user_login_log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL COMMENT '用户id',
  `ip` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '登录IP地址',
  `deleted_at` int(11) NULL DEFAULT NULL,
  `updated_at` int(11) NULL DEFAULT NULL,
  `created_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户登录日志' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ly_video_contest_team
-- ----------------------------
DROP TABLE IF EXISTS `ly_video_contest_team`;
CREATE TABLE `ly_video_contest_team`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键（编号）',
  `team_leader` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '队长',
  `tel` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系电话',
  `number` int(11) NULL DEFAULT NULL COMMENT '参赛人数',
  `team` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '团队名',
  `code` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '注册/查询短信验证码',
  `phone` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '注册手机号码',
  `school` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '学校',
  `major` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '专业',
  `deleted_at` int(11) NULL DEFAULT NULL COMMENT '删除时间',
  `updated_at` int(11) NULL DEFAULT NULL COMMENT '更新时间',
  `created_at` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `phone`(`phone`) USING BTREE COMMENT '手机号'
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '重庆大学生视频大赛 - 参赛团队报名表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ly_video_contest_team_member
-- ----------------------------
DROP TABLE IF EXISTS `ly_video_contest_team_member`;
CREATE TABLE `ly_video_contest_team_member`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `vct_id` int(11) NOT NULL DEFAULT 0 COMMENT '关联主键',
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `gender` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '性别',
  `birth` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '出生年月',
  `deleted_at` int(11) NULL DEFAULT NULL COMMENT '删除时间',
  `updated_at` int(11) NULL DEFAULT NULL COMMENT '更新时间',
  `created_at` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `vct_id`(`vct_id`) USING BTREE COMMENT '关联video_contest_team表主键'
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '重庆大学生视频大赛 - 参赛团队成员表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
