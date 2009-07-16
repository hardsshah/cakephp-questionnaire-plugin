# Sequel Pro dump
# Version 663
# http://code.google.com/p/sequel-pro
#
# Host: localhost (MySQL 5.0.41)
# Database: questionnaire
# Generation Time: 2009-07-07 16:26:20 -0400
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table questionnaire_answers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questionnaire_answers`;

CREATE TABLE `questionnaire_answers` (
  `id` int(11) NOT NULL auto_increment,
  `questionnaire_question_id` int(11) default NULL,
  `title` varchar(100) default NULL,
  `default` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  KEY `questionnaire_question_id` (`questionnaire_question_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table questionnaire_questionnaires
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questionnaire_questionnaires`;

CREATE TABLE `questionnaire_questionnaires` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(40) collate utf8_unicode_ci NOT NULL default '',
  `welcome_message` text collate utf8_unicode_ci,
  `thank_you_message` text collate utf8_unicode_ci,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table questionnaire_questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questionnaire_questions`;

CREATE TABLE `questionnaire_questions` (
  `id` int(11) NOT NULL auto_increment,
  `questionnaire_section_id` int(11) default NULL,
  `questionnaire_question_type_id` int(11) default NULL,
  `questionnaire_questionnaire_id` int(11) default NULL,
  `title` varchar(100) default NULL,
  `textbox_size` varchar(10) default NULL,
  `textfield_size` varchar(10) default NULL,
  `required` tinyint(1) default NULL,
  `help` varchar(255) default NULL,
  `number_of_characters` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `section_id` (`questionnaire_section_id`),
  KEY `type_id` (`questionnaire_question_type_id`),
  KEY `questionnaire_questionnaire_id` (`questionnaire_questionnaire_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table questionnaire_sections
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questionnaire_sections`;

CREATE TABLE `questionnaire_sections` (
  `id` int(11) NOT NULL auto_increment,
  `questionnaire_questionnaire_id` int(11) default NULL,
  `title` varchar(40) default NULL,
  `description` text,
  PRIMARY KEY  (`id`),
  KEY `questionnaire_id` (`questionnaire_questionnaire_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table questionnaire_survey
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questionnaire_survey`;

CREATE TABLE `questionnaire_survey` (
  `id` int(11) NOT NULL auto_increment,
  `questionnaire_question_id` int(11) NOT NULL,
  `foreign_id` int(11) default NULL,
  `title` varchar(400) default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;






/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
