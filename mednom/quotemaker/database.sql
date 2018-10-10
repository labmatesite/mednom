-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2015 at 01:52 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aun`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userType` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `emailid` varchar(255) NOT NULL,
  `emailpwd` varchar(255) NOT NULL,
  `tnc` text NOT NULL,
  `currency` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `host` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `dt` datetime NOT NULL,
  `a_ipaddress` varchar(255) NOT NULL,
  `outside` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `auth_group`
--

CREATE TABLE IF NOT EXISTS `auth_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Permission roles such as admins, moderators, staff, etc' AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `auth_permission`
--

CREATE TABLE IF NOT EXISTS `auth_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `roles` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Contains a list of modules that a group can access.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `auth_user`
--

CREATE TABLE IF NOT EXISTS `auth_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'b9e918b85833706ca2896d3294d2197c234c1eb4',
  `salt` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'd6636',
  `group_id` int(11) DEFAULT NULL,
  `ip_address` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `activation_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forgotten_password_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Super User Information' AUTO_INCREMENT=216 ;

-- --------------------------------------------------------

--
-- Table structure for table `crn`
--

CREATE TABLE IF NOT EXISTS `crn` (
  `crn_id` int(11) NOT NULL AUTO_INCREMENT,
  `crn_prefix` varchar(255) NOT NULL,
  `crn_stseq` int(11) NOT NULL,
  `crn_updatedby` varchar(255) NOT NULL,
  `crn_updatedt` datetime NOT NULL,
  PRIMARY KEY (`crn_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `l10n_area`
--

CREATE TABLE IF NOT EXISTS `l10n_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `state_id` int(11) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `postal_code` (`postal_code`),
  KEY `idx__345fsd_bg5__system_state___id` (`state_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `l10n_country`
--

CREATE TABLE IF NOT EXISTS `l10n_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso2_code` varchar(2) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `name` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `printable_name` varchar(128) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `iso3_code` varchar(3) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `numcode` smallint(5) unsigned DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `continent` varchar(2) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `admin_area` varchar(2) CHARACTER SET utf8 DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `iso2_code` (`iso2_code`),
  UNIQUE KEY `iso3_code` (`iso3_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=245 ;

-- --------------------------------------------------------

--
-- Table structure for table `l10n_state`
--

CREATE TABLE IF NOT EXISTS `l10n_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `abbriv` varchar(5) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `is_active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `price_list`
--

CREATE TABLE IF NOT EXISTS `price_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(64) NOT NULL,
  `final_inr` varchar(255) NOT NULL,
  `final_euro` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=274 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `series` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `features` text NOT NULL,
  `specifications` text NOT NULL,
  `applications` text NOT NULL,
  `extra_info` text NOT NULL,
  `accessories` text NOT NULL,
  `optional_accessories` text NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `head_title` varchar(255) NOT NULL,
  `url_title` varchar(255) NOT NULL,
  `meta_description` varchar(2000) NOT NULL,
  `image_title` varchar(255) NOT NULL,
  `image_alt` varchar(255) NOT NULL,
  `tags` text NOT NULL,
  `image_urls` text NOT NULL,
  `catalog_url` varchar(2000) NOT NULL,
  `page_url` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=838 ;

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE IF NOT EXISTS `quotations` (
  `qt_id` int(11) NOT NULL AUTO_INCREMENT,
  `qt_organisationid` int(11) NOT NULL,
  `qt_contacts` int(11) NOT NULL,
  `qt_subject` varchar(255) NOT NULL,
  `qt_refid` varchar(255) NOT NULL,
  `qt_orgid` varchar(255) NOT NULL,
  `qt_tnc` longtext NOT NULL,
  `qt_addinfo` varchar(255) NOT NULL,
  `qt_desc` longtext NOT NULL,
  `qt_currency` varchar(255) NOT NULL,
  `qt_itemtotal` varchar(255) NOT NULL,
  `qt_discount` varchar(150) NOT NULL,
  `qt_discountpercent` varchar(100) NOT NULL,
  `qt_shipping_charges` varchar(255) NOT NULL,
  `qt_pretax_total` varchar(255) NOT NULL,
  `qt_tax` varchar(255) NOT NULL,
  `qt_adj_add` varchar(255) NOT NULL,
  `qt_adj_sub` varchar(255) NOT NULL,
  `qt_grandtotal` varchar(255) NOT NULL,
  `qt_createdby` varchar(255) NOT NULL,
  `qt_createddt` datetime NOT NULL,
  `qt_updatedby` varchar(255) NOT NULL,
  `qt_updateddt` datetime NOT NULL,
  PRIMARY KEY (`qt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_contactactivity`
--

CREATE TABLE IF NOT EXISTS `quote_contactactivity` (
  `ca_id` int(11) NOT NULL AUTO_INCREMENT,
  `ca_userid` varchar(255) COLLATE utf8_bin NOT NULL,
  `ca_activity` varchar(255) COLLATE utf8_bin NOT NULL,
  `ca_activity_details` longblob NOT NULL,
  `ca_dbtype` varchar(255) COLLATE utf8_bin NOT NULL,
  `ca_date` datetime NOT NULL,
  PRIMARY KEY (`ca_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_contacts`
--

CREATE TABLE IF NOT EXISTS `quote_contacts` (
  `cont_id` int(11) NOT NULL AUTO_INCREMENT,
  `cont_type` varchar(100) NOT NULL,
  `cont_sal` varchar(25) NOT NULL,
  `cont_firstname` varchar(255) NOT NULL,
  `cont_lastname` varchar(255) NOT NULL,
  `cont_primaryemail` varchar(255) NOT NULL,
  `cont_secondaryemail` varchar(255) NOT NULL,
  `cont_mobilephone` varchar(255) NOT NULL,
  `cont_altphone` varchar(255) NOT NULL,
  `cont_dob` date NOT NULL,
  `cont_leadsource` varchar(100) NOT NULL,
  `cont_orgid` varchar(255) NOT NULL,
  `cont_orgdepart` varchar(255) NOT NULL,
  `cont_assignedto` varchar(255) NOT NULL,
  `cont_dnc` varchar(255) NOT NULL,
  `cont_mailingadd` longtext NOT NULL,
  `cont_mailingpob` varchar(255) NOT NULL,
  `cont_mailingcity` varchar(255) NOT NULL,
  `cont_mailingstate` varchar(255) NOT NULL,
  `cont_mailingpoc` varchar(255) NOT NULL,
  `cont_mailingcountry` varchar(255) NOT NULL,
  `cont_otheradd` longtext NOT NULL,
  `cont_otherpob` varchar(255) NOT NULL,
  `cont_othercity` varchar(255) NOT NULL,
  `cont_otherstate` varchar(255) NOT NULL,
  `cont_otherpoc` varchar(255) NOT NULL,
  `cont_othercountry` varchar(255) NOT NULL,
  `cont_desc` longtext NOT NULL,
  `cont_createdby` varchar(255) NOT NULL,
  `cont_createddt` datetime NOT NULL,
  `cont_updatedby` varchar(255) NOT NULL,
  `cont_updateddt` datetime NOT NULL,
  PRIMARY KEY (`cont_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_edited`
--

CREATE TABLE IF NOT EXISTS `quote_edited` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT,
  `refid` varchar(100) NOT NULL,
  `generatedby` varchar(500) NOT NULL,
  `generatedon` varchar(500) NOT NULL,
  `quotedata` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `myindex` (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=132 ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_emaillogs`
--

CREATE TABLE IF NOT EXISTS `quote_emaillogs` (
  `el_id` int(11) NOT NULL AUTO_INCREMENT,
  `el_userid` varchar(255) CHARACTER SET utf8 NOT NULL,
  `el_refid` varchar(255) NOT NULL,
  `el_from` varchar(255) CHARACTER SET utf8 NOT NULL,
  `el_to` varchar(255) CHARACTER SET utf8 NOT NULL,
  `el_acc` varchar(255) CHARACTER SET utf8 NOT NULL,
  `el_bcc` varchar(255) CHARACTER SET utf8 NOT NULL,
  `el_subject` varchar(255) CHARACTER SET utf8 NOT NULL,
  `el_content` longtext CHARACTER SET utf8 NOT NULL,
  `el_attachments` longtext CHARACTER SET utf8 NOT NULL,
  `el_date` datetime NOT NULL,
  `el_ipaddress` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`el_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_organisation`
--

CREATE TABLE IF NOT EXISTS `quote_organisation` (
  `org_id` int(11) NOT NULL AUTO_INCREMENT,
  `org_name` varchar(255) NOT NULL,
  `org_primaryemail` varchar(255) NOT NULL,
  `org_secondaryemail` varchar(255) NOT NULL,
  `org_tertiaryemail` varchar(255) NOT NULL,
  `org_primaryphone` varchar(255) NOT NULL,
  `org_altphone` varchar(255) NOT NULL,
  `org_fax` varchar(255) NOT NULL,
  `org_website` varchar(255) NOT NULL,
  `org_assignedto` varchar(255) NOT NULL,
  `org_industry` varchar(255) NOT NULL,
  `org_cst` varchar(255) NOT NULL,
  `org_vat` varchar(255) NOT NULL,
  `org_billingadd` longtext NOT NULL,
  `org_billingpob` varchar(255) NOT NULL,
  `org_billingcity` varchar(255) NOT NULL,
  `org_billingstate` varchar(255) NOT NULL,
  `org_billingpoc` varchar(255) NOT NULL,
  `org_billingcountry` varchar(255) NOT NULL,
  `org_shippingadd` longtext NOT NULL,
  `org_shippingpob` varchar(255) NOT NULL,
  `org_shippingcity` varchar(255) NOT NULL,
  `org_shippingstate` varchar(255) NOT NULL,
  `org_shippingpoc` varchar(255) NOT NULL,
  `org_shippingcountry` varchar(255) NOT NULL,
  `org_desc` longtext NOT NULL,
  `org_createdby` varchar(255) NOT NULL,
  `org_createddt` datetime NOT NULL,
  `org_updatedby` varchar(255) NOT NULL,
  `org_updateddt` datetime NOT NULL,
  PRIMARY KEY (`org_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_pinvoiceno`
--

CREATE TABLE IF NOT EXISTS `quote_pinvoiceno` (
  `pi_id` int(11) NOT NULL AUTO_INCREMENT,
  `pi_prefix` varchar(255) NOT NULL,
  `pi_stseq` int(11) NOT NULL,
  `pi_updatedby` varchar(255) NOT NULL,
  `pi_updatedt` datetime NOT NULL,
  PRIMARY KEY (`pi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_pod`
--

CREATE TABLE IF NOT EXISTS `quote_pod` (
  `pod_id` int(11) NOT NULL AUTO_INCREMENT,
  `pod_name` varchar(255) NOT NULL,
  `pod_address` longtext NOT NULL,
  `pod_contact` varchar(50) NOT NULL,
  `pod_createdby` varchar(200) NOT NULL,
  `pod_createddt` datetime NOT NULL,
  `pod_updatedby` varchar(200) NOT NULL,
  `pod_updateddt` datetime NOT NULL,
  PRIMARY KEY (`pod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_product`
--

CREATE TABLE IF NOT EXISTS `quote_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qt_refid` varchar(255) NOT NULL,
  `product_sku` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_desc` longtext NOT NULL,
  `product_quantity` varchar(150) NOT NULL,
  `product_sellingprice` varchar(255) NOT NULL,
  `product_catalog` varchar(255) NOT NULL,
  `product_spec_show` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_savedlogs`
--

CREATE TABLE IF NOT EXISTS `quote_savedlogs` (
  `sd_id` int(11) NOT NULL AUTO_INCREMENT,
  `sd_userid` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sd_subject` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sd_qt_refid` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sd_date` datetime NOT NULL,
  `sd_ipaddress` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`sd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_share`
--

CREATE TABLE IF NOT EXISTS `quote_share` (
  `shd_id` int(11) NOT NULL AUTO_INCREMENT,
  `shd_orgid` int(11) NOT NULL,
  `shd_contid` int(11) NOT NULL,
  `shd_assignto` varchar(255) NOT NULL,
  `shd_shdby` varchar(255) NOT NULL,
  `shd_shddate` datetime NOT NULL,
  PRIMARY KEY (`shd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_shipper`
--

CREATE TABLE IF NOT EXISTS `quote_shipper` (
  `sh_id` int(11) NOT NULL AUTO_INCREMENT,
  `sh_name` varchar(255) NOT NULL,
  `sh_origin` longtext NOT NULL,
  `sh_email` varchar(255) NOT NULL,
  `sh_contact` varchar(50) NOT NULL,
  `sh_desc` longtext NOT NULL,
  `sh_assignedto` varchar(200) NOT NULL,
  `sh_createdby` varchar(200) NOT NULL,
  `sh_createddt` datetime NOT NULL,
  `sh_updatedby` varchar(200) NOT NULL,
  `sh_updateddt` datetime NOT NULL,
  PRIMARY KEY (`sh_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_tax`
--

CREATE TABLE IF NOT EXISTS `quote_tax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qt_refid` varchar(255) NOT NULL,
  `qt_taxname` varchar(255) NOT NULL,
  `qt_taxvalue` varchar(255) NOT NULL,
  `qt_taxdt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `quote_uploaddata`
--

CREATE TABLE IF NOT EXISTS `quote_uploaddata` (
  `up_id` int(11) NOT NULL AUTO_INCREMENT,
  `up_refid` varchar(255) NOT NULL,
  `up_file_name` varchar(255) NOT NULL,
  `up_file_size` varchar(255) NOT NULL,
  `up_file_type` varchar(255) NOT NULL,
  PRIMARY KEY (`up_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tax_cal`
--

CREATE TABLE IF NOT EXISTS `tax_cal` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(255) NOT NULL,
  `tax_value` varchar(255) NOT NULL,
  `tax_status` varchar(10) NOT NULL DEFAULT 'deactive',
  `tax_dt` datetime NOT NULL,
  `tax_update` varchar(255) NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `termsncond`
--

CREATE TABLE IF NOT EXISTS `termsncond` (
  `tnc_id` int(11) NOT NULL AUTO_INCREMENT,
  `tnc_orgid` varchar(100) NOT NULL,
  `tnc_content` longtext NOT NULL,
  `tnc_dt` datetime NOT NULL,
  PRIMARY KEY (`tnc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;


INSERT INTO `admin` (`id`, `userType`, `username`, `password`, `emailid`, `emailpwd`, `tnc`, `currency`, `price`, `host`, `port`, `dt`, `a_ipaddress`, `outside`) VALUES
(15, 'Superadmin', 'jugal', 'jugal@123', 'jugalsingh88@gmail.com', 'Sarah@&*^%', '<p>t%CCC</p>', 'inr', 'final_inr', 'mail.labocon.com', '25', '2015-05-29 14:45:53', '182.58', 'yes'),
(16, 'admin', 'ketki', 'ketki@567', 'sarah@labocon.com', 'Neva@!!)@92', '', '', '', 'mail.labocon.com', '25', '2015-04-21 14:51:59', '182.58', 'yes'),
(17, 'admin', 'pooja', 'pooja@789', 'kiana@labocon.com', 'Kiana@&*^%', '', '', '', 'mail.labocon.com', '25', '2015-04-16 16:14:24', '182.58', 'yes'),
(18, 'logistics', 'qasim', 'qasim123', '', '', '', '', '', '', '00', '2014-08-01 15:08:56', '182.58', ''),
(19, 'logistics', 'Varis', 'sabar123', 'logistics@indianscientific.com', 'Neva@110', '', '', '', 'mail.indianscientific.com', '25', '2015-04-09 12:01:41', '182.58', 'yes'),
(20, 'Superadmin', 'admin', 'Waqar@110', 'sarah@labocon.com', 'Sana@shaikh@786', '', '', '', 'mail.labocon.com', '25', '2015-01-15 17:01:19', '182.58', 'yes'),
(22, 'users', 'david', 'david123', 'david@labocon.com', 'swakum294', '', '', '', 'mail.labocon.com', '25', '2015-04-27 15:50:49', '182.58', 'yes'),
(23, 'admin', 'tanvi', 'tanvi123', 'cathy@labocon.com', 'Lab@110', '', '', '', 'mail.labocon.com', '25', '2015-04-25 11:42:34', '182.58', 'yes'),
(24, 'users', 'satya', 'satya@123', '', '', '', 'inr', 'final_inr', '', '', '2015-05-28 18:14:03', '', 'yes'),
(25, 'admin', 'admin', 'B@nanablu3', '', '', '', 'dollar', 'final_inr', '', '', '2015-05-28 18:16:52', '', 'yes'),
(26, 'admin', 'ekta', 'ekta@123', '', '', '', 'dollar', 'final_euro', '', '', '2015-05-28 18:21:51', '', 'yes');

INSERT INTO `auth_group` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrators'),
(2, 'user', 'Users'),
(3, 'user1', 'test'),
(4, 'excel', 'Excel User'),
(5, 'pdf', 'Pdf User'),
(6, 'img', 'Image User');


INSERT INTO `crn` (`crn_id`, `crn_prefix`, `crn_stseq`, `crn_updatedby`, `crn_updatedt`) VALUES
(1, 'abafe0515', 6859, 'jugal', '2015-05-29 12:23:03');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
