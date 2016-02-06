<?php
/**
 * User: maff
 * Date: 29/06/13
 */
?>
<style>
.message{
	background-color:#FF7D00;
	color:#FFF;
	width:800px;
	padding:10px;
	text-transform:uppercase; }
</style>

<h6 class="step-title">&Eacute;tape 1 : Compl&eacute;tez les champs d'information qui nous permettront de vous contacter</h6>
<div class="message"><strong>ATTENTION :</strong> Plusieurs photos de vos dommages nous seront indispensables afin de réaliser votre devis. <br />
Afin de gagner du temps, nous vous conseillons de réaliser vos clichés avant de remplir le formulaire de demande. Merci.</div>
<br />

<?php if (count($errors) > 0): ?>
    <div class="devis-error-message"><p>Merci de bien vouloir saisir tous les champs obligatoires.</i></p></div>
<?php endif; ?>

<div class="vc_span8 wpb_column column_container">


    <form class="fm-form form-devis" id="devis_identification" action="" method="post">
    <input type="hidden" name="action" value="<?php echo Action::SAVE_IDENTIFICATION ?>" />

    <h4><span>Vous</span></h4>
    <ul>
       <li>
           <label<?php if($errors['civilite']) echo ' class="error"'; ?>>Civilit&eacute; <em>*</em>:</label>
           <span>
               <select name="civilite">
                   <?php foreach(EnumCivilite::getConstants() as $civilite): ?>
                       <option <?php if ($devis->getUtilisateur()->getCivilite() == $civilite) { echo " selected " ; } ?> value="<?php echo $civilite; ?>"><?php echo $civilite; ?></option>
                   <?php endforeach; ?>
               </select>
           </span>
       </li>
        <li>
            <label<?php if($errors['nom']) echo ' class="error"'; ?>>Nom <em>*</em></label>
            <span>
                <input type="text" name="nom" value="<?php echo htmlspecialchars($devis->getUtilisateur()->getNom()); ?>" placeholder="Nom">
            </span>
        </li>
        <li>
            <label<?php if($errors['prenom']) echo ' class="error"'; ?>>Pr&eacute;nom <em>*</em></label>
            <span>
                <input type="text" name="prenom" value="<?php echo htmlspecialchars($devis->getUtilisateur()->getPrenom()); ?>" placeholder="Pr&eacute;nom">
            </span>
        </li>
        <li>
            <label<?php if($errors['societe']) echo ' class="error"'; ?>>Soci&eacute;t&eacute;</label>
            <span>
                <input type="text" name="societe" value="<?php echo htmlspecialchars($devis->getUtilisateur()->getSociete()); ?>" placeholder="Soci&eacute;t&eacute;">
            </span>
        </li>
        <li>
            <label<?php if($errors['code_client']) echo ' class="error"'; ?>>Code avantage</label>
            <span>
                <input type="text" name="code_client" value="<?php echo htmlspecialchars($devis->getUtilisateur()->getCodeClient()); ?>" placeholder="Code avantage">
            </span>
        </li>
        <li>
            <label<?php if($errors['adresse']) echo ' class="error"'; ?>>Adresse <em>*</em></label>
            <span>
                <input type="text" name="adresse" value="<?php echo htmlspecialchars($devis->getUtilisateur()->getAdresse()); ?>" placeholder="Adresse">
            </span>
        </li>
        <li>
            <label<?php if($errors['complement_adresse']) echo ' class="error"'; ?>>Compl&eacute;ment adresse</label>
            <span>
                <input type="text" name="complement_adresse" value="<?php echo htmlspecialchars($devis->getUtilisateur()->getComplementAdresse()); ?>" placeholder="Compl&eacute;ment adresse">
            </span>
        </li>
        <li>
            <label<?php if($errors['cp']) echo ' class="error"'; ?>>Code postal <em>*</em></label>
            <span>
                <input type="text" name="cp" value="<?php echo htmlspecialchars($devis->getUtilisateur()->getCp()); ?>" placeholder="Code postal">
            </span>
        </li>
        <li>
            <label<?php if($errors['ville']) echo ' class="error"'; ?>>Ville <em>*</em></label>
            <span>
                <input type="text" name="ville" value="<?php echo htmlspecialchars($devis->getUtilisateur()->getVille()); ?>" placeholder="Ville">
            </span>
        </li>
        <li>
            <label<?php if($errors['pays']) echo ' class="error"'; ?>>Pays</label>
            <span>
                <input type="text" name="pays" value="<?php echo htmlspecialchars($devis->getUtilisateur()->getPays()); ?>" placeholder="Pays">
            </span>
        </li>
        <li>
            <label<?php if($errors['tel']) echo ' class="error"'; ?>>T&eacute;l&eacute;phone 1 <em>*</em></label>
            <span>
                <input type="text" name="tel" value="<?php echo htmlspecialchars($devis->getUtilisateur()->getTel()); ?>" placeholder="T&eacute;l&eacute;phone 1">
            </span>
        </li>
        <li>
            <label<?php if($errors['mobile']) echo ' class="error"'; ?>>T&eacute;l&eacute;phone 2</label>
            <span>
                <input type="text" name="mobile" value="<?php echo htmlspecialchars($devis->getUtilisateur()->getMobile()); ?>" placeholder="T&eacute;l&eacute;phone 2">
            </span>
        </li>

        <li>
            <label<?php if($errors['email']) echo ' class="error"'; ?>>Email <em>*</em></label>
            <span>
                <input type="text" name="email" value="<?php echo htmlspecialchars($devis->getUtilisateur()->getEmail()); ?>" placeholder="Email">
            </span>
        </li>

        <li>
            <label<?php if($errors['confirm_email']) echo ' class="error"'; ?>>Confirmation email <em>*</em></label>
            <span>
                <input type="text" name="confirm_email" value="<?php echo htmlspecialchars($devis->getUtilisateur()->getEmail()); ?>" placeholder="Confirmation email">
            </span>
        </li>

        <li>
            <label<?php if($errors['comment_connu']) echo ' class="error"'; ?>>Comment nous avez-vous connu ? <em>*</em></label>
            <span>
                <select name="comment_connu">
                    <?php foreach(EnumConnu::getConstants() as $connu): ?>
                        <option <?php if ( $devis->getUtilisateur()->getCommentConnu() == $connu) { echo " selected ";}  ?> value="<?php echo $connu ?>" ><?php echo EnumConnu::$libs[$connu]; ?></option>
                    <?php endforeach; ?>
                </select>
            </span>
        </li>
        <li></li>

    </ul>

    <h4><span>Votre véhicule</span></h4>
    <ul>
        <li>
            <label<?php if($errors['immatriculation']) echo ' class="error"'; ?>>Immatriculation <em>*</em></label>
            <span>
                <input type="text" name="immatriculation" value="<?php echo htmlspecialchars($devis->getVehicule()->getImmatriculation()); ?>" placeholder="Immatriculation">
            </span>
        </li>
        <li>
            <label<?php if($errors['marque']) echo ' class="error"'; ?>>Marque <em>*</em></label>
            <span>
                <input type="text" name="marque" value="<?php echo htmlspecialchars($devis->getVehicule()->getMarque()); ?>" placeholder="Marque">
            </span>
        </li>
        <li>
            <label<?php if($errors['modele']) echo ' class="error"'; ?>>Mod&egrave;le <em>*</em></label>
            <span>
                <input type="text" name="modele" value="<?php echo htmlspecialchars($devis->getVehicule()->getModele()); ?>" placeholder="Mod&egrave;le">
            </span>
        </li>
        <li>
            <label<?php if($errors['kms']) echo ' class="error"'; ?>>Kms</label>
            <span>
                <input type="text" name="kms" value="<?php echo htmlspecialchars($devis->getVehicule()->getKms()); ?>" placeholder="Kms">
            </span>
        </li>
        <li>
            <label<?php if($errors['numero_chassis']) echo ' class="error"'; ?>>N&deg; chassis</label>
            <span>
                <input type="text" name="numero_chassis" value="<?php echo htmlspecialchars($devis->getVehicule()->getNumeroChassis()); ?>" placeholder="N&deg; chassis">
            </span>
        </li>
    </ul>

    <ul>
        <li>
            <input type="submit" name="fm_form_submit" id="fm_form_submit" class="submitc" value="&Eacute;tape Suivante" onclick="return fm_submit_onclick(1)">
        </li>
    </ul>

    </form>

</div>

<!--<div class="column_2">
	<div class="text_column_2"><h4>REMPLISSEZ LE FORMULAIRE</h4></div>
</div>-->
