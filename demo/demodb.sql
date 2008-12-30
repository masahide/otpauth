CREATE TABLE user (
  id int(11) NOT NULL auto_increment,
  name text NOT NULL,
  pw varchar(32) NOT NULL default '',
  realname varchar(32) NOT NULL default '',
  status char(1) NOT NULL default 'A',
  add_date int(11) NOT NULL default '0',
  confirm_hash varchar(40) default NULL,
  phone_number varchar(20) NOT NULL default '',
  last_pw_change int(11) NOT NULL default '0',
  otp_enabled  tinyint(1) NOT NULL default '0', 
  PRIMARY KEY  (id)
) TYPE=MyISAM;


CREATE TABLE session (
  user_id int(11) NOT NULL default '0',
  session_hash char(40) NOT NULL default '',
  ip_addr char(15) NOT NULL default '',
  otp_auth tinyint(1) NOT NULL default '0', 
  time int(11) NOT NULL default '0',
  locked tinyint(1) NOT NULL default '0', 
  PRIMARY KEY  (session_hash)
) TYPE=MyISAM;

CREATE TABLE otp (
  id int(11) NOT NULL default '0', 
  user_id int(11) NOT NULL default '0',
  sequence int(11) NOT NULL default '0',
  otp char(16) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
