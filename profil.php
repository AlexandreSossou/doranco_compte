<?php

require_once "inc/init.php";

// si la personne n'est pas co, on la redirige vers la page de connexion.
if(!isConnected()){
    header("location:connexion.php");
    exit;
}

debug($_SESSION);


require_once "inc/header.php";
?>

<?php if (!empty($_SESSION['successMessage'])) { ?>
    <div class="alert alert-success col-md-6 text-center mx-auto">
        <?php echo $_SESSION['successMessage'] ?>
    </div>
    <?php unset($_SESSION['successMessage']); ?>
<?php } ?>

<?php if (!empty($errorMessage)) { ?>
    <div class="alert alert-danger col-md-6 text-center mx-auto">
        <?php echo $errorMessage ?>
    </div>
<?php } ?>

<div class="container mt-4 mb-4 p-3 d-flex justify-content-center"> 
<div class="card p-4"> 
    <div class=" image d-flex flex-column justify-content-center align-items-center"> 
        <button class="btn btn-secondary"> 
            <img src="boy.png" height="100" width="100" />
        </button> 
        
        <span class="name mt-3" <?= $_SESSION['membre']['firstname'] ." ". $_SESSION['membre']['lastname'] ?> >
        
        </span> 
        
        <span class="idd">@<?= $_SESSION['membre']['username']?></span> 
        
        <div class="text mt-3 text-center"> 
            <span>
            <?= $_SESSION['membre']['e-mail']?><br>
            <?= $_SESSION['membre']['status']?><br>
            </span>
        </div>
        
        <div class=" d-flex mt-2"> 
            <button class="btn1 btn-dark">Modifier Profil</button> 
        </div> 
    </div> 
</div>
</div>



<?php
require_once "inc/footer.php";
