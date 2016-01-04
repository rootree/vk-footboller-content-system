
CREATE TABLE IF NOT EXISTS `coaches_store` (
  `ch_name` varchar(250) NOT NULL,
  `ch_desc` text NOT NULL,
  `ch_level` smallint(6) NOT NULL,
  `ch_rating` smallint(6) NOT NULL,
  `ch_photo` varchar(250) NOT NULL,
  `ch_id` int(11) NOT NULL AUTO_INCREMENT,
  `ch_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ch_status` smallint(6) NOT NULL,
  `tm_id` int(11) NOT NULL,
  PRIMARY KEY (`ch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `footballers_store`
--

CREATE TABLE IF NOT EXISTS `footballers_store` (
  `ft_name` varchar(250) NOT NULL,
  `ft_desc` text NOT NULL,
  `ft_line` smallint(6) NOT NULL,
  `ft_level` smallint(6) NOT NULL,
  `ft_rating` smallint(6) NOT NULL,
  `ft_photo` varchar(250) NOT NULL,
  `ft_photo_best` varchar(250) NOT NULL,
  `ft_id` int(11) NOT NULL AUTO_INCREMENT,
  `ft_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ft_status` smallint(6) NOT NULL,
  `tm_id` int(11) NOT NULL,
  PRIMARY KEY (`ft_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Структура таблицы `sponsors_store`
--

CREATE TABLE IF NOT EXISTS `sponsors_store` (
  `sp_name` varchar(250) NOT NULL,
  `sp_level` smallint(6) NOT NULL,
  `sp_rating` smallint(6) NOT NULL,
  `sp_photo` varchar(250) NOT NULL,
  `sp_id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sp_status` smallint(6) NOT NULL,
  PRIMARY KEY (`sp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `stadiums_store`
--

CREATE TABLE IF NOT EXISTS `stadiums_store` (
  `st_name` varchar(250) NOT NULL,
  `st_city` varchar(250) NOT NULL,
  `st_country_code` int(11) NOT NULL,
  `st_level` smallint(6) NOT NULL,
  `st_photo` varchar(250) NOT NULL,
  `st_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `st_status` smallint(6) NOT NULL,
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `teams_store`
--

CREATE TABLE IF NOT EXISTS `teams_store` (
  `tm_name` varchar(250) NOT NULL,
  `tm_country_code` int(11) NOT NULL,
  `tm_photo` varchar(250) NOT NULL,
  `tm_id` int(11) NOT NULL AUTO_INCREMENT,
  `tm_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tm_status` smallint(6) NOT NULL,
  PRIMARY KEY (`tm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
