<?php
/**
 * User: maff
 * Date: 30/06/13
 */


switch($devis->getState()){

    case EnumDevisState::FINALISED:
        $do = 'mark_as_treated';
        $lib = 'Marquer ce devis comme traité';
        break;
    case EnumDevisState::TREATED:
        $do = 'mark_as_finalised';
        $lib = 'Marquer ce devis comme finalisé (à traiter)';
        break;
}

?>
<style>
#client h2{
color:#FFF;
}
</style>
<div id="client">
    <h2>Client</h2>
    <ul>
        <li style="font-size:16px;"><span><strong><?php echo $devis->getUtilisateur() ?></strong></span></li>
        <?php if($devis->getUtilisateur()->getSociete()): ?>
            <li><span><strong>Société :</strong> <?php echo $devis->getUtilisateur()->getSociete() ?></span></li>
        <?php endif; ?>
        <li><span><strong>Adresse :</strong> <?php echo $devis->getUtilisateur()->getAdresse() ?></span></li>
        <?php if($devis->getUtilisateur()->getComplementAdresse()): ?>
            <li><span><?php echo $devis->getUtilisateur()->getComplementAdresse() ?></span></li>
        <?php endif; ?>
        <li><span><?php echo $devis->getUtilisateur()->getCp() . ' ' . $devis->getUtilisateur()->getVille() ?></span></li>
        <li><span><strong>Email :</strong> <?php echo $devis->getUtilisateur()->getEmail() ?></span></li>
        <?php if($devis->getUtilisateur()->getComplementAdresse()): ?>
            <li><span><?php echo $devis->getUtilisateur()->getPays() ?></span></li>
        <?php endif; ?>
        <li><span><strong>Téléphone :</strong>
            <?php echo $devis->getUtilisateur()->getTel() ?>
            <?php if($devis->getUtilisateur()->getMobile()): ?>
                / <?php echo $devis->getUtilisateur()->getMobile() ?>
            <?php endif; ?>
        </span></li>

    </ul>
</div>

<div id="vehicule">
    <h2>Véhicule</h2>
    <ul>
        <li><strong>Modèle :</strong> <?php echo $devis->getVehicule() ?></li> 
        <li><strong>Immatriculation :</strong> <?php echo $devis->getVehicule()->getImmatriculation() ?></li>
        <li><strong>Kilométrage :</strong> <?php if($devis->getVehicule()->getKms()): ?>
		<?php echo $devis->getVehicule()->getKms() ?> kms</li>
        <?php endif; ?>
        <?php if($devis->getVehicule()->getNumeroChassis()): ?>
            <li>Numéro de chassis : <?php echo $devis->getVehicule()->getNumeroChassis() ?></li>
        <?php endif; ?>
    </ul>
</div>


<div id="dommages">
    <h2>Dommages d&eacute;clar&eacute;s</h2>
    <ul>
        <?php foreach ($devis->getDommages() as $dommage): ?>
            <li>
                <h3>Pi&egrave;ce: <?php echo $dommage->getPiece() ?></h3>
                <ul>
                    <li>Type : <?php echo EnumTypeDommage::$libs[$dommage->getType()] ?></li>
                    <li>Taille : <?php echo EnumTailleDommage::$libs[$dommage->getTaille()] ?></li>
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
</div>

<div id="actions">
    <h2>Etat : <?php echo EnumDevisState::$libs[$devis->getState()] ?></h2>

    <?php if($lib): ?>
        <a href="?page=<?php echo $page ?>&do=<?php echo $do ?>&id=<?php echo $devis->getId(); ?>"><?php echo $lib ?></a>
    <?php endif; ?>
</div>
