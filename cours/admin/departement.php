<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
    $ajouter_data =
        [
            'departement' => $_POST["departement"],
        ];
    if ($db->insert('departements', $ajouter_data)) {
        $_SESSION['msg'] = "departement est ajouté avec success !!";
    } else {
        $_SESSION['msg'] = "Erreur : departement n'est pas ajouté !!";//.$db->getLastQuery();
    }
}
if(isset($_GET['del']))
      {
          $db->where("id", $_GET['id']);
          $etudiant = $db->getOne("departements");
          {
              $db->where("id", $_GET['id']);
              if ($db->delete('departements')) {
                  $_SESSION['delmsg'] = "Département a est supprimé !!";
              }
              else
                  $_SESSION['delmsg'] = "Département est n'est pas supprimé!!";
          }
      }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Département</title>
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
                        <h1 class="page-head-line">Département  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                            Département
                        </div>
<font color="green" align="center"><?php if(isset($_SESSION['delmsg'])) echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="dept" method="post">
   <div class="form-group">
    <label for="departement">Ajouter Département  </label>
    <input type="text" class="form-control" id="departement" name="departement" placeholder="Département" required />
  </div>
 <button type="submit" name="submit" class="btn btn-default">Ajouter</button>
</form>
                            </div>
                            </div>
                    </div>
                  
                </div>
                <font color="red" align="center"><?php if(isset($_SESSION['delmsg'])) echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?></font>
                <div class="col-md-12">
                    <!--    Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Gérer Département
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Département</th>
                                            <th>Date Insertion</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$departements = $db->get("departements");
$i = 0;
foreach($departements as $departement)
{
$i++;
?>


                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo htmlentities($departement['departement']);?></td>
                                            <td><?php echo htmlentities(@$departement['dateInsertion']);?></td>
                                            <td>
  <a href="departement.php?id=<?php echo $departement['id']?>&del=delete" onClick="return confirm('Voulez vous vraiment supprimer cette departement?')">
                                            <button class="btn btn-danger">Supprimer</button>
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
