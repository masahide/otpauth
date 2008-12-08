CREATE TABLE user (
  user_id int(11) NOT NULL auto_increment,
  user_name text NOT NULL,
  user_pw varchar(32) NOT NULL default '',
  realname varchar(32) NOT NULL default '',
  status char(1) NOT NULL default 'A',
  add_date int(11) NOT NULL default '0',
  confirm_hash varchar(32) default NULL,
  phone_number varchar(20) NOT NULL default '',
  last_pw_change int(11) NOT NULL default '0',
  PRIMARY KEY  (user_id),
  UNIQUE KEY user_id_index (user_id),
) TYPE=MyISAM;


CREATE TABLE session (
  user_id int(11) NOT NULL default '0',
  session_hash char(32) NOT NULL default '',
  ip_addr char(15) NOT NULL default '',
  time int(11) NOT NULL default '0',
  PRIMARY KEY  (session_hash),
) TYPE=MyISAM;

CREATE TABLE otp (
  user_id int(11) NOT NULL default '0',
  sequence int(11) NOT NULL default '0',
  otp char(60) NOT NULL default '',
  PRIMARY KEY  (session_hash),
) TYPE=MyISAM;
