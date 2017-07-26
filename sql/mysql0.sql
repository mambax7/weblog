#
# Table structure for table weblog0
#
# phpMyAdmin MySQL-Dump
# version 2.5.0
# http://www.phpmyadmin.net/ (download page)
#
# --------------------------------------------------------

#
# Table Structure weblog0
#

CREATE TABLE weblog0 (
  blog_id          MEDIUMINT(9)        NOT NULL AUTO_INCREMENT,
  user_id          MEDIUMINT(9)        NOT NULL DEFAULT '0',
  cat_id           INT(5) UNSIGNED     NOT NULL DEFAULT '0',
  created          INT(10)             NOT NULL DEFAULT '0',
  title            VARCHAR(128)        NOT NULL DEFAULT '',
  contents         TEXT                NOT NULL,
  private          CHAR(1)             NOT NULL DEFAULT '',
  comments         INT(11)             NOT NULL DEFAULT '0',
  `reads`          INT(11)             NOT NULL DEFAULT '0',
  trackbacks       INT(11)             NOT NULL DEFAULT '0',
  description      TEXT                NOT NULL,
  dohtml           TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  dobr             TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  permission_group VARCHAR(255)        NOT NULL DEFAULT 'all',
  PRIMARY KEY (blog_id),
  KEY user_id (user_id, created, title, private)
) TYPE = MyISAM;
# --------------------------------------------------------

#
# Table Structure weblog0_category
#

CREATE TABLE weblog0_category (
  cat_id          INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  cat_pid         INT(5) UNSIGNED NOT NULL DEFAULT '0',
  cat_title       VARCHAR(50)     NOT NULL DEFAULT '',
  cat_description TEXT            NOT NULL,
  cat_created     INT(10)         NOT NULL DEFAULT '0',
  cat_imgurl      VARCHAR(150)    NOT NULL DEFAULT '',
  PRIMARY KEY (cat_id),
  KEY cat_pid (cat_pid)
) TYPE = MyISAM;

INSERT INTO weblog0_category (
  cat_id, cat_pid, cat_title, cat_description, cat_created, cat_imgurl)
VALUES (
  '1', '0', 'Miscellaneous', '', '1051983686', ''
);
# --------------------------------------------------------

CREATE TABLE weblog0_priv (
  priv_id  SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  priv_gid SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (priv_id)
) TYPE = MyISAM;

# --------------------------------------------------------
CREATE TABLE weblog0_trackback (
  blog_id           MEDIUMINT(9)                      NOT NULL,
  tb_url            TEXT                              NOT NULL,
  blog_name         VARCHAR(255)                      NOT NULL,
  title             VARCHAR(255)                      NOT NULL,
  description       TEXT                              NOT NULL,
  link              TEXT                              NOT NULL,
  direction         ENUM ('', 'transmit', 'recieved') NOT NULL DEFAULT '',
  trackback_created INT(10)                           NOT NULL DEFAULT '0',
  PRIMARY KEY (blog_id, tb_url(100), direction)
) TYPE = MyISAM;

# --------------------------------------------------------
#
# Table structure for table `myalbum_photos`
#

CREATE TABLE weblog0myalbum_photos (
  lid       INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  cid       INT(5) UNSIGNED  NOT NULL DEFAULT '0',
  title     VARCHAR(100)     NOT NULL DEFAULT '',
  ext       VARCHAR(10)      NOT NULL DEFAULT '',
  res_x     INT(11)          NOT NULL DEFAULT '0',
  res_y     INT(11)          NOT NULL DEFAULT '0',
  submitter INT(11) UNSIGNED NOT NULL DEFAULT '0',
  status    TINYINT(2)       NOT NULL DEFAULT '0',
  date      INT(10)          NOT NULL DEFAULT '0',
  PRIMARY KEY (lid),
  KEY cid (cid)
) TYPE = MyISAM;
