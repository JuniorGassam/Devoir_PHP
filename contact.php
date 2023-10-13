<?php 
require_once __DIR__."/lib/config.php";
require_once __DIR__."/templates/header.php"; 
?>


<?php 
    $messages = [];
    $errors = [];

    if (isset($_POST["sendContact"])) {
    //@todo gérer l'envoi d'email avec affichage de message et erreurs si email non valide ou message vide


    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Destinataire
    $destinataire = "destinataire@example.com";

    // Sujet de l'e-mail
    $sujet = "Sujet de l'e-mail";

    // En-têtes de l'e-mail
    $headers = "From: expediteur@example.com\r\n";
    $headers .= "Reply-To: expediteur@example.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Envoyer l'e-mail
    if (mail($destinataire, $sujet, $message, $headers)) {
        echo "L'e-mail a été envoyé avec succès.";
    } else {
        echo "L'envoi de l'e-mail a échoué.";
    }
}
?>

<h1>Contact</h1>

<?php foreach($messages as $message) { ?>
    <div class="alert alert-success">
        <?=$message; ?>
    </div>
<?php } ?>

<?php foreach($errors as $error) { ?>
    <div class="alert alert-success">
        <?=$error; ?>
    </div>
<?php } ?>
<form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
        </div>

        <input type="submit" name="sendContact" class="btn btn-primary" value="Envoyer">

    </form>
<?php require_once __DIR__."/templates/footer.php"; ?>

