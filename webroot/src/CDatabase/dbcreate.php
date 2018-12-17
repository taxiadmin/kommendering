<?php
$db_prefix = "";
$db_new_db = false;
$dbcreate = array();

/* Mall för skapandet av tabeller
$dbcreate[] = array('type'=>'TABLE', 'name'=>'' , 'sql'=> <<<EOF
EOF
    , 'data'=> <<<EOF
EOF
    ); //end $dbcreate
 */


$dbcreate[] = array('type'=>'TABLE', 'name'=>'User' , 'sql'=> <<<EOF
    CREATE TABLE User 
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  acronym CHAR(12) UNIQUE NOT NULL,
  display_name CHAR(9) UNIQUE NOT NULL,
  name VARCHAR(80),
  password CHAR(32),
  role INT,
  salt INT NOT NULL
) ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO User (acronym,display_name, name, role, salt) VALUES 
    ('pedern','Peder', 'Peder Nordenstad', 10, unix_timestamp()),
    ('jerry','Jerry', 'Jerry', 10, unix_timestamp()),
    ('admamfr','Adam', 'Adams Freimanis', 10, unix_timestamp()),
    ('johangr','Johan', 'Johan Granlund', 10, unix_timestamp()),
    ('larsna','Lars-Åke', 'Lars Åke Näsman', 10, unix_timestamp()),
    ('hansf','Hans', 'Hans Fredriksson', 1, unix_timestamp())
;
UPDATE User SET password = md5(concat('pederno', salt)) WHERE acronym = 'pedern';
UPDATE User SET password = md5(concat('yrrej', salt)) WHERE acronym = 'jerry';
UPDATE User SET password = md5(concat('freiman', salt)) WHERE acronym = 'adamfr';
UPDATE User SET password = md5(concat('jogran', salt)) WHERE acronym = 'johangr';
UPDATE User SET password = md5(concat('laakena', salt)) WHERE acronym = 'larsna';
UPDATE User SET password = md5(concat('hansfre', salt)) WHERE acronym = 'hansf';
     
EOF
    ); //end $dbcreate

$dbcreate[] = array('type'=>'TABLE', 'name'=>'system' , 'sql'=> <<<EOF
    CREATE TABLE system 
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  name char(8),
  value char(10)
) ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO system (name, value) VALUES 
    ('dB_Ver',  '1');
     
EOF
    ); //end $dbcreate
$dbcreate[] = array('type'=>'TABLE', 'name'=>'user_data_key' , 'sql'=> <<<EOF
    CREATE TABLE user_data_key
(
  user_data_id INT NOT NULL PRIMARY KEY,
  user_data_sort INT,
  user_data_descr CHAR(10)  
) ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO user_data_key (user_data_id, user_data_sort, user_data_descr)
VALUES
(2, 1, 'Tel'),
(3, 3, 'Mobil'),
(4, 3, 'Adress');
     
EOF
    ); //end $dbcreate
$dbcreate[] = array('type'=>'TABLE', 'name'=>'user_data' , 'sql'=> <<<EOF
    CREATE TABLE user_data 
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  user int,
  user_data_id int,
  value char(100),
  value_dec DECIMAL(10,2)
) ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO user_data (user, user_data_id, value) VALUES 
    ('1', 2, '08 32 75 76'),        
    ('1', 3, '0769 308 308'),        
    ('1', 4, 'Islinte hamnväg 11 Lidingö'),
    ('2', 2, ''),        
    ('2', 3, ''),        
    ('2', 4, ''),
    ('3', 2, ''),        
    ('3', 3, ''),        
    ('3', 4, ''),
    ('4', 2, ''),        
    ('4', 3, ''),        
    ('4', 4, ''),
    ('5', 2, ''),        
    ('5', 3, ''),        
    ('5', 4, ''),
    ('6', 2, ''),        
    ('6', 3, ''),        
    ('6', 4, '')
EOF
    ); //end $dbcreate

$dbcreate[] = array('type'=>'TABLE', 'name'=>'data_key' , 'sql'=> <<<EOF
    CREATE TABLE data_key
(
  data_id INT AUTO_INCREMENT PRIMARY KEY,
  owner INT NOT NULL,
  data_key INT NOT NULL,
  data_sort INT,
  data_descr CHAR(10) , 
  user INT 
) ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO data_key (owner, data_key, data_sort, data_descr)
VALUES
(1, 1, 4, 'TFL'),
(1, 2, 1, 'Tel'),
(1, 3, 3, 'Mobil'),
(1, 4, 3, 'Adress'),
(2, 5, 1, 'Tel'),
(2, 6, 2, 'Regnr'),
(2, 7, 3, 'Typ'),
(2, 8, 4, 'Försäkring');
     
EOF
    ); //end $dbcreate


$dbcreate[] = array('type'=>'TABLE', 'name'=>'data_value' , 'sql'=> <<<EOF
    CREATE TABLE data_value
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  parent int,
  key_id int,
  value char(100),
  value_dec DECIMAL(10,2)
) ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO data_value (parent, key_id, value) VALUES 
    ('1', 1, '9876543'),        
    ('1', 2, '060 336 678'),        
    ('1', 3, '076 578 945'),        
    ('1', 4, 'Hemgatan 6'),
    ('2', 1, '1234567'),        
    ('2', 2, '08 30 20 40'),        
    ('2', 3, '070 256 235'),        
    ('2', 4, 'Stortorget 4 '),    
    ('1', 5, '070150820'),        
    ('1', 6, 'KSM780'),        
    ('1', 7, 'Volvo V70'),        
    ('1', 8, 'Norska Brand'),
    ('2', 5, '07150822'),        
    ('2', 6, 'XXX999'),        
    ('2', 7, 'MB 300E'),        
    ('2', 8, 'Norska Brand');
     
EOF
    ); //end $dbcreate

$dbcreate[] = array('type'=>'TABLE', 'name'=>'cab_pass' , 'sql'=> <<<EOF
  CREATE TABLE IF NOT EXISTS cab_pass (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  type tinyint(4) NOT NULL,
  cab text NOT NULL,
  pass tinyint(4) NOT NULL,
  start_date date NOT NULL,
  start_time time NOT NULL,
  end_date date NOT NULL,
  end_time time NOT NULL,
  driver text NOT NULL,
  ink int(11) NOT NULL,
  ink_rapp int(11) NOT NULL,
  kont int(11) NOT NULL,
  kont_rapp int(11) NOT NULL,
  fel int(11) NOT NULL,
  utl int(11) NOT NULL,
  red int(11) NOT NULL,
  man_kred int(11) NOT NULL,
  v_tid int(11) NOT NULL,
  PRIMARY KEY (id,type)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
EOF
, 'data'=> <<<EOF

EOF
    ); //end $dbcreate
