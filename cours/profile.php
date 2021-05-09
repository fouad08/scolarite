<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
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
if(isset($_POST['submit'])) {


    $nom = $_POST['nom'];
    $photo = $_FILES["photo"]["name"];

        if ($_FILES["photo"]["name"]) {
            $fileTmpPath = $_FILES['photo']['tmp_name'];
            $fileName = $_FILES['photo']['name'];
            $fileSize = $_FILES['photo']['size'];
            $fileType = $_FILES['photo']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $allowedfileExtensions = array('jpg', 'png', 'jpeg');
            if (!in_array($fileExtension, $allowedfileExtensions)) {
                $_SESSION['msg'] = "Fichier extension n'est acceptable !! Vous pouvez choisir fichier de type : <br/> ('jpg', 'jpeg', 'png')";
            }
            $uploadFileDir = './etudiant-photo/';
            $newFileName = md5("NiMO" . $fileTmpPath . time()) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (!move_uploaded_file($fileTmpPath, $dest_path)) {
                $_SESSION['msg'] = "Photo n'est pas chargé !! $fileTmpPath -> $dest_path ";
            }
            $photo = $newFileName;
            $etudiant_modifier_data =
                [
                    'nom' => $_POST['nom'],
                    'photo' => $photo,
                    'DateModification' => $currentTime
                ];
        }
        else
        $etudiant_modifier_data =
            [
                'nom' => $_POST['nom'],
                'DateModification' => $currentTime
            ];
        $db->where("cne", $_SESSION['login']);
        if ($db->update('etudiants', $etudiant_modifier_data)) {
            $_SESSION['msg'] = "Etudiant est modifié !!";
        } else {
            $_SESSION['msg'] = "Erreur : Etudiant n'est pas modifié";
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
    <title>Profile d'etudiant</title>
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
                        <h1 class="page-head-line">Profile de l'étudiant </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                             Profile de l'Etudiant 
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>
<?php
$db->where("cne", $_SESSION['login']);
$etudiant = $db->getOne("etudiants");

$dep = getRecordById($db, $etudiant['departement'], "departements");
//$sea = getRecordById($db, $cour['session'], "sessions");
//$sem = getRecordById($db, $cour['professeur'], "professeurs");
$cnt=1;
if(isset($etudiant["cne"]))
{ ?>

                        <div class="panel-body">
                       <form name="dept" method="post" enctype="multipart/form-data">
                           <div class="form-group">
                               <label for="studentname">Nom de l'étudiant  </label>
                               <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlentities($etudiant["nom"]);?>"  />
                           </div>


                           <div class="form-group">
                               <label for="departement">Département  </label>
                               <input type="text" class="form-control" id="nom" name="departement" value="<?php echo htmlentities($dep["departement"]);?>" readonly />
                           </div>

                           <div class="form-group">
                               <label for="studentregno">CNE de l'étudiant </label>
                               <input type="text" class="form-control" id="cne" name="cne" value="<?php echo htmlentities($etudiant["cne"]);?>"  placeholder="CNE d'etudiant" readonly />

                           </div>





<div class="form-group">
    <label for="Pincode">Photo de l'étudiant</label>
   <?php if(empty($etudiant['photo'])){ ?>
   <img src="etudiant-photo/noimage.png" width="200" height="200"><?php } else {?>
   <img src="etudiant-photo/<?php echo htmlentities($etudiant['photo']);?>" width="200" height="200">
   <?php } ?>
  </div>
<div class="form-group">
    <label for="photo">Ajouter votre photo</label>
    <input type="file" class="form-control" id="photo" name="photo"  value="<?php echo htmlentities($etudiant['photo']);?>" />
  </div>


  <?php } ?>

 <button type="submit" name="submit" id="submit" class="btn btn-default">Modifier</button>
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


</body>
</html>
<?php } ?>
