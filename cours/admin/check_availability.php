<?php 
require_once("includes/config.php");
if(!empty($_POST["cne"])) {
    $cne = $_POST['cne'];
    $db->where("cne", $cne);
    $etudiant = $db->getOne("etudiants");
    if (isset($etudiant["cne"])) {
        echo "<span style='color:red'>Etudiant avec ce CNE est déja inscris</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else {

        echo "<script>$('#submit').prop('disabled',false);</script>";
    }
}


