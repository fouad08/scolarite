<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{

    function getRecordById($db, $id, $table="")
    {
        $db->where("id", $id);
        return $db->getOne($table);
    }

    date_default_timezone_set('Africa/Casablanca');
    $currentTime = date( 'Y-m-d H:i:s', time () );

if(isset($_GET['del']))
      {
          $db->where("cne", $_GET['id']);
          $etudiant = $db->getOne("etudiants");
          {
              $db->where("cne", $_GET['id']);
              if ($db->delete('etudiants')) {
                  $_SESSION['delmsg'] = "Etudiant est supprimé !!";
              }
              else
                  $_SESSION['delmsg'] = "Etudiant est n'est pas supprimé!!";
/*              $result["status"] = "ok";
              $result["msg"] = "Etudiant est ajouté avec success !!";
              $_SESSION['delmsg']="Etudiant est ajouté avec success !!";*/
             // echo json_encode($result);
            //  exit;
          }
      }

     if(isset($_GET['pass']))
      {
          $reset_password="Test@123";
          $etudiant_modifier_data =
              [
                  'password' => md5($reset_password),
                  'DateModification' => $currentTime,
              ];
          $db->where("cne", $_GET['id']);
          if ($db->update('etudiants', $etudiant_modifier_data)) {
             // $result["status"] = "ok";
             // $result["msg"] = "Mots de pass est initializé avec => '$reset_password' !!";
              $_SESSION['delmsg']="Mots de pass est initializé avec => '$reset_password' !!";
          } else {
            //  $result["status"] = "err";
             // $result["msg"] = "Mots de pass n'est pas initializé !!";
              $_SESSION['delmsg']="Mots de pass n'est pas initializé !!";
          }
      //    echo json_encode($result);
       //   exit;
          //$_SESSION['delmsg']="Password Reset. New Password is Test@123";
      } 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Etudiants</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php');?>
    <!-- LOGO HEADER END-->
<?php if(isset($_SESSION['alogin']))
{
 include('includes/menubar.php');
}
 ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Etudiants</h1>
                    </div>
                </div>
                <div class="row" >
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <span id="results" color="red" id="results" align="center"><?php if(isset($_SESSION['delmsg'])) echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['msg']="");?></span>
                            </div>
                        </div>
                    </div>
                <div class="col-md-12">
                    <!--    Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Gerer Les Etudiants
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>CNE</th>
                                            <th>Nom</th>
                                            <th>Departement</th>
                                            <th>Session</th>
                                            <th>Professeur</th>
                                             <th>Date d'insription</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$etudiants = $db->get("etudiants");
$i = 0;
foreach($etudiants as $etudiant)
{
    $dep = getRecordById($db, $etudiant['departement'], "departements");
    $sea = getRecordById($db, $etudiant['session'], "sessions");
    $sem = getRecordById($db, $etudiant['professeur'], "professeurs");
    $i++;
?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo htmlentities($etudiant['cne']);?></td>
                                            <td><?php echo htmlentities($etudiant['nom']);?></td>
                                            <td><?php echo htmlentities($dep['departement']);?></td>
                                            <td><?php echo htmlentities($sea['session']);?></td>
                                            <td><?php echo htmlentities($sem['professeur']);?></td>
                                            <td><?php echo htmlentities($etudiant['dateInsertion']);?></td>
                                            <td>
<a href="gerer-etudiants.php?id=<?php echo $etudiant['cne']?>&del=delete" onClick="return confirm('Voulez vous vraiment supprimer cet etudiant?')">
                                            <button class="btn btn-danger">Supprimer</button>
</a>
<a href="gerer-etudiants.php?id=<?php echo $etudiant['cne']?>&pass=update" onClick="return confirm('Voulez vous vraiment initializer le mot de pass de cet etudiant?')">
<button type="submit" name="submit" id="submit" class="btn btn-default">Initialize mot de passe</button>
</a>
                                            </td>
                                        </tr>
<?php
} ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     <!--  End  Bordered Table  -->
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
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
<?php } ?>
