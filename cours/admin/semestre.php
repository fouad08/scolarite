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
            'professeur' => $_POST["professeur"],
        ];
    if ($db->insert('professeurs', $ajouter_data)) {
        $_SESSION['msg'] = "Professeur est ajouté avec success !!";
    } else {
        $_SESSION['msg'] = "Erreur : Professeur n'est pas ajouté !!";//.$db->getLastQuery();
    }

}
if(isset($_GET['del']))
      {
          $db->where("id", $_GET['id']);
          $etudiant = $db->getOne("professeurs");
          {
              $db->where("id", $_GET['id']);
              if ($db->delete('professeurs')) {
                  $_SESSION['delmsg'] = "Professeur a est supprimé !!";
              }
              else
                  $_SESSION['delmsg'] = "Professeur est n'est pas supprimé!!";
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
    <title>Admin | Professeur</title>
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
                        <h1 class="page-head-line">Professeur  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                            Professeur
                        </div>
<font color="green" align="center"><?php  if(isset($_SESSION['msg']))echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="semester" method="post">
   <div class="form-group">
    <label for="semester">Ajouter Professeur  </label>
    <input type="text" class="form-control" id="professeur" name="professeur" placeholder="professeur" required />
  </div>
 <button type="submit" name="submit" class="btn btn-default">Ajouter</button>
</form>
                            </div>
                            </div>
                    </div>
                  
                </div>
                <font color="red" align="center"><?php  if(isset($_SESSION['delmsg'])) echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?></font>
                <div class="col-md-12">
                    <!--    Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Gerer Professeurs
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Professeur</th>
                                            <th>Date Insertion</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$professeurs = $db->get("professeurs");
$i = 0;
foreach($professeurs as $professeur)
{
    $i++;
?>


                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo htmlentities($professeur['professeur']);?></td>
                                            <td><?php echo htmlentities($professeur['dateInsertion']);?></td>
                                            <td>
  <a href="professeur.php?id=<?php echo $professeur['id']?>&del=delete" onClick="return confirm('Voulez vous vraiment supprimer cette semester?')">
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
