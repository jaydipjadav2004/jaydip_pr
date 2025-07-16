<?php
session_start();
session_destroy();
header("Location: logi.php");
exit();