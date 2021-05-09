<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else {

    date_default_timezone_set('Africa/Casablanca');
    $currentTime = date( 'Y-m-d H:i:s', time () );


    $departements = $db->get("departements");
    $professeurs = $db->get("professeurs");
    $sessions = $db->get("sessions");
    if(!isset($departements)) $departements = array();
    if(!isset($professeurs)) $professeurs = array();
    if(!isset($sessions)) $sessions = array();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'];
        $cne = $_POST['cne'];
        $password = md5($_POST['password']);
        $pincode = rand(100000, 999999);
        $departement = $_POST['departement'];
        $session = $_POST['session'];
        $professeur = $_POST['professeur'];

        $etudiant_ajouter_data =
            [
                'password' => $password,
                'nom' => $nom,
                'cne' => $cne,
                'departement' => $departement,
                'session' => $session,
                'professeur' => $professeur,
                'dateInsertion' => $currentTime,
                'pincode' => $pincode
            ];
        if ($db->insert('etudiants', $etudiant_ajouter_data)) {
            $result["status"] = "ok";
            $result["msg"] = "Etudiant  ajouté avec succes !!";

        } else {
            $result["status"] = "err";
            $result["msg"] = "Erreur : Etudiant n'est pas ajouté !!";//.$db->getLastQuery();
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
    <title>Admin | Inscription de l'Etudiant</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php');?>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['alogin']!="")
{
 include('includes/menubar.php');
}
 ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Inscription de l'Etudiant </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                            Inscription de l'Etudiant
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12">
                                    <span id="results" color="red" id="results" align="center"><?php if(isset($_SESSION['msg'])) echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                       <form name="dept" action="inscription-etudiant.php" method="post" id="form">
   <div class="form-group">
    <label for="studentname">Nom de l'Etudiant  </label>
    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom de l'Etudiant" required />
  </div>

 <div class="form-group">
    <label for="studentregno">CNE de l'Etudiant </label>
    <input type="text" class="form-control" id="cne" name="cne" onBlur="userAvailability()" placeholder="CNE de l'Etudiant" required />
     <span id="user-availability-status1" style="font-size:12px;">
  </div>


   <div class="form-group">
       <label for="departementSelect">Choisir Departement</label>
       <select  class="form-control" id="departementSelect" name="departement">
           <?php for($i=0;$i<count($departements);$i++) : ?>
           <option value="<?php echo $departements[$i]["id"] ?>"><?php echo $departements[$i]["departement"] ?></option>
           <?php endfor;?>
       </select>
   </div>

   <div class="form-group">
       <label for="sessionsSelect">Choisir Session</label>
       <select  class="form-control" id="sessionsSelect" name="session">
           <?php for($i=0;$i<count($sessions);$i++) : ?>
               <option value="<?php echo $sessions[$i]["id"] ?>"><?php echo $sessions[$i]["session"] ?></option>
           <?php endfor;?>
       </select>
   </div>

   <div class="form-group">
       <label for="professeurSelect">Choisir Professeur</label>
       <select  class="form-control" id="professeurSelect" name="professeur">
           <?php for($i=0;$i<count($professeurs);$i++) : ?>
               <option value="<?php echo $professeurs[$i]["id"] ?>"><?php echo $professeurs[$i]["professeur"] ?></option>
           <?php endfor;?>
       </select>
   </div>

<div class="form-group">
    <label for="password">Mot de passe </label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required />
  </div>   

 <button type="submit" name="submit" id="submit" class="btn btn-default">Inscrire</button>
</form>
                            </div>
                            </div>
                    </div>
                  
                </div>

            </div>





        </div>
    </div>
  <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.11.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
<script>
function userAvailability() {
    $("#loaderIcon").show();
    jQuery.ajax({
    url: "check_availability.php",
    data:'cne='+$("#cne").val(),
    type: "POST",
    success:function(data){
    $("#user-availability-status1").html(data);
    $("#loaderIcon").hide();
    },
    error:function (){}
    });
}
</script>


<script type="text/javascript">

    $("#form").submit(function(event) {
        {
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



</body>
</html>
<?php } ?>
