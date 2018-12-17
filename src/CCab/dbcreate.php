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


$dbcreate[] = array('type'=>'TABLE', 'name'=>'cab' , 'sql'=> <<<EOF
    CREATE TABLE cab 
(
  id INT AUTO_INCREMENT PRIMARY KEY, 
  cab CHAR(12) UNIQUE NOT NULL,
  pass INT,
  pass_time TEXT,
  start_date date ,
  end_date date NOT NULL,
  start_day int NOT NULL
)
  ENGINE INNODB CHARACTER SET utf8;
EOF
, 'data'=> <<<EOF
INSERT INTO cab (cab, pass, start_date, start_day) VALUES  
    ('820', 2, unix_timestamp(), 0),
    ('822', 2, unix_timestamp(), 0)
;
     
EOF
    ); //end $dbcreate



