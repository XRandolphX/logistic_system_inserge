<?php
session_unset();
session_destroy();
header('Location:' . base_url() . '/');
die();
ob_end_flush();