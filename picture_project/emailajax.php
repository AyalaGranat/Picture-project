<?php
require_once 'dbfuncs.php';
$email=filter_input(INPUT_POST,"email",FILTER_SANITIZE_SPECIAL_CHARS);
echo (userexist($email))?"InUse":"Free";

