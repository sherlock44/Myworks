<?php
session_start();
session_unregister("username");      //����һ������
session_unregister("host");
session_unregister("user");
session_unregister("pwd");
echo "<script>window.location.href='index.php';</script>";
?>