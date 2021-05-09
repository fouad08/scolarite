<?php
include("includes/config.php");
if(isset($_SESSION["login"]))
{
    $db->where("cne", $_SESSION['login']);
    $userlog = $db->getOne("userlog");
}



//error_reporting(0);
?>
<?php if(isset($_SESSION['login']))
{?>
<header>
        <div class="container">
            <?php if(isset($userlog)) { ?>
            <div class="row">
                <div class="col-md-12">
                    <strong>Welcome: </strong><?php echo htmlentities($_SESSION['enom']);?>
                    <strong>Last Login:<?php  echo $userlog['userip']; ?> at <?php echo $userlog['dateLogin'];?></strong>
                </div>
            </div>
            <?php } ?>
        </div>
    </header>
    <?php } ?>
    <!-- HEADER END-->
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                     <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#" style="color:#fff; font-size:24px;4px; line-height:24px; ">
                          Votre Platforme de Cours en Informatiques
                        </a>

                    </div>
                </div>
                <div class="col-md-6">
                    <img src="assets/img/logo-fs.png" style="width: auto; height: 200px;" class="img-responsive pull-right">
                </div>
            </div>


           

            
            </div>
        </div>
