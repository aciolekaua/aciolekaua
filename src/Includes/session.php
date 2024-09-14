<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set("session.save_handler","files");
ini_set('session.use_cookies',1);
ini_set('session.cookie_lifetime',0);
ini_set('session.use_only_cookies',1);
ini_set('session.use_strict_mode',1);
ini_set('session.cookie_httponly',1);
ini_set('session.cookie_domain',DOMAIN);
ini_set('session.cookie_samesite','Strict');
if(DOMAIN!="localhost"){ini_set('session.cookie_secure',1);}
ini_set("session.entropy_length",512);
ini_set("session.entropy_file",'/dev/urandom');
ini_set('session.use_trans_sid',1);
ini_set('session.name','ELAISESSION');
ini_set('session.sid_bits_per_character',6);
ini_set('session.use_trans_sid',0);
ini_set('session.sid_length',200);
ini_set('session.hash_function','sha256');
ini_set('session.gc_maxlifetime',1800);
session_start();
?>