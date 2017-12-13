-- ----------------------------
-- Table structure for `User`
-- ----------------------------
DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
  `uid` VARCHAR(45) NOT NULL,
  `uname` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `city` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`uid`));
-- ----------------------------
-- Table structure for `Artist`
-- ----------------------------
DROP TABLE IF EXISTS `Artist`;
CREATE TABLE `Artist` (
  `aid` VARCHAR(45) NOT NULL,
  `aname` VARCHAR(45) NOT NULL,
  `adesc` VARCHAR(200) NULL,
  PRIMARY KEY (`aid`));
-- ----------------------------
-- Table structure for `Track`
-- ----------------------------
DROP TABLE IF EXISTS `Track`;
CREATE TABLE `Track` (
  `tid` VARCHAR(45) NOT NULL,
  `ttitle` VARCHAR(45) NOT NULL,
  `tduration` TIME NOT NULL,
  `aname` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`tid`),
  FOREIGN KEY (`aname`) REFERENCES `Artist` (`aname`));
-- ----------------------------
-- Table structure for Album
-- ----------------------------
DROP TABLE IF EXISTS `Album`;
CREATE TABLE `Album` (
  `alid` VARCHAR(45) NOT NULL,
  `alname` VARCHAR(45) NOT NULL,
  `aldate` DATETIME NOT NULL,
  PRIMARY KEY (`alid`));
-- ----------------------------
-- Table structure for PlayList
-- ----------------------------
DROP TABLE IF EXISTS `PlayList`;
CREATE TABLE `PlayList` (
  `pid` INT NOT NULL AUTO_INCREMENT,
  `uid` VARCHAR(45) NOT NULL,
  `ptitle` VARCHAR(45) NOT NULL,
  `pdate` DATETIME NOT NULL,
  `pstatus` BOOLEAN
  PRIMARY KEY (`pid`),
  FOREIGN KEY (`uid`) REFERENCES `User` (`uid`));
-- ----------------------------
-- Table structure for PlayListInclude
-- ----------------------------
DROP TABLE IF EXISTS `PlayListInclude`;
CREATE TABLE `PlayListInclude` (
  `pid` INT NOT NULL,
  `tid` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`pid`, `tid`),
  FOREIGN KEY (`pid`) REFERENCES `PlayList` (`pid`),
  FOREIGN KEY (`tid`) REFERENCES `Track` (`tid`));
-- ----------------------------
-- Table structure for Like
-- ----------------------------
DROP TABLE IF EXISTS `Favorite`;
CREATE TABLE `Favorite` (
  `uid` VARCHAR(45) NOT NULL,
  `aid` VARCHAR(45) NOT NULL,
  `ltimestamp` DATETIME NOT NULL,
  PRIMARY KEY (`uid`, `aid`),
  FOREIGN KEY (`uid`) REFERENCES `User` (`uid`),
  FOREIGN KEY (`aid`) REFERENCES `Artist` (`aid`));
-- ----------------------------
-- Table structure for Rate
-- ----------------------------
DROP TABLE IF EXISTS `Rate`;
CREATE TABLE `Rate` (
  `uid` VARCHAR(45) NOT NULL,
  `tid` VARCHAR(45) NOT NULL,
  `rtimestamp` DATETIME NOT NULL,
  `score` INT NOT NULL,
  PRIMARY KEY (`uid`, `tid`, `rtimestamp`),
  FOREIGN KEY (`uid`) REFERENCES `User` (`uid`),
  FOREIGN KEY (`tid`) REFERENCES `Track` (`tid`),
  CHECK (`score` <= 5 and `score` >= 1));
-- ----------------------------
-- Table structure for Follow
-- ----------------------------
DROP TABLE IF EXISTS `Follow`;
CREATE TABLE `Follow` (
  `uid` VARCHAR(45) NOT NULL,
  `fuid` VARCHAR(45) NOT NULL,
  `ftimestamp` DATETIME NOT NULL,
  PRIMARY KEY (`uid`, `fuid`),
  FOREIGN KEY (`uid`) REFERENCES `User` (`uid`),
  FOREIGN KEY (`fuid`) REFERENCES `User` (`uid`),
  CHECK (`uid` <> `fuid`));
-- ----------------------------
-- Table structure for History
-- ----------------------------
DROP TABLE IF EXISTS `History`;
CREATE TABLE `History` (
  `uid` VARCHAR(45) NOT NULL,
  `tid` VARCHAR(45) NOT NULL,
  `htimestamp` DATETIME NOT NULL,
  `pid` INT NULL,
  `alid` VARCHAR(22) NULL,
  PRIMARY KEY (`uid`, `tid`, `htimestamp`),
  FOREIGN KEY (`uid`) REFERENCES `User` (`uid`),
  FOREIGN KEY (`tid`) REFERENCES `Track` (`tid`),
  FOREIGN KEY (`pid`) REFERENCES `PlayList` (`pid`),
  FOREIGN KEY (`alid`) REFERENCES `Album` (`alid`));

