--
-- Структура таблицы `sr`
--

CREATE TABLE IF NOT EXISTS `sr` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `val` varchar(40) DEFAULT NULL,
  `id_p` int(7) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=58 AUTO_INCREMENT=0 ;

--
-- Структура таблицы `sq`
--

CREATE TABLE IF NOT EXISTS `sq` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `val` text,
  `param` varchar(70) NOT NULL DEFAULT '',
  `id_p` int(7) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=66 AUTO_INCREMENT=0 ;
--
-- Структура таблицы `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AVG_ROW_LENGTH=30 COMMENT='soro должности' AUTO_INCREMENT=0 ;
--
-- Структура таблицы `pers`
--

CREATE TABLE IF NOT EXISTS `pers` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL COMMENT 'manager',
  `id_job` int(3) NOT NULL DEFAULT '0',
  `id_c` int(7) NOT NULL,
  `infolink` varchar(125) NOT NULL DEFAULT '',
  `d_r` date NOT NULL,
  `prim` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=100 COMMENT='менеджеры' AUTO_INCREMENT=1 ;
--
-- Структура таблицы `company_type`
--

CREATE TABLE IF NOT EXISTS `company_type` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `short` varchar(10) NOT NULL DEFAULT '""',
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=801 ROW_FORMAT=FIXED COMMENT='тип компании' AUTO_INCREMENT=0 ;
--
-- Структура таблицы `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(160) NOT NULL DEFAULT '',
  `short_name` varchar(60) NOT NULL,
  `id_type` tinyint(3) NOT NULL DEFAULT '1',
  `inn` bigint(12) unsigned DEFAULT NULL,
  `dt_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `address` varchar(200) NOT NULL,
  `ogrn` varchar(13) NOT NULL,
  `kpp` int(9) NOT NULL,
  `bik` varchar(9) NOT NULL,
  `rsh` varchar(150) NOT NULL,
  `pind` int(6) NOT NULL,
  `tel` varchar(18) NOT NULL,
  `fax` varchar(18) NOT NULL,
  `email` varchar(20) NOT NULL,
  `dolj` varchar(80) NOT NULL,
  `osnovanie` varchar(150) NOT NULL,
  `person` varchar(50) NOT NULL,
  `pol` enum('0','1') NOT NULL,
  `infodoc` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=419 COMMENT='компании обслуживания' AUTO_INCREMENT=0 ;
--
-- Структура таблицы `regl`
--

CREATE TABLE IF NOT EXISTS `regl` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_c` int(7) NOT NULL,
  `date_n` date NOT NULL DEFAULT '2011-01-01',
  `date_k` date DEFAULT NULL,
  `gr_w` varchar(30) NOT NULL DEFAULT 'ежедневно',
  `gday` varchar(5) NOT NULL DEFAULT '00.00',
  `name` varchar(150) NOT NULL DEFAULT '',
  `dt_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_dog` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=103 COMMENT='регламенты' AUTO_INCREMENT=0 ;
--
-- Структура таблицы `plan`
--

CREATE TABLE IF NOT EXISTS `plan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_c` int(7) NOT NULL,
  `date_n` date NOT NULL DEFAULT '2015-05-01',
  `name` varchar(150) NOT NULL DEFAULT '',
  `dt_upd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_pers` tinyint(4) NOT NULL,
  `kol` tinyint(3) NOT NULL DEFAULT '0',
  `status` enum('исполнено','в работе','снято исп.','снято зак.','перенос','план') NOT NULL DEFAULT 'план',
  `prim` varchar(100) NOT NULL,
  `id_p` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=103 COMMENT='текущие планы' AUTO_INCREMENT=0 ;
--
-- Структура таблицы `iregl`
--

CREATE TABLE IF NOT EXISTS `iregl` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date_n` date NOT NULL DEFAULT '2015-05-01',
  `id_pers` tinyint(4) NOT NULL,
  `kol` decimal(4,1) NOT NULL DEFAULT '0.0',
  `status` enum('исполнено','снято исп.','снято зак.') NOT NULL DEFAULT 'исполнено',
  `prim` varchar(100) NOT NULL,
  `id_r` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=24 COMMENT='исполнение регламентов' AUTO_INCREMENT=123 ;