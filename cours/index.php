<?php
session_start();
//error_reporting(0);
include("includes/config.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cne = $_POST['cne'];
    $password = md5($_POST['password']);

    $db->where("password", $password);
    $db->where("cne", $cne);
    $etudiant = $db->getOne("etudiants");

    if (isset($etudiant["cne"])) {
        $extra = "change-password.php";//
        $_SESSION['login'] = $etudiant['cne'];
        $_SESSION['id'] = $etudiant['cne'];
        $_SESSION['enom'] = $etudiant['nom'];
        $uip = $_SERVER['REMOTE_ADDR'];
        $status = 1;
        $log_data =
            [
                'cne' => $_SESSION['login'],
                'userip' => $uip,
                'status' => $status
            ];
        $id = $db->insert('userlog', $log_data);
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $result["status"] = "ok";
        $result["page"] = "http://$host$uri/$extra";
    }
    else {

        $result["status"] = "err";
        $result["msg"] = "Cne ou mot de pass pas valide";
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

    <title>Etudiant identification</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
    <?php include('includes/header.php');?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Veillez s'identifier pour continuer</h4>
                </div>
            </div>
             <span id="results" style="color:red;" ><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></span>
            <form name="admin" action="index.php" id="form" method="post">
            <div class="row">
                <div class="col-md-6">
                     <label>Entrer CNE : </label>
                        <input type="text" name="cne" class="form-control"  />
                        <label>Entrer votre Mot de passe :  </label>
                        <input type="password" name="password" class="form-control"  />
                        <hr />
                        <button type="submit" name="submit" class="btn btn-info"><span class="glyphicon glyphicon-user"></span> &nbsp;S'identifier </button>&nbsp;
                </div>
                </form>
                <div class="col-md-6">
                    <div class="alert alert-info">
                        This is a free bootstrap admin template with basic pages you need to craft your project. 
                        Use this template for free to use for personal and commercial use.
                        <br />
                         <strong> Some of its features are given below :</strong>
                        <ul>
                            <li>
                                Responsive Design Framework Used
                            </li>
                            <li>
                                Easy to use and customize
                            </li>
                            <li>
                                Font awesome icons included
                            </li>
                            <li>
                                Clean and light code used.
                            </li>
                        </ul>
                       
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

    <script>


        $("#form").submit(function(event){
            event.preventDefault(); //prevent default action
            var post_url = $(this).attr("action"); //get form action url
            var request_method = $(this).attr("method"); //get form GET/POST method
            var form_data = $(this).serialize(); //Encode form elements for submission


            $.ajax({
                type:request_method,
                url:post_url,
                dataType: "json",
                data:form_data,
                success:function(data){
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

        });
    </script>


    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
