<?php
$g4_path = "../../.."; // common.php 의 상대 경로
include_once("$g4_path/common.php");

if (defined('G5_PATH'))
    header("Content-Type: text/html; charset=utf-8");
else
    header("Content-Type: text/html; charset=$g4[charset]");
