<?php

session_start();

require_once __DIR__ . "/../functions/helpers.php";

/**
 * ************************************************************
 * Traitement des données provenant du formulaire
 * ************************************************************
 */

// 1. Si les données arrivent via la méthode POST
if ("POST" === $_SERVER['REQUEST_METHOD']) {

    // 2. Alors, penser à bien sécuriser l'application contre certains types de faille
    // 2a. Sécuriser le serveur contre les failles de type CSRF
    if (
        !isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) ||
        empty($_SESSION['csrf_token']) || empty($_POST['csrf_token']) ||
        $_SESSION['csrf_token'] !== $_POST['csrf_token']
    ) {
       redirectToPage("create");
    
        header("Location: create.php");
        exit;
    }

    
    unset($_SESSION['csrf_token']);
    unset($_POST['csrf_token']);

    dd("Continuer la partie");
    

    //2b.  Protéger le serveur contre les robots spammeurs
    if (!isset($_POST['honey_pot']) || ( "" !== $_POST['honey_pot']) ) {
         redirectToPage("create");
    }
    unset($_POST['csrf_token']);

    // 3. Définir les contraintes de validation des input, et préparer les messages d'erreur correspondant
    if (!isset($_POST['title']) ) {
        trim($_POST['title']);
    }

    // 4. Si le système détecte au moins une erreur

    // 4a. Sauvegarder les messages d'erreur preparés en sessions
    //   4b. Effectuer une redirection vers la page de laquelle proviennent les infos,
    //  puis arrêter l'exécution du script.

    // Dans le cas contraire,
    // 5. Arrondir la note à un chiffre après la virgule

    // 6. Etablir une connexion avec la base de données

    // 7. Effectuer la requête d'insertion du nouveau film en base de données

    // 8. Sauvegarder en session le message flash de succès de l'opération

    // 9. Effectuer une redirection vers la page d'accueil,
    // Puis arrêter l'exécution du script.
}

// Générer une chaîne de caractère aléatoire (csrf_token: Jeton de sécurité)
// ➜ uniquement quand on affiche le formulaire (GET)

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

?>

<?php include_once __DIR__ . "/../partials/head.php"; ?>

<?php include_once __DIR__ . "/../partials/nav.php"; ?>

<!-- Main - le contenu spécifique à cette page-->
<main class="container">
    <h1 class="text-center display-5 my-3 mb-4">Nouveau film</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-4 mx-auto bg-white shadow rounded p-4">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="title">Titre <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" autofocus required>
                    </div>

                    <div class="mb-3">
                        <label for="rating">Note /5</label>
                        <input inputmode="decimal" type="number" name="rating" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="comment">Laissez un commentaire</label>
                        <textarea name="comment" id="comment" class="form-control" rows="4"></textarea>
                    </div>

                    <div>
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <input type="hidden" name="honey_pot" value="null">
                    </div>

                    <div>
                        <input type="submit" class="btn btn-primary w-100" value="Ajouter">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include_once __DIR__ . "/../partials/footer.php"; ?>



