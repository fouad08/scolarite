<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{
date_default_timezone_set('Africa/Casablanca');
$currentTime = date( 'Y-m-d H:i:s', time () );


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cne = $_SESSION['login'];
    $password = md5($_POST['cpass']);

    $db->where("password", $password);
    $db->where("cne", $cne);
    $etudiant = $db->getOne("etudiants");

    if (isset($etudiant["cne"])) {
        $etudiant_modifier_data =
            [
                'password' => md5($_POST['newpass']),
                'DateModification' => $currentTime,
            ];
        $db->where("cne", $cne);
        if ($db->update('etudiants', $etudiant_modifier_data)) {
            $result["status"] = "ok";
            $result["msg"] = "Mots de pass est modifié avec success !!";
        } else {
            $result["status"] = "err";
            $result["msg"] = "Mots de pass n'est pas modifié!!";
        }
    } else {
        $result["status"] = "err";
        $result["msg"] = "Mot de pass ancien n'est pas valide";
    }
    echo json_encode($result);
    exit;
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Mot de pass d'etudiant </title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
<?php include('includes/header.php');?>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['login']!="")
{
 include('includes/menubar.php');
}
 ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Etudiant - changement de mot de passe</h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Changer mot de passe
                        </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-xs-12">
<span color="red" id="results" align="center"><?php if(isset($_SESSION['msg'])) echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></span>
                                    </div>
                                </div>
                            </div>

                        <div class="panel-body">
                       <form name="chngpwd" action="change-password.php" method="post" id="form">
   <div class="form-group">
    <label for="exampleInputPassword1"> Mot de passe courant</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="cpass" placeholder="Password" />
  </div>
   <div class="form-group">
    <label for="exampleInputPassword1">Nouveau mot de passe</label>
    <input type="password" class="form-control" id="exampleInputPassword2" name="newpass" placeholder="Password" />
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Confirmation de mot de passe  </label>
    <input type="password" class="form-control" id="exampleInputPassword3" name="cnfpass" placeholder="Password" />
  </div>
 
  <button type="submit" name="submit" class="btn btn-default">Modifier</button>
                           <hr />
   



</form>
                            </div>
                            </div>
                    </div>
                  
                </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>

    <script type="text/javascript">

        $("#form").submit(function(event) {
           {

               if (document.chngpwd.cpass.value == "") {
                   alert("Mot de passe courant est vide !!");
                   document.chngpwd.cpass.focus();
                   return false;
               }
               else if (document.chngpwd.newpass.value == "") {
                   alert("Nouveau mot de passe est vide !!");
                   document.chngpwd.newpass.focus();
                   return false;
               }
               else if (document.chngpwd.cnfpass.value == "") {
                   alert("Mot de passe de confirmation est vide !!");
                   document.chngpwd.cnfpass.focus();
                   return false;
               }
               else if (document.chngpwd.newpass.value != document.chngpwd.cnfpass.value) {
                   alert("le nouveau mot de passe et le mot de passe de confirmation ne sont pas identiques !!");
                   document.chngpwd.cnfpass.focus();
                   return false;
               }


                event.preventDefault(); //prevent default action
                var post_url = $(this).attr("action"); //get form action url
                var request_method = $(this).attr("method"); //get form GET/POST method
                var form_data = $(this).serialize(); //Encode form elements for submission

                $.ajax({
                    type: request_method,
                    url: post_url,
                    dataType: "json",
                    data: form_data,
                    success: function (data) {
                        $("#results").removeClass("text-danger").removeClass("text-success").html("");
                        if (data.status == 'ok') {
                            if (data.msg)
                                $("#results").removeClass("text-danger").addClass("text-success").html(data.msg);
                            if (data.page)
                                window.location = data.page;
                        } else {
                            if (data.msg)
                                $("#results").removeClass("text-success").addClass("text-danger").html(data.msg);
                            if (data.page)
                                window.location = data.page;
                        }
                    }
                });
            }

        });
    </script>

    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
<?php } ?>
