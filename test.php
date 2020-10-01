<?php
// error_reporting(0); // Disable all errors.

$pyscript = 'one.py';
$python = 'C:\Users\krish\AppData\Local\Programs\Python\Python37-32\python.exe one.py';
$c = exec("$python");
echo $c;

?>