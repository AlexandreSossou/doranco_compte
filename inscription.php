<?php


// ###### ETAPE 1 - Inclusion des données ######
require_once "inc/init.php";

// ###### ETAPE 2 - Traitement des données du formulaire######
// je verifie si le formulaire a été validé.
if (!empty($_POST)) {
    debug($_POST);



    // ###### ETAPE de verification des données ######
        if(empty($_POST['username'])){
            $errorMessage .= "Merci d'indiquer un Pseudo <br>";
        }

        if (iconv_strlen( trim($_POST['username'] )) < 3 || iconv_strlen( trim($_POST['username'] )) > 20) {
            $errorMessage .= "Le pseudo doit contenir entre 3 et 20 caractères.<br>";
        }

        if (empty($_POST['password']) || iconv_strlen(trim($_POST['password'])) < 8 ) {
            $errorMessage .= "Merci d'indiquer un mot de passe de minimum 8 caractères. <br>";
        }

        if (empty($_POST['lastname']) || iconv_strlen(trim($_POST['lastname'])) > 70 ) {
            $errorMessage .= "Merci d'indiquer un nom de max 70 caractères. <br>";
        }

        if (empty($_POST['firstname']) || iconv_strlen(trim($_POST['firstname'])) > 70 ) {
            $errorMessage .= "Merci d'indiquer un prénom de max 70 caractères. <br>";
        }
        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
            $errorMessage .= "L'email n'est pas valide<br>";
        }
    // ###### Fin de vérification des données ######

    // ###### ETAPE DE SÉCURISATION DES DONNÉES #####
        //$_POST['username'] = htmlspecialchars($_POST['username']); méthode longue (car doit être dupliqué...)
        foreach($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars($value, ENT_QUOTES);  // méthode rapide. transforme les chevrons et guillemets en leur entité html.
        // ##### obligatoire si l'on récupère des données utilisateurs.
        }
    // ###### FIN DE SÉCURISATION des données ######

    // ###### ETAPE envoi des données ######
        if (empty($errorMessage)) {
            $requete = $bdd->prepare("INSERT INTO membre VALUES (NULL, :username, :password, :lastname, :firstname, :email, :status)");
            $success = $requete->execute([
            "username" => $_POST["username"],
            "password" => password_hash($_POST["password"],PASSWORD_DEFAULT), // la fonction PasswordHash pour cacher le mdp.
            "lastname" => $_POST["lastname"],
            "firstname" => $_POST["firstname"],
            "email" => $_POST["email"],
            "status" => "user"
        ]);
    // ###### FIN ENVOI DES données ######

    if ($success) {
        $successMessage = "Inscription successful";

        // Introduction a la session : Fichier temporaire appelé sess_***** qui est stocké sur le serveur. Chaque fichier est lié a un internaute

        // On déclare la session avec session_start()
        // Le fichier de session peut contenir toutes sorte d'information, y compris des info sensible. (mdp, carte bancaire etc) 
        //car ce fichier n'est pas accessible par l'utilisateur
        // Une fois session_start() est lu on a accès à la superglobale $_session pour récup les infos ou en ajouter. 
        //Pour ajoute une info on appele $_session suivi d'un indice et de sa valeur. si l'indice existe déjà ça valeur sera remplacer sinon elle sera créée.
        // Les info présente dans la session ne sont pas supprimer automatiquement mais par la fonction unset()


        $_SESSION["successMessage"] = "Inscription successful";
        
        // si ma requete a fonctionné je veux être redirigé vers la page de connexion
        header("location:connexion.php");
        exit; // après la fonction header on place régulièrement une execution exit. pour éviter le hacking.
    } else {
        $errorMessage = "Inscription failed";
    }
        }

        
}



require_once "inc/header.php";
?>

<h1 class="text-center">Inscription</h1>

<?php if(!empty($successMessage)){ ?>
    <div class="alert alert-success col-md-6 text-center mx-auto">
        <?php echo $successMessage ?>
    </div>
<?php }?>

<?php if(!empty($errorMessage)){ ?>
    <div class="alert alert-danger col-md-6 text-center mx-auto">
        <?php echo $errorMessage ?>
    </div>
<?php }?>


<form action="" method="post" class="col-md-6 mx-auto">

    <label for="username" class="form-label">Username</label>
    <input 
        type="text" 
        name="username" 
        id="username" 
        class="form-control" 
        value="<?php echo $_POST['username'] ?? "" ?>" 
         
    >
    <div class="invalid-feedback"></div>

    <label for="password" class="form-label">Mot de Passe</label>
    <input type="password" name="password" id="password" class="form-control">
    <div class="invalid-feedback"></div>

    <label for="lastname" class="form-label" >Nom</label>
    <input type="text" name="lastname" id="lastname" class="form-control" value="<?= $_POST['lastname'] ?? "" ?>">
    <div class="invalid-feedback"></div>

    <label for="firstname" class="form-label" >Prénom</label>
    <input type="text" name="firstname" id="firstname" class="form-control" value="<?= $_POST['firstname'] ?? "" ?>">
    <div class="invalid-feedback"></div>

    <label for="email" class="form-label" >Email</label>
    <input type="email" name="email" id="email" class="form-control" value="<?= $_POST['email'] ?? "" ?>">
    <div class="invalid-feedback"></div>

    <button class="btn btn-success d-block mx-auto mt-3">S'inscrire</button>

</form>


<?php
require_once "inc/footer.php";
