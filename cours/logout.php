<?php
session_start();
include("includes/config.php");
date_default_timezone_set('Africa/Casablanca');
$ldate=date( 'Y-m-d H:i:s', time () );
$db->where("cne", $_SESSION["login"]);

$_SESSION = array();
session_unset();
$userlog_modifier_data =
    [
        'dateLogout' => $ldate
    ];
if ($db->update('userlog', $userlog_modifier_data))
    $_SESSION['errmsg'] = "You have successfully logout";
else
    $_SESSION['errmsg'] = "Erreur : You have not logout yet";

?>
<script language="javascript">
document.location="index.php";
</script>
