# Host: localhost  (Version: 5.5.32)
# Date: 2016-03-31 05:54:58
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Data for table "tb_m_menu"
#

INSERT INTO `tb_m_menu` (`MENU_ID`,`PARENT_MENU_ID`,`MENU_ORDER`,`TYPE`,`MENU_TITLE`,`MENU_ICON`,`URL`,`ACTIVE`,`PRIV_CA`,`CREATED_DT`,`CREATED_BY`,`UPDATED_DT`,`UPDATED_BY`) VALUES ('3010','3',7,2,'Approval Timesheet','fa fa-angle-double-right','c_resource_timesheet/approve_rm_periode',1,5,'2016-03-10 15:50:45','system','2016-03-10 15:50:59',NULL);

INSERT INTO `tb_sys_privilege` (`MENU_ID`,`USER_GROUP_ID`,`ALLOW`,`CREATED_DT`,`CREATED_BY`,`UPDATED_DT`,`UPDATED_BY`) VALUES ('3010',1,1,'2015-04-01 10:48:00','system',NULL,NULL),('3010',2,1,'2015-04-01 10:48:00','system',NULL,NULL);
