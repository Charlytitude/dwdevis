<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mverrecchia
 * Date: 08/07/13
 * Time: 18:41
 * To change this template use File | Settings | File Templates.
 */

$message="";
$message.= "Madame, Monsieur,\n\n";

$message.= "Vous avez saisi une demande de devis sur notre site Dentwizard et nous vous en remercions.\n";
$message.= "Cependant, il semble que celle-ci ait été inachevée.\n\n";

$message.= "Pourriez-vous nous en communiquer les raisons sur le lien ci-contre ". DWDevisApplication::getQuestionnaireUrl() ."\n";

$message.= "Cette action vous prendra moins de 30 secondes, mais nous permettra d'optimiser fortement notre qualité de service.\n\n";

$message.= "Merci de la confiance que vous accordez à Carméléon.\n\n";

$message.="Service Administration des Ventes\n\n";

$message.="Société Dentmaster\n";
$message.="20 Boulevard Eugène Deruelle\n";
$message.="Le Britannia - Bâtiment A\n";
$message.="69432 LYON Cedex 03\n\n";

$message.="Tél. direct : 04 37 91 32 22 - Fax : 04 37 91 32 26\n\n";

$message.="Visitez nos sites web ! \n";
$message.="www.carmeleon.fr\n";
$message.="www.dentmaster.fr\n";
$message.="www.dentwizard.fr\n";


$subject = "Votre demande de devis Dentwizard sur le site www.dentwizard.fr" ;
$headers = "From: ". DWDevisApplication::$mailfrom ."\n";

$MailOK = wp_mail($devis->getUtilisateur()->getEmail(), $subject, $message, $headers);

if ($MailOK) {
    $devis->setMailSent(true);
    $devis->save();
    DWDevisApplication::registerFlashBag(FlashBag::SUCCES, 'Votre message a été envoyé avec succès');
}else{
    DWDevisApplication::registerFlashBag(FlashBag::ERROR, 'Une erreur est survenue lors de l\'envoi de l\'e-mail. Pensez à vérifier la configuration smtp de votre serveur.');
}
