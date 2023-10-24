<?php
//logut syntax
session_start();
session_destroy();
header("Location: login.php");
