<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{


    $departements = $db->get("departements");
    $professeurs = $db->get("professeurs");
    $sessions = $db->get("sessions");
    if(!isset($departements)) $departements = array();
    if(!isset($professeurs)) $professeurs = array();
    if(!isset($sessions)) $sessions = array();


    function getRecordById($db, $id, $table="")
    {
        $db->where("id", $id);
        return $db->getOne($table);
    }

if(isset($_POST['submit']))
{

    //move_uploaded_file($_FILES["photo"]["tmp_name"],"cours/".$_FILES["photo"]["name"]);
    $fichiers = "";
    $ajouter_data =
        [
            'code' => $_POST["code"],
            'nom' => $_POST["nom"],
            'chapitre' => $_POST["chapitre"],
            'fichiers' => $fichiers,
            'departement' => $_POST["departement"],
            'session' => $_POST["session"],
            'professeur' => $_POST["professeur"],
        ];
    do {
        $db->where("id", $ajouter_data["departement"]);
        $dep = $db->getOne("departements");
        if (!isset($dep["departement"])) {
            $_SESSION['msg'] = "Département est pas existe !!";
            break;
        }

        $db->where("id", $ajouter_data["session"]);
        $sea = $db->getOne("sessions");
        if (!isset($sea["session"])) {
            $_SESSION['msg'] = "Session est pas existe !!";
            break;
        }

        $db->where("id", $ajouter_data["professeur"]);
        $sem = $db->getOne("professeurs");
        if (!isset($sem["professeur"])) {
            $_SESSION['msg'] = "Professeur est pas existe !!";
            break;
        }

        if(!isset($_FILES["fichiers"]["name"]))
        {
            $_SESSION['msg'] = "Veuillez choisir fichier du cours";
            break;
        }
        $fileTmpPath = $_FILES['fichiers']['tmp_name'];
        $fileName = $_FILES['fichiers']['name'];
        $fileSize = $_FILES['fichiers']['size'];
        $fileType = $_FILES['fichiers']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'rar', 'txt', 'xls', 'doc', 'pdf', 'docx');
        if (!in_array($fileExtension, $allowedfileExtensions)) {
            $_SESSION['msg'] = "Fichier extension n'est acceptable !! Vous pouvez choisir fichier de type : <br/> ('jpg', 'gif', 'png', 'zip', 'rar', 'txt', 'xls', 'doc', 'pdf', 'docx')";
            break;
        }
        $uploadFileDir = './cours/';
        $newFileName = md5("NiMO".$fileTmpPath.time()).'.'.$fileExtension;
        $dest_path = $uploadFileDir . $newFileName;

        if(!move_uploaded_file($fileTmpPath, $dest_path))
        {
            $_SESSION['msg'] = "Fichier n'est pas uploadé !! $fileTmpPath -> $dest_path ";
            break;
        }
        $ajouter_data["fichiers"] = $newFileName;


        if ($db->insert('cours', $ajouter_data)) {
            $_SESSION['msg'] = "Cours est ajouté avec success !!";
        } else {
            $_SESSION['msg'] = "Erreur : Cours n'est pas ajouté !!";//.$db->getLastQuery();
        }
        break;
    } while(0);




}
if(isset($_GET['del']))
      {
          $db->where("id", $_GET['id']);
          $etudiant = $db->getOne("cours");
          {
              $db->where("id", $_GET['id']);
              if ($db->delete('cours')) {
                  $_SESSION['delmsg'] = "Cours a est supprimé !!";
              }
              else
                  $_SESSION['delmsg'] = "Cours est n'est pas supprimé!!";
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
    <title>Admin | Cours</title>
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
                        <h1 class="page-head-line">Gerer les Cours  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                            Ajouter un Cours
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="dept" method="post" enctype="multipart/form-data">
   <div class="form-group">
    <label for="code">Code du cours </label>
    <input type="text" class="form-control" id="code" name="code" placeholder="Code du cours" required />
  </div>

 <div class="form-group">
    <label for="nom">Nom du Cours</label>
    <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom du Cours" required />
  </div>

<div class="form-group">
    <label for="chapitre">Chapitre du Cours  </label>
    <input type="text" class="form-control" id="chapitre" name="chapitre" placeholder="Chapitre du cours" required />
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
   <label for="fichiers">Charger les fichiers</label>
   <input type="file" class="form-control" id="fichiers" name="fichiers"  value="" />
</div>


 <button type="submit" name="submit" class="btn btn-default">Ajouter</button>
</form>
                            </div>
                            </div>
                    </div>
                  
                </div>
                <font color="red" align="center"><?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?></font>
                <div class="col-md-12">
                    <!--    Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Gestion de Cours
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Nom</th>
                                            <th>chapitre</th>
                                            <th>Département</th>
                                            <th>Session</th>
                                            <th>Professeur</th>
                                            <th>Date Insertion</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php

$cours = $db->get("cours");
$i = 0;
foreach($cours as $cour)
{
    $dep = getRecordById($db, $cour['departement'], "departements");
    $sea = getRecordById($db, $cour['session'], "sessions");
    $sem = getRecordById($db, $cour['professeur'], "professeurs");
$i++;
?>


                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo htmlentities($cour['code']);?></td>
                                            <td><?php echo htmlentities($cour['nom']);?></td>
                                            <td><?php echo htmlentities($cour['chapitre']);?></td>
                                            <td><?php echo htmlentities($dep['departement']);?></td>
                                            <td><?php echo htmlentities($sea['session']);?></td>
                                            <td><?php echo htmlentities($sem['professeur']);?></td>
                                            <td><?php echo htmlentities($cour['dateInsertion']);?></td>
                                            <td>
                                                <?php if(isset($cour['fichiers']) && !empty($cour['fichiers'])): ?>
                                                <a href="./cours/<?php echo $cour['fichiers']?>">
                                                    <button class="btn btn-primary">Télécharger</button>
                                                </a>
                                                <?php endif; ?>
                                                <a href="cours.php?id=<?php echo $cour['id']?>&del=delete" onClick="return confirm('Voulez vous vraiment supprimer ce cours?')">
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
