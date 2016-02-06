<?php
/**
 * User: maff
 * Date: 29/06/13
 */
?>

<script type="text/javascript">
    function selectElement(id){
        document.getElementById('car_map').piece.value = id;
        document.getElementById('action').value = <?php echo Action::CHOOSE_PIECE; ?>;
        document.getElementById('car_map').submit();
    }
    function go_to_recap(){
        document.getElementById('action').value = <?php echo Action::SHOW_RECAPITULATIF; ?>;
        document.getElementById('car_map').submit();
    }
    function delete_dommage(){
        if(confirm("Etes-vous certain(e) de vouloir supprimer ce dommage ?")){
            document.getElementById('action2').value = <?php echo Action::DELETE_DOMMAGE; ?>;
            return true;
        }
        return false;
    }
    function delete_image(i){
        document.getElementById('action2').value = <?php echo Action::DELETE_PHOTO; ?>;
        document.getElementById('devis_dommage').photo.value = i;
        document.getElementById('devis_dommage').submit();
    }
</script>

<h6 class="step-title">&Eacute;tape 2 : S&eacute;lectionnez les &eacute;l&eacute;ments endommag&eacute;s et t&eacute;l&eacute;chargez les photos qui faciliteront l'&eacute;laboration de votre devis.</h6>

<div class="vc_span5 wpb_column column_container">

    <div class="wpb_wrapper">
        <form class="fm-form" method="post" id="car_map" action="">
        <input type="hidden" id="action" name="action" value="" />
        <input type="hidden" name="piece" value="" />
        <input type="hidden" name="devis" value="<?php echo $devis->getId(); ?>" />
        <input type="hidden" name="key" value="<?php echo DevisUtils::saltDevis($devis->getId()); ?>" />

        <div class="devis-map-wrapper">
            <div class="devis-map">
            <?php foreach (DWDevisApplication::$pieces as $p): ?>
                <div class="carrosserie<?php echo $p->getId(); ?>">
                    <?php
                    if ($p == $dommage->getPiece()){
                        $onoffover = 'over';
                    }else{
                        $onoffover = $devis->hasDommageForPiece($p) ? 'on':'off';
                    }
                    $class = sprintf('element%d_%s', $p->getId(), $onoffover);
                    $title = sprintf('%s %s', $p->getNom(), $p->getPosition());
                    $onclick = sprintf('selectElement(%d)', $p->getId());
                    ?>
                    <a onclick="<?php echo $onclick ?>" href="#" class="<?php echo $class ?>" title="<?php echo $title ?>">&nbsp;</a>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <div id="button_form">
            <input type="button" name="fm_form_submit" id="fm_form_submit" class="submita" value="&Eacute;tape Suivante" onclick="go_to_recap()">
        </div>
        </form>

    </div>

</div>


<div id="dommage" class="vc_span4 wpb_column column_container">
    <div class="wpb_wrapper">


        <?php if($dommage->getPiece()): ?>
            <h4><?php echo $dommage->getPiece()->getNom(); ?>
            <?php if($dommage->getPiece()->getPosition()): ?>
                (<?php echo $dommage->getPiece()->getPosition(); ?>)
            <?php endif; ?>
            </h4>

            <form class="fm-form form-devis" id="devis_dommage" method="post" enctype="multipart/form-data" action="">

                <input type="hidden" name="devis" value="<?php echo $devis->getId(); ?>" />
                <input type="hidden" name="key" value="<?php echo DevisUtils::saltDevis($devis->getId()); ?>" />

                <?php if(!$dommage->getId()): //Nouveau dommage ?>
                    <input type="hidden" name="action" value="<?php echo Action::ADD_DOMMAGE ?>" />
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                    <input type="hidden" name="piece" value="<?php echo $dommage->getPiece()->getId(); ?>">
                <?php else: //Modification/suppression ?>
                    <input type="hidden" id="action2" name="action" value="<?php echo Action::UPDATE_DOMMAGE ?>" />
                    <input type="hidden" name="dommage" value="<?php echo $dommage->getId(); ?>" />
                    <input type="hidden" name="key2" value="<?php echo DevisUtils::saltDommage($dommage->getId()); ?>" />
                    <input type="hidden" name="photo" value="" />
                <?php endif; ?>

                <ul>

                    <?php if($dommage->getPiece()->getType() == EnumTypePiece::PAREBRISE): ?>
                        <li>
                            <label for="type">Type de dommage <em>*</em></label>
                        <span>
                            <select name="type">
                                <option></option>
                                <option value="<?php echo EnumTypeDommage::UN_IMPACT ?>" <?php if ($dommage->getType() == EnumTypeDommage::UN_IMPACT) echo " selected "; ?>><?php echo EnumTypeDommage::$libs[EnumTypeDommage::UN_IMPACT]; ?></option>
                                <option value="<?php echo EnumTypeDommage::PLUSIEURS_IMPACTS ?>" <?php if ($dommage->getType() == EnumTypeDommage::PLUSIEURS_IMPACTS) echo " selected "; ?>><?php echo EnumTypeDommage::$libs[EnumTypeDommage::PLUSIEURS_IMPACTS]; ?></option>
                            </select>
                        </span>
                        </li>
                        <li>
                            <span class="small">NB : nous réparons uniquement les impacts de taille inférieure à une pièce de 2&euro;</span>
                        </li>
                    <?php endif; ?>

                    <?php if($dommage->getPiece()->getType() == EnumTypePiece::RAYURE): ?>
                        <li>
                            <label for="type">Type de dommage <em>*</em></label>
                            <span>
                                <select name="type">
                                    <option></option>
                                    <option value="<?php echo EnumTypeDommage::RAYURE ?>" <?php if ($dommage->getType() == EnumTypeDommage::RAYURE) echo " selected "; ?>><?php echo EnumTypeDommage::$libs[EnumTypeDommage::RAYURE]; ?></option>
                                    <option value="<?php echo EnumTypeDommage::ENFONCEMENT ?>" <?php if ($dommage->getType() == EnumTypeDommage::ENFONCEMENT) echo " selected "; ?>><?php echo EnumTypeDommage::$libs[EnumTypeDommage::ENFONCEMENT]; ?></option>
                                    <option value="<?php echo EnumTypeDommage::RAYURE_ENFONCEMENT ?>" <?php if ($dommage->getType() == EnumTypeDommage::RAYURE_ENFONCEMENT) echo " selected "; ?>><?php echo EnumTypeDommage::$libs[EnumTypeDommage::RAYURE_ENFONCEMENT]; ?></option>
                                </select>
                            </span>
                        </li>
                        <li>
                            <label for="taille">Taille du dommage <em>*</em></label>
                            <span>
                                <select  name="taille">
                                    <option></option>
                                    <option value="<?php echo EnumTailleDommage::PETIT ?>" <?php if ($dommage->getTaille() == EnumTailleDommage::PETIT) echo " selected ";?> ><?php echo EnumTailleDommage::$libs[EnumTailleDommage::PETIT] ?></option>
                                    <option value="<?php echo EnumTailleDommage::MOYEN ?>" <?php if ($dommage->getTaille() == EnumTailleDommage::MOYEN) echo " selected ";?> ><?php echo EnumTailleDommage::$libs[EnumTailleDommage::MOYEN] ?></option>
                                    <option value="<?php echo EnumTailleDommage::GROS ?>" <?php if ($dommage->getTaille() == EnumTailleDommage::GROS) echo " selected ";?> ><?php echo EnumTailleDommage::$libs[EnumTailleDommage::GROS] ?></option>
                                </select>
                            </span>
                        </li>
                        <li>
                            <label for="peinture">La peinture est-elle endommagée ?<em>*</em></label>
                            <span>
                                <select  name="peinture">
                                    <option></option>
                                    <option value="<?php echo EnumPeintureDommage::OUI ?>" <?php if ($dommage->getPeinture() == EnumPeintureDommage::OUI) echo " selected ";?> ><?php echo EnumPeintureDommage::$libs[EnumPeintureDommage::OUI] ?></option>
                                    <option value="<?php echo EnumPeintureDommage::NON ?>" <?php if ($dommage->getPeinture() == EnumPeintureDommage::NON) echo " selected ";?> ><?php echo EnumPeintureDommage::$libs[EnumPeintureDommage::NON] ?></option>
                                </select>
                            </span>
                        </li>
                    <?php endif; ?>


                    <?php if($dommage->getPiece()->getType() == EnumTypePiece::PHARE): ?>
                        <span class="small">NB : nous rénovons vos phares jaunis, mais ne réparons pas les phares cassés.</span>
                    <?php endif; ?>

                    <li>
                        <h4>Photos du dommage :</h4>
                        <span class="small">Votre fichier ne doit pas dépasser 2Mo<br />Vous devez laisser au moins 1 photo par dommage</span>
                    </li>

                    <?php $photos = $dommage->getPhotos();?>
                    <?php for($i=0; $i<=2; ++$i): ?>
                        <li>
                            Photo <?php echo ($i+1) ?> :

                            <?php if(isset($photos[$i])): ?>
                                <a target="_blank" href="<?php echo DevisUtils::getPhotoUrl($photos[$i]->getName()) ?>">voir</a>
                                <a href="#" onclick="delete_image(<?php echo $photos[$i]->getId() ?>)">supprimer</a>
                            <?php else: ?>
                                <input type="file" name="photo<?php echo ($i+1) ?>" />
                            <?php endif; ?>
                        </li>
                    <?php endfor; ?>

                    </li>

                    <li>
                        <label for="commentaire">D&eacute;tails commentaires :</label>
                        <span class="textarea">
                            <textarea name="commentaire"><?php echo htmlspecialchars($dommage->getCommentaire()); ?></textarea>
                        </span>
                    </li>

                </ul>


                <ul>
                    <?php if($dommage->getId()): ?>
                        <li>
                            <input type="submit" name="fm_form_submit" id="fm_form_submit" class="submit" value="Supprimer" onclick="return delete_dommage()">
                        </li>
                    <?php endif ?>
                    <li>
                        <input type="submit" name="fm-form_submit" id="fm-form_submit" class="submitb" value="Valider le dommage" onclick="return fm_submit_onclick(1)">
                    </li>
                </ul>
            </form>
        <?php else: ?>
            <h4>SELECTION DES ELEMENTS</h4>
            <p>Pour chaque élément concerné, vous préciserez la nature et la taille du dommage.</p>
            <p>Afin de vous transmettre un devis précis, nous vous invitons à télécharger jusqu'à 3 photos prises sous différents angles.</p>
			<p>Quelles photos nous transmettre afin d'obtenir un devis précis ? <a href="../wp-content/plugins/dwdevis/pdf/conseils_photo.png" style="text-decoration:underline; font-weight:600" target="_blank">cliquez-ici</a>					</p>
            <?php if(count($devis->getDommages())): ?>
                <p>Vous avez déjà déclaré les dommages suivants :</p>
                <div class="dommages"><ul>
                <?php //echo count($devis->getDommages()) ?>
                <?php foreach ($devis->getDommages() as $dommage): ?>
                    <li>- <?php echo $dommage->getPiece() ?></li>
                <?php endforeach; ?>
                </ul></div>
            <?php endif; ?>

        <?php endif; ?>
    </div>

</div>
