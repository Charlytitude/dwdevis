<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mverrecchia
 * Date: 10/07/13
 * Time: 11:10
 * To change this template use File | Settings | File Templates.
 */

$d = array("dommage_id"=>0,"demi"=>0,"complet"=>0,"t_mo"=>0,"simple"=>0,"complexe"=>0,"qt"=>0,"tarif"=>0);
$data = array();
$cp = 0;

foreach($_POST as $key => $val)
{
    $t1 = 0;
    $ext = str_replace("ext","",$key,$t1);
    if($t1 != 0)
    {
        $d["dommage_id"]=$ext;
        $data[$cp]=$d;
        ++$cp;
    }

}

//todo caster les valeurs au cas où
$cp = 0;
$id_devis = "";
foreach($data as $d1)
{
    $d=$d1;
    foreach($_POST as $key => $val)
    {
        $ch = str_replace($d1["dommage_id"],"",$key);

        switch($ch){
            case 'demi':    $d["demi"]      = floatval($val);   break;
            case 'complet': $d["complet"]   = floatval($val);   break;
            case 'simple':  $d["simple"]    = floatval($val);   break;
            case 'complexe':$d["complexe"]  = floatval($val);   break;
            case 'ext':     $d["tarif"]     = floatval($val);   break;
            //interieur
            case 'int':     $d["tarif"]     = floatval($val);   break;
            case 'tm':      $d["t_mo"]      = floatval($val);   break;
            case 'qt':      $d["qt"]        = floatval($val);   break;
        }
    }
    $data[$cp] = $d;
    $cp++;
    $cp++;
}

//TODO controles et gestion des erreurs + mode transactionnel !!!!
$proposition = new Proposition();

$proposition->setMainOeuvre($_POST["taux_h"]);
$proposition->setFPriseCharge($_POST["pc"]);
$proposition->setRemise(str_replace("%","",$_POST["remise"]));
$proposition->setHt($_POST["tot_ht"]);
$proposition->setHtR($_POST["tot_ht_r"]);
$proposition->setTva($_POST["tva"]);
$proposition->setTot($_POST["tot"]);
$proposition->setComment($_POST["comment"]);
$proposition->setAcompte($_POST["acompte"]);
$proposition->setDate1(strtotime($_POST["annee1"]."-".$_POST["mois1"]."-".$_POST["jour1"]));
$proposition->setDate2(strtotime($_POST["annee2"]."-".$_POST["mois2"]."-".$_POST["jour2"]));
$proposition->setDate3(strtotime($_POST["annee3"]."-".$_POST["mois3"]."-".$_POST["jour3"]));
$proposition->setMatinMidi1($_POST["matin_midi1"]);
$proposition->setMatinMidi2($_POST["matin_midi2"]);
$proposition->setMatinMidi3($_POST["matin_midi3"]);

$proposition->save();


//enregistrement des détails des dommages
foreach($data as $d1)
{
    $dommage = $devis->getDommageById($d1["dommage_id"]);

    $dommage->setDemi($d1["demi"]);
    $dommage->setComplet($d1["complet"]);
    $dommage->setSimple($d1["simple"]);
    $dommage->setComplexe($d1["complexe"]);
    $dommage->setTMo($d1["t_mo"]);
    $dommage->setQt($d1["qt"]);
    $dommage->setTarif($d1["tarif"]);

    $dommage->save();

}

$devis->setProposition($proposition);

$devis->setState(EnumDevisState::TREATED);
$devis->save();
//TODO envoi d'un mail
//TODO flashbag
