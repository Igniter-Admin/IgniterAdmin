-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ia_custom_fields`;
CREATE TABLE `ia_custom_fields` (
  `ia_custom_fields_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rel_crud` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `type` varchar(250) DEFAULT NULL,
  `required` int(11) DEFAULT NULL,
  `options` varchar(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `show_in_grid` int(11) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ia_custom_fields_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `ia_custom_fields_values`;
CREATE TABLE `ia_custom_fields_values` (
  `ia_custom_fields_values_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rel_crud_id` int(11) DEFAULT NULL,
  `cf_id` int(11) DEFAULT NULL,
  `curd` varchar(250) DEFAULT NULL,
  `value` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`ia_custom_fields_values_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `ia_email_templates`;
CREATE TABLE `ia_email_templates` (
  `id` int(121) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `html` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ia_email_templates` (`id`, `module`, `code`, `template_name`, `html`) VALUES
(1,	'forgot_pass',	'forgot_password',	'Forgot password',	'<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\r\n<style media=\"all\" rel=\"stylesheet\" type=\"text/css\">/* Base ------------------------------ */\r\n    *:not(br):not(tr):not(html) {\r\n      font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;\r\n      -webkit-box-sizing: border-box;\r\n      box-sizing: border-box;\r\n    }\r\n    body {\r\n      \r\n    }\r\n    a {\r\n      color: #3869D4;\r\n    }\r\n\r\n\r\n    /* Masthead ----------------------- */\r\n    .email-masthead {\r\n      padding: 25px 0;\r\n      text-align: center;\r\n    }\r\n    .email-masthead_logo {\r\n      max-width: 400px;\r\n      border: 0;\r\n    }\r\n    .email-footer {\r\n      width: 570px;\r\n      margin: 0 auto;\r\n      padding: 0;\r\n      text-align: center;\r\n    }\r\n    .email-footer p {\r\n      color: #AEAEAE;\r\n    }\r\n  \r\n    .content-cell {\r\n      padding: 35px;\r\n    }\r\n    .align-right {\r\n      text-align: right;\r\n    }\r\n\r\n    /* Type ------------------------------ */\r\n    h1 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 19px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h2 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 16px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    h3 {\r\n      margin-top: 0;\r\n      color: #2F3133;\r\n      font-size: 14px;\r\n      font-weight: bold;\r\n      text-align: left;\r\n    }\r\n    p {\r\n      margin-top: 0;\r\n      color: #74787E;\r\n      font-size: 16px;\r\n      line-height: 1.5em;\r\n      text-align: left;\r\n    }\r\n    p.sub {\r\n      font-size: 12px;\r\n    }\r\n    p.center {\r\n      text-align: center;\r\n    }\r\n\r\n    /* Buttons ------------------------------ */\r\n    .button {\r\n      display: inline-block;\r\n      width: 200px;\r\n      background-color: #3869D4;\r\n      border-radius: 3px;\r\n      color: #ffffff;\r\n      font-size: 15px;\r\n      line-height: 45px;\r\n      text-align: center;\r\n      text-decoration: none;\r\n      -webkit-text-size-adjust: none;\r\n      mso-hide: all;\r\n    }\r\n    .button--green {\r\n      background-color: #22BC66;\r\n    }\r\n    .button--red {\r\n      background-color: #dc4d2f;\r\n    }\r\n    .button--blue {\r\n      background-color: #3869D4;\r\n    }\r\n</style>\r\n<table cellpadding=\"0\" cellspacing=\"0\" class=\"email-wrapper\" style=\"\r\n    width: 100%;\r\n    margin: 0;\r\n    padding: 0;\" width=\"100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td align=\"center\">\r\n			<table cellpadding=\"0\" cellspacing=\"0\" class=\"email-content\" style=\"width: 100%;\r\n      margin: 0;\r\n      padding: 0;\" width=\"100%\"><!-- Logo -->\r\n				<tbody><!-- Email Body -->\r\n					<tr>\r\n						<td class=\"email-body\" style=\"width: 100%;\r\n    margin: 0;\r\n    padding: 0;\r\n    border-top: 1px solid #edeef2;\r\n    border-bottom: 1px solid #edeef2;\r\n    background-color: #edeef2;\" width=\"100%\">\r\n						<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"email-body_inner\" style=\" width: 570px;\r\n    margin:  14px auto;\r\n    background: #fff;\r\n    padding: 0;\r\n    border: 1px outset rgba(136, 131, 131, 0.26);\r\n    box-shadow: 0px 6px 38px rgb(0, 0, 0);\r\n       \" width=\"570\"><!-- Body content -->\r\n							<thead style=\"background: #3869d4;\">\r\n								<tr>\r\n									<th>\r\n									<div align=\"center\" style=\"padding: 15px; color: #000;\"><a class=\"email-masthead_name\" href=\"{var_action_url}\" style=\"font-size: 16px;\r\n      font-weight: bold;\r\n      color: #bbbfc3;\r\n      text-decoration: none;\r\n      text-shadow: 0 1px 0 white;\">{var_sender_name}</a></div>\r\n									</th>\r\n								</tr>\r\n							</thead>\r\n							<tbody>\r\n								<tr>\r\n									<td class=\"content-cell\" style=\"padding: 35px;\">\r\n									<h1>Hi {var_user_name},</h1>\r\n\r\n									<p>You recently requested to reset your password for your {var_website_name} account. Click the button below to reset it.</p>\r\n									<!-- Action -->\r\n\r\n									<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" class=\"body-action\" style=\"\r\n      width: 100%;\r\n      margin: 30px auto;\r\n      padding: 0;\r\n      text-align: center;\" width=\"100%\">\r\n										<tbody>\r\n											<tr>\r\n												<td align=\"center\">\r\n												<div><!--[if mso]><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"{{var_action_url}}\" style=\"height:45px;v-text-anchor:middle;width:200px;\" arcsize=\"7%\" stroke=\"f\" fill=\"t\">\r\n                              <v:fill type=\"tile\" color=\"#dc4d2f\" ></v:fill>\r\n                              <w:anchorlock></w:anchorlock>\r\n                              <center style=\"color:#ffffff;font-family:sans-serif;font-size:15px;\">Reset your password</center>\r\n                            </v:roundrect><![endif]--><a class=\"button button--red\" href=\"{var_varification_link}\" style=\"background-color: #dc4d2f;display: inline-block;\r\n      width: 200px;\r\n      background-color: #3869D4;\r\n      border-radius: 3px;\r\n      color: #ffffff;\r\n      font-size: 15px;\r\n      line-height: 45px;\r\n      text-align: center;\r\n      text-decoration: none;\r\n      -webkit-text-size-adjust: none;\r\n      mso-hide: all;\">Reset your password</a></div>\r\n												</td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n\r\n									<p>If you did not request a password reset, please ignore this email or reply to let us know.</p>\r\n\r\n									<p>Thanks,<br />\r\n									{var_sender_name} and the {var_website_name} Team</p>\r\n									<!-- Sub copy -->\r\n\r\n									<table class=\"body-sub\" style=\"margin-top: 25px;\r\n      padding-top: 25px;\r\n      border-top: 1px solid #EDEFF2;\">\r\n										<tbody>\r\n											<tr>\r\n												<td>\r\n												<p class=\"sub\" style=\"font-size:12px;\">If you are having trouble clicking the password reset button, copy and paste the URL below into your web browser.</p>\r\n\r\n												<p class=\"sub\" style=\"font-size:12px;\"><a href=\"{var_varification_link}\">{var_varification_link}</a></p>\r\n												</td>\r\n											</tr>\r\n										</tbody>\r\n									</table>\r\n									</td>\r\n								</tr>\r\n							</tbody>\r\n						</table>\r\n						</td>\r\n					</tr>\r\n				</tbody>\r\n			</table>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n'),
(2,	'users',	'invitation',	'Invitation',	'<p>Hello <strong>{var_user_email}</strong></p>\r\n\r\n<p>Click below link to register&nbsp;<br />\r\n{var_inviation_link}</p>\r\n\r\n<p>Thanks&nbsp;</p>\r\n'),
(3,	'registration',	'registration',	'Registration',	'<p>Hello <strong>{var_user_name}</strong></p>\r\n\r\n<p>Welcome to Notes&nbsp;</p>\r\n\r\n<p>To complete your registration&nbsp;<br />\r\n<br />\r\n<a href=\"{var_varification_link}\">please click here</a></p>\r\n\r\n<p>Thanks&nbsp;</p>\r\n');

DROP TABLE IF EXISTS `ia_menu`;
CREATE TABLE `ia_menu` (
  `id` int(122) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sorting` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ia_menu` (`id`, `menu_name`, `icon`, `slug`, `module_name`, `status`, `parent_id`, `sorting`) VALUES
(1, 'dashboard', 'material-icons,dashboard', 'dashboard', NULL, 1, 0, '1'),
(2, 'user', 'material-icons,supervisor_account', 'user/userlist', NULL, 1, 0, '2'),
(3, 'settings', 'material-icons,settings_applications', 'setting', NULL, 1, 0, '3'),
(4, 'plugins', 'material-icons,extension', 'plugins', NULL, 1, 0, '4'),
(5, 'menu_setup', 'material-icons,supervisor_account', 'menusetup', NULL, 1, 0, '5');

DROP TABLE IF EXISTS `ia_permission`;
CREATE TABLE `ia_permission` (
  `id` int(122) unsigned NOT NULL AUTO_INCREMENT,
  `user_type` varchar(250) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ia_permission` (`id`, `user_type`, `data`) VALUES
(1,	'admin',	'{\"user\":\"user\"}'),
(2,	'user',	'{\"user\":\"user\"}');

DROP TABLE IF EXISTS `ia_plugins`;
CREATE TABLE `ia_plugins` (
  `plugins_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `db_tables` varchar(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT NULL,
  `inst_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rm_queries` longtext,
  `version` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`plugins_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ia_sessions`;
CREATE TABLE `ia_sessions` (
  `id` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `ia_setting`;
CREATE TABLE `ia_setting` (
  `id` int(122) unsigned NOT NULL AUTO_INCREMENT,
  `keys` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ia_setting` (`id`, `keys`, `value`) VALUES
(1,	'website',	'Igniter Admin'),
(2,	'logo',	'logo_white_text4_1518007532.png'),
(3,	'favicon',	'olalquiaga-arquitectos-social-housing-3_1517468350.jpg'),
(4,	'SMTP_EMAIL',	''),
(5,	'HOST',	''),
(6,	'PORT',	''),
(7,	'SMTP_SECURE',	'admin@admin.com'),
(8,	'SMTP_PASSWORD',	'123456'),
(9,	'mail_setting',	'simple_mail'),
(10,	'company_name',	'Company Name'),
(11,	'crud_list',	'User'),
(12,	'EMAIL',	''),
(13,	'UserModules',	'yes'),
(14,	'register_allowed',	'1'),
(15,	'email_invitation',	'1'),
(16,	'admin_approval',	'0'),
(17,	'language',	'english'),
(18,	'user_type',	'[\"user\"]'),
(19,	'date_formate',	''),
(20,	'version',	'1.0.1');

DROP TABLE IF EXISTS `ia_users`;
CREATE TABLE `ia_users` (
  `ia_users_id` int(121) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) DEFAULT NULL,
  `var_key` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_deleted` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `create_date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ia_users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `ia_users` 
(`ia_users_id`, `user_id`, `var_key`, `status`, `is_deleted`, `name`, `password`, `email`, `profile_pic`, `user_type`, `create_date`) VALUES
(1,	'1',	NULL,	'active',	'0',	'Admin',	"admin_password",	"admin_email",	'user.png',	'admin',	NULL);

-- 2018-07-26 11:46:52