-- phpMyAdmin SQL Dump
-- version:2.11.9.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Publish date: 2016 年 05 月 19 日 06:23
-- Server Version: 5.1.28
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- database: `chat`
--

-- --------------------------------------------------------

--
-- Table Structure `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Export data from `comments`
--

INSERT INTO `comments` (`id`, `userid`, `postid`, `time`, `content`) VALUES
(1, 1, 1, 1463597074, 'a new comment'),
(2, 1, 1, 1463597189, 'second comment'),
(3, 2, 1, 1463597253, 'third comment'),
(4, 4, 1, 1463600063, 'forth comment'),
(5, 3, 2, 1463600147, 'good'),
(6, 1, 2, 1463638605, 'very good');

-- --------------------------------------------------------

--
-- Table Structure `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `topicid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Export from `posts`
--

INSERT INTO `posts` (`id`, `userID`, `topicid`, `title`, `content`, `time`) VALUES
(2, 3, 1, 'two post', 'content content2', 1463600128);

-- --------------------------------------------------------

--
-- Structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Export data from `topics`
--

INSERT INTO `topics` (`id`, `title`, `userid`) VALUES
(1, 'news', 1),
(2, 'food', 1);

-- --------------------------------------------------------

--
-- Structure for data `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `authority` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- export data from `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `authority`) VALUES
(1, 'admin@admin.com', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin', 4)
