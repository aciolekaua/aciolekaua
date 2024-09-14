<?php
$session=new Src\Classes\ClassSessions;
$session->destructSessions();
if($session->destructSessions()){
    header("Location:".DIRPAGE."login");
}

//$write=new Src\Classes\ClassWrite;
//$write->alert("Você efetuou o logout",DIRPAGE."login");
?>