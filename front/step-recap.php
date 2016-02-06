<?php
/**
 * User: mverrecchia
 * Date: 01/07/13
 * Time: 16:15
 */

/*if (isset($_POST['devis'])){
    //check validity
    if (isset($_POST['key']) && $_POST['key'] == DevisUtils::saltDevis($_POST['devis'])){
        $devis = new Devis($_POST['devis']);
   
	}else{
	
        // @todo rediriger les hackers 
        header('Location:/');
   }
}else{
    //todo faire qq chose
}*/

?>

<h6 class="step-title">R&eacute;capitulatif : Merci de v&eacute;rifier les &eacute;l&eacute;ments ci-dessous puis valider votre demande</h6>
<div class="recap_gauche"> 
    <h4>Vous</h4>
        <ul>
            <li><span><?php echo $devis->getUtilisateur() ?></span></li>
            <li><span><?php echo $devis->getUtilisateur()->getAdresse() ?></span></li>
            <?php if($devis->getUtilisateur()->getComplementAdresse()): ?>
                <li><span><?php echo $devis->getUtilisateur()->getComplementAdresse() ?></span></li>
            <?php endif; ?>
            <li><span><?php echo $devis->getUtilisateur()->getCp() . ' ' . $devis->getUtilisateur()->getVille() ?></span></li>
        </ul>
    <h4>Votre v&eacute;hicule</h4>
        <ul>
            <li><?php echo $devis->getVehicule() ?></li>
            <li><?php echo $devis->getVehicule()->getKms() ?> kms</li>
        </ul>
</div>

<div class="recap_droite">
        <h4>Dommages d&eacute;clar&eacute;s</h4>
        <ul>
            <?php foreach ($devis->getDommages() as $dommage): ?>
                <li>
                    <h6>Pi&egrave;ce: <?php echo $dommage->getPiece() ?></h6>
                    <ul>
                        <li>Taille : <?php echo EnumTailleDommage::$libs[$dommage->getTaille()] ?></li>
                        <li>Type : <?php echo EnumTypeDommage::$libs[$dommage->getType()] ?></li>
                        <li>Peinture abîmée : <?php echo EnumPeintureDommage::$libs[$dommage->getPeinture()] ?></li>
                        <li>Commentaire : <?php echo htmlentities($dommage->getCommentaire()) ?></li>
                        <li>
                            Photos :
                            <?php $i=1; foreach($dommage->getPhotos() as $photo) : ?>
                                <span><a target="blank" href="<?php echo DevisUtils::getPhotoUrl($photo->getName()) ?>">photo <?php echo $i++ ?></a></span>
                            <?php endforeach; ?>
                        </li>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </li>
</ul>
</div>

<div class="recap_validation">

    <form class="fm-form form-devis" id="devis_dommage" method="post" action="">
        <input type="hidden" name="devis" value="<?php echo $devis->getId(); ?>" />
        <input type="hidden" name="key" value="<?php echo DevisUtils::saltDevis($devis->getId()); ?>" />
        <input type="hidden" name="action" value="<?php echo Action::VALIDATE ?>" />

        <input type="submit" name="fm_form_submit" id="fm_form_submit" class="submit" value="Valider">

    </form>

</div>

