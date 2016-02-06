<?php
/**
 * User: maff
 * Date: 30/06/13
 */

?>


<style>
    table.tsample {
        border-width: 1px;
        border-spacing: 2px;
        border-style: outset;
        border-color: black;
        border-collapse: collapse;
        background-color: white;
    }
    table.tsample th {
        border-width: 1px;
        padding: 1px;
        border-style: solid;
        border-color: black;
        background-color: white;

    }
    table.tsample td {
        border-width: 1px;
        padding: 1px;
        border-style: solid;
        border-color: black;
        background-color: white;
        height:16px;

    }
    label.lab{font-family: arial, sans-serif ;
        font-size: 7pt ;
        color: #666666 ;
        letter-spacing: 0px;
    }
    label.t1{font-family: arial, sans-serif ;
        font-size: 8pt ;
        color: #FFF ;
        letter-spacing: 0px;
        font-weight: bold;
    }
    label.t2{font-family: arial, sans-serif ;
        font-size: 8pt ;
        color: #000 ;
        letter-spacing: 0px;
        font-weight: bold;
    }
    label.t0{font-family: arial, sans-serif ;
        font-size: 8pt ;
        color: #000 ;
        letter-spacing: 0px;
    }
    .p0{
        background-image: url(./images/arr0000.png);
    }
    .p1{
        background-image: url(./images/arr0001.png);
    }
    .p2{
        background-image: url(./images/arr0002.png);
    }
    .p3{
        background-image: url(./images/arr0003.png);
    }
    .p4{
        background-image: url(./images/arr0004.png);
    }
    .p5{
        background-image: url(./images/arr0005.png);
    }
    .p6{
        background-image: url(./images/arr0006.png);
    }
</style>

<script language="JavaScript" type="text/javascript">//script de calcul des dates

    function NbJourParMois(iMonth,iYear )
    {
        var  d= new Date(iYear, iMonth, 32);
        return(32-d.getDate());
    }

    function  remplir(j,m,y)
    {   //alert(j+" "+m+" "+y);
        m--;
        nb=NbJourParMois(m, y);
        document.getElementById(j).options.length=0;
        it1=0
        p=j.substring(4,5);
        for (var iter = 1; iter <= nb; iter++)
        {
            var myDate = new Date();
            myDate.setFullYear(y);
            myDate.setMonth(m);
            myDate.setDate(iter);
            if(myDate.getDay()==1 |myDate.getDay()==2|myDate.getDay()==3|myDate.getDay()==4|myDate.getDay()==5 )
            {
                document.getElementById(j).options[it1]=new Option(iter,iter, true, true);
                document.getElementById('lab_jour'+p).innerHTML=getdayname(myDate.getDay());
                it1++;
            }

        }
    }
    function getdayname(x)
    {
        var d = ['Jeudi','Vendredi','Samedi','Dimanche','Lundi','Mardi','Mercredi'];
        //var d = ['Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche','Lundi'];
        return d[x];
    }
    function nom_jour(j,m,a,x)

    {       var myDate = new Date();
        myDate.setFullYear(a);
        myDate.setMonth(m);
        myDate.setDate(j);
        // alert(getdayname(myDate.getDay()));
        document.getElementById('jour'+x).value=j;
        document.getElementById('lab_jour'+x).innerHTML=getdayname(myDate.getDay());

    }

</script>



<script language="JavaScript" type="text/javascript">

    function is_num(num)
    {
        var exp = new RegExp("^[0-9-.]*$","g");
        return exp.test(num);
    }

    function somme_ext(){
        prec=2;    //nombre apre virgule
        var divEls = document.getElementsByTagName('input');
        var i = 0;
        somme=0;
        somme1=0;
        remise=0;
        prc=0;

        for(i=0;i<divEls.length;i++)
        {
            a=divEls[i].id;
            if(a=="remise"){remise=divEls[i].value.replace("%","");}  ///le remise
            if(a=="pc"){prc=divEls[i].value.replace('','');if(prc==''){prc=0;}divEls[i].value=parseFloat(prc)+'';}  ///le prise en charge


            var n=a.indexOf("ext") ;
            if(n==0)
            {   if(divEls[i].value!="")
            {  if(is_num(divEls[i].value)){divEls[i].style.backgroundColor='#FFFFFF';}else{divEls[i].style.backgroundColor='#FF0033';}
                var v=divEls[i].value;
                somme=somme+parseFloat(v);
            }
            }
            var n=a.indexOf("int") ;
            if(n==0)
            {   if(divEls[i].value!="")
            {  if(is_num(divEls[i].value)){divEls[i].style.backgroundColor='#FFFFFF';}else{divEls[i].style.backgroundColor='#FF0033';}
                var v=divEls[i].value;
                somme1=somme1+parseFloat(v);
            }
            }
        }
        if(somme){document.getElementById('s_ex').value=somme.toFixed(prec)+'';}
        if(somme1){document.getElementById('s_in').value=somme1.toFixed(prec)+'';}
        var  tot=somme+somme1;
        //alert(prc);
        tot_ht= (parseFloat(tot)+parseFloat(prc)) ;

        document.getElementById('tot_ht').value=tot_ht.toFixed(prec)+'';
        tot_ht_r=tot_ht-((tot_ht/100)*remise);
        tva=((tot_ht_r*19.5)/100)
        document.getElementById('tva').value=tva.toFixed(prec)+'';

        document.getElementById('tot_ht_r').value=tot_ht_r.toFixed(prec)+'';

        document.getElementById('tot').value=(tot_ht_r+tva).toFixed(2)+'';


    }
    setInterval(function(){somme_ext()}, 1000);



</script>
<script>
    function disable(c){ try{document.getElementById(c).disabled=true;document.getElementById(c).value='-';}catch(err){alert(err.message);}}
    function enable(c){try{document.getElementById(c).disabled=false;document.getElementById(c).value='';}catch(err){alert(err.message);}}

    function cx(c){
        try{
            if(document.getElementById('demi'+c).value!="" && document.getElementById('demi'+c).value!="-" && document.getElementById('tm'+c).value!=""){document.getElementById('ext'+c).value=parseFloat(document.getElementById('taux_h').value)*parseFloat(document.getElementById('tm'+c).value)+parseFloat(document.getElementById('demi'+c).value);}//*document.getElementById('tm228').value;
            else if(document.getElementById('simple'+c).value!="" && document.getElementById('simple'+c).value!="-"&& document.getElementById('tm'+c).value!=""){document.getElementById('ext'+c).value=parseFloat(document.getElementById('taux_h').value)*parseFloat(document.getElementById('tm'+c).value)+parseFloat(document.getElementById('simple'+c).value);;}//*document.getElementById('tm228').value;
            else if(document.getElementById('complet'+c).value!="" && document.getElementById('complet'+c).value!="-"&& document.getElementById('tm'+c).value!=""){document.getElementById('ext'+c).value=parseFloat(document.getElementById('taux_h').value)*parseFloat(document.getElementById('tm'+c).value)+parseFloat(document.getElementById('complet'+c).value);;}//*document.getElementById('tm228').value;
            else if(document.getElementById('complexe'+c).value!="" && document.getElementById('complexe'+c).value!="-"&& document.getElementById('tm'+c).value!=""){document.getElementById('ext'+c).value=parseFloat(document.getElementById('taux_h').value)*parseFloat(document.getElementById('tm'+c).value)+parseFloat(document.getElementById('complexe'+c).value);;}//*document.getElementById('tm228').value;
            //else{alert(c+' non trouvé!');}
        }catch(err){alert(err.message);}
    }
</script>

<script language="JavaScript" type="text/javascript">
    function get_remise(nom_f,id)
    {
        r= file(nom_f) ;
        // alert(r);
        try{
            //if(r=='0%'){alert('code invalide!');}
            document.getElementById(id).value = r;
            document.getElementById('td_remise').style.display ='none';
            document.getElementById('td_remise1').style.display ='none';
        }catch(err){alert(err.message);}
    }

    function file(fichier)
    {
        if(window.XMLHttpRequest) // FIREFOX
            xhr_object = new XMLHttpRequest();
        else if(window.ActiveXObject) // IE
            xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
        else
            return(false);
        xhr_object.open("GET", fichier, false);
        xhr_object.send(null);
        if(xhr_object.readyState == 4) return(xhr_object.responseText);
        else return(false);
    }



</script>

<?php
$etat="insertion";
//print_r($_POST);

$special=array(); $m=0;
$droite=array(); $i=0;
$gauche=array();  $j=0;
$autre= array();  $k=0;
$avant= array();  $l=0;
$arriere= array();  $p=0;

foreach ($devis->getDommages() as $dommage) {
    
    $t=0;
    $n=0;
    str_ireplace("PHARE","PHARE",$dommage->getPiece()->getNom(),$n) ;$t=$t+$n;
    str_ireplace("PARE-BRISE","PARE-BRISE",$dommage->getPiece()->getNom(),$n) ;$t=$t+$n;
    str_ireplace("RETROVISEUR","RETROVISEUR",$dommage->getPiece()->getNom(),$n) ;$t=$t+$n;
    str_ireplace("JANTE","JANTE",$dommage->getPiece()->getNom(),$n) ;$t=$t+$n;
    if($t!=0){
        $x[0]=$dommage->getPiece()->getNom();
        $x[1]=$dommage->getPiece()->getPosition();
        $x[2]=$dommage->getTaille();
        $x[3]=$dommage->getType();
        $x[4]= '';
        $x[5]= $dommage->getId();
        $x[6]= $dommage->getCommentaire();
        $special[$m]=$x;
        $m++;
    }

    $r=0;    str_ireplace("droite","droite",$dommage->getPiece()->getPosition(),$r) ;
    if($r!=0&&$t==0){
        $x[0]=$dommage->getPiece()->getNom();
        $x[1]=$dommage->getPiece()->getPosition();
        $x[2]=$dommage->getTaille();
        $x[3]=$dommage->getType();
        $x[4]= '';
        $x[5]= $dommage->getId();
        $droite[$i]=$x;
        $i++;
    }
    $s=0;    str_ireplace("gauche","gauche",$dommage->getPiece()->getPosition(),$s) ;
    if($s!=0&&$t==0){
        $x[0]=$dommage->getPiece()->getNom();
        $x[1]=$dommage->getPiece()->getPosition();
        $x[2]=$dommage->getTaille();
        $x[3]=$dommage->getType();
        $x[4]= '';
        $x[5]= $dommage->getId();
        $gauche[$j]=$x;
        $j++;
    }
    if($s==0 && $r==0&&$t==0){
        $x[0]=$dommage->getPiece()->getNom();
        $x[1]=$dommage->getPiece()->getPosition();
        $x[2]=$dommage->getTaille();
        $x[3]=$dommage->getType();
        $x[4]= '';
        $x[5]= $dommage->getId();
        $autre[$k]=$x;
        $k++;
    }

}
// print_r($special);
// print_r($gauche);
?>



<style>
    .side_bar{
        font-family: Arial;
        font-weight: bold;
        text-decoration: none;
        font-size: 12;
        color:#514A4C;
    }

</style>


<?php //TODO revoir l'action du formulaire ?>
<form name="form1" method="post" action="?page=<?php echo $page ?>&do=create_proposition&id=<?php echo $devis->getId(); ?>" onsubmit="return(test());">


<div id="detail_devis">
    <h2>D&eacute;tail du devis n&deg; <?php echo $devis->getId() ?></h2>


    <div style="float:left; width:70%">
    <?PHP if($i+$j+$k>0){  ?>
        <table class="tsample" width="100%">
            <tr ><td colspan="10" class="p0" align="center"><label class="t1" >CARROSSERIE PEINTURE</label></td></tr>
            <tr >

                <td colspan="2" rowspan="2" width="35%" class="p1"><label class="lab"></label></td>

                <td  rowspan="2" align="center" class="p1"><label class="t0" ><b>rayure</b></label></td>
                <td  rowspan="2" align="center" class="p1"><label class="t0" ><b>enfon...</b></label></td>
                <td colspan="2" align="center" class="p1"><label class="t0" ><b>PEINTURE</b></label></td>
                <td colspan="2" align="center" class="p1"><label class="t0" ><b>D.S.P</b></label></td>
                <td align="center" rowspan="2" class="p1"><label class="t0" ><b>TEMPS MO/H </b></label></td>
                <td class="p2" width="12%" rowspan="2" align="center"><label class="t1">Tarif H.T</label></td>
            </tr>
            <tr >
                <td align="center" class="p1" width="7%"><label class="lab" >Demi</label></td>
                <td align="center" class="p1" width="7%"><label class="lab" >Complet</label></td>
                <td align="center" class="p1" width="7%"><label class="lab" >Simple</label></td>
                <td align="center" class="p1" width="7%"><label class="lab" >Complexe</label></td>

            </tr>
            <?PHP
            $c=0;
            foreach($droite as $o) { $name="ext".$o[5];
                if($i!=0){
                    ?>

                    <tr>

                        <?PHP if($c==0){?><td rowspan="<?PHP echo $i;?>"><label class="t0" ><b>CÔTÉ DROIT</b></label></td><?PHP }?>
                        <?php // TODO ?>
                        <td><a href="images_dommage.php?id=<?PHP echo $o[5];?>" target="_blank"><label class="t0"><?PHP echo $o[0]." ".str_replace("droite","",$o[1]);    ?>   </label></a></td>
                        <td <?PHP $pos=0; str_replace('rayure','rayure',$o[3],$pos);    if($pos!=0){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td <?PHP $pos=0; str_replace('enfoncement','enfoncement',$o[3],$pos);    if($pos!=0){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td><input onchange="if(this.value!=''){cx('<?PHP echo $o[5];?>');disable('complet<?PHP echo $o[5];?>');disable('simple<?PHP echo $o[5];?>');disable('complexe<?PHP echo $o[5];?>');}else{enable('complet<?PHP echo $o[5];?>');enable('simple<?PHP echo $o[5];?>');enable('complexe<?PHP echo $o[5];?>');}" name="<?PHP echo "demi".$o[5]; ?>" id="<?PHP echo "demi".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input onchange="if(this.value!=''){cx('<?PHP echo $o[5];?>');disable('demi<?PHP echo $o[5];?>');disable('simple<?PHP echo $o[5];?>');disable('complexe<?PHP echo $o[5];?>');}else{enable('demi<?PHP echo $o[5];?>');enable('simple<?PHP echo $o[5];?>');enable('complexe<?PHP echo $o[5];?>');}" name="<?PHP echo "complet".$o[5]; ?>" id="<?PHP echo "complet".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input onchange="if(this.value!=''){cx('<?PHP echo $o[5];?>');disable('complet<?PHP echo $o[5];?>');disable('demi<?PHP echo $o[5];?>');disable('complexe<?PHP echo $o[5];?>');}else{enable('complet<?PHP echo $o[5];?>');enable('demi<?PHP echo $o[5];?>');enable('complexe<?PHP echo $o[5];?>');}" name="<?PHP echo "simple".$o[5]; ?>" id="<?PHP echo "simple".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input onchange="if(this.value!=''){cx('<?PHP echo $o[5];?>');disable('complet<?PHP echo $o[5];?>');disable('simple<?PHP echo $o[5];?>');disable('demi<?PHP echo $o[5];?>');}else{enable('complet<?PHP echo $o[5];?>');enable('simple<?PHP echo $o[5];?>');enable('demi<?PHP echo $o[5];?>');}" name="<?PHP echo "complexe".$o[5]; ?>" id="<?PHP echo "complexe".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input onchange="cx('<?PHP echo $o[5];?>');" name="<?PHP echo "tm".$o[5]; ?>" id="<?PHP echo "tm".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input maxlength="8" name="<?PHP echo $name ?>" id="<?PHP echo $name ?>" style="border:0; width:90%;text-align: center"  /></td>
                    </tr>
                    <?PHP $c++;}}
            $c=0;
            foreach($gauche as $o) {  $name="ext".$o[5];
                if($j!=0){
                    ?>

                    <tr>
                        <?PHP if($c==0){?><td rowspan="<?PHP echo $j;?>"><label class="t0" ><b>CÔTÉ GAUCHE</b></label></td><?PHP }?>
                        <?php // TODO ?>
                        <td><a href="images_dommage.php?id=<?PHP echo $o[5];?>" target="_blank"><label class="t0"><?PHP echo $o[0]." ".str_replace("gauche","",$o[1]);    ?>   </label></a></td>
                        <td <?PHP $pos=0; str_replace('rayure','rayure',$o[3],$pos);    if($pos!=0){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td <?PHP $pos=0; str_replace('enfoncement','enfoncement',$o[3],$pos);    if($pos!=0){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td><input onchange="if(this.value!=''){cx('<?PHP echo $o[5];?>');disable('complet<?PHP echo $o[5];?>');disable('simple<?PHP echo $o[5];?>');disable('complexe<?PHP echo $o[5];?>');}else{enable('complet<?PHP echo $o[5];?>');enable('simple<?PHP echo $o[5];?>');enable('complexe<?PHP echo $o[5];?>');}" name="<?PHP echo "demi".$o[5]; ?>" id="<?PHP echo "demi".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input onchange="if(this.value!=''){cx('<?PHP echo $o[5];?>');disable('demi<?PHP echo $o[5];?>');disable('simple<?PHP echo $o[5];?>');disable('complexe<?PHP echo $o[5];?>');}else{enable('demi<?PHP echo $o[5];?>');enable('simple<?PHP echo $o[5];?>');enable('complexe<?PHP echo $o[5];?>');}" name="<?PHP echo "complet".$o[5]; ?>" id="<?PHP echo "complet".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input onchange="if(this.value!=''){cx('<?PHP echo $o[5];?>');disable('complet<?PHP echo $o[5];?>');disable('demi<?PHP echo $o[5];?>');disable('complexe<?PHP echo $o[5];?>');}else{enable('complet<?PHP echo $o[5];?>');enable('demi<?PHP echo $o[5];?>');enable('complexe<?PHP echo $o[5];?>');}" name="<?PHP echo "simple".$o[5]; ?>" id="<?PHP echo "simple".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input onchange="if(this.value!=''){cx('<?PHP echo $o[5];?>');disable('complet<?PHP echo $o[5];?>');disable('simple<?PHP echo $o[5];?>');disable('demi<?PHP echo $o[5];?>');}else{enable('complet<?PHP echo $o[5];?>');enable('simple<?PHP echo $o[5];?>');enable('demi<?PHP echo $o[5];?>');}" name="<?PHP echo "complexe".$o[5]; ?>" id="<?PHP echo "complexe".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input onchange="cx('<?PHP echo $o[5];?>');" name="<?PHP echo "tm".$o[5]; ?>" id="<?PHP echo "tm".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input maxlength="8" name="<?PHP echo $name ?>" id="<?PHP echo $name ?>" style="border:0; width:90%;text-align: center"  /></td>
                    </tr>
                    <?PHP $c++;}}
            $c=0;
            foreach($autre as $o) {  $name="ext".$o[5];
                if($k!=0){
                    ?>

                    <tr>
                        <td colspan="2"><a href="images_dommage.php?id=<?PHP echo $o[5];?>" target="_blank"><label class="t0" ><?PHP echo $o[0]." ".$o[1];    ?>   </label></a></td>

                        <td <?PHP $pos=0; str_replace('rayure','rayure',$o[3],$pos);    if($pos!=0){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td <?PHP $pos=0; str_replace('enfoncement','enfoncement',$o[3],$pos);    if($pos!=0){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td><input onchange="if(this.value!=''){cx('<?PHP echo $o[5];?>');disable('complet<?PHP echo $o[5];?>');disable('simple<?PHP echo $o[5];?>');disable('complexe<?PHP echo $o[5];?>');}else{enable('complet<?PHP echo $o[5];?>');enable('simple<?PHP echo $o[5];?>');enable('complexe<?PHP echo $o[5];?>');}" name="<?PHP echo "demi".$o[5]; ?>" id="<?PHP echo "demi".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input onchange="if(this.value!=''){cx('<?PHP echo $o[5];?>');disable('demi<?PHP echo $o[5];?>');disable('simple<?PHP echo $o[5];?>');disable('complexe<?PHP echo $o[5];?>');}else{enable('demi<?PHP echo $o[5];?>');enable('simple<?PHP echo $o[5];?>');enable('complexe<?PHP echo $o[5];?>');}" name="<?PHP echo "complet".$o[5]; ?>" id="<?PHP echo "complet".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input onchange="if(this.value!=''){cx('<?PHP echo $o[5];?>');disable('complet<?PHP echo $o[5];?>');disable('demi<?PHP echo $o[5];?>');disable('complexe<?PHP echo $o[5];?>');}else{enable('complet<?PHP echo $o[5];?>');enable('demi<?PHP echo $o[5];?>');enable('complexe<?PHP echo $o[5];?>');}" name="<?PHP echo "simple".$o[5]; ?>" id="<?PHP echo "simple".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input onchange="if(this.value!=''){cx('<?PHP echo $o[5];?>');disable('complet<?PHP echo $o[5];?>');disable('simple<?PHP echo $o[5];?>');disable('demi<?PHP echo $o[5];?>');}else{enable('complet<?PHP echo $o[5];?>');enable('simple<?PHP echo $o[5];?>');enable('demi<?PHP echo $o[5];?>');}" name="<?PHP echo "complexe".$o[5]; ?>" id="<?PHP echo "complexe".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>
                        <td><input onchange="cx('<?PHP echo $o[5];?>');" name="<?PHP echo "tm".$o[5]; ?>" id="<?PHP echo "tm".$o[5]; ?>" style="border:0; width:90%;text-align: center"  /></td>

                        <td><input maxlength="8" name="<?PHP echo $name ?>" id="<?PHP echo $name ?>" style="border:0; width:90%;text-align: center"  /></td>
                    </tr>
                    <?PHP $c++;}}   ?>
            <tr>
                <td colspan="10" class="p3"><label class="t0"><b>Montant total main d'oeuvre (<input name="taux_h" id="taux_h" value="72" style="width:24px;border:0;font-size: 8pt;font-weight: bold;background-color: #F2F2F2;text-align: center"/> H.T taux horaire)</b></label></td>
            </tr>
        </table>
        <br />
        <table class="tsample" width="100%">
            <tr>
                <td colspan="9" class="p3"><label class="t0"><b>Sous Total Carrosserie H.T</b></label></td>
                <td width="12%" class="p4"><input maxlength="8" name="s_ex" id="s_ex" style="border:0; width:90%; background-color: #FDE8D8;text-align: center" readonly="" /></td>
            </tr>
        </table>

    <?PHP } ?>

    <br />
    <?PHP if($l+$p+$m>0){  ?>
        <table class="tsample" width="100%">
            <tr><td colspan="8" class="p0" align="center"><label class="t1" >SMART REPAIR</label></td></tr>
            <tr>
                <td rowspan="2" width="20%" align="center" class="p1"><label class="t0" ></label></td>
                <td rowspan="2" align="center" class="p1" width="23%"><label class="t0"><b>ELEMNT</b></label></td>
                <td colspan="5" align="center" class="p1"><label class="t0"><b>MATIERE</b></label></td>
                <td rowspan="2" class="p2" width="12%" align="center"><label class="t1">TARIF H.T.</label></td>

            </tr>
            <tr>

                <td class="p1" align="center" width="9%"><label class="lab" align="center">Cuir</label></td>
                <td class="p1" align="center" width="9%"><label class="lab" align="center">Plastique</label></td>
                <td class="p1" align="center" width="9%"><label class="lab" align="center">Tissu</label></td>
                <td class="p1" align="center" width="9%"><label class="lab" align="center">Moquette</label></td>
                <td class="p1" align="center" width="9%"><label class="lab" align="center">Velour</label></td>

            </tr>
            <?PHP
            $c=0;
            foreach($avant as $o) {  $name="int".$o[5];
                if($l!=0){
                    ?>

                    <tr>
                        <?PHP if($c==0){?><td rowspan="<?PHP echo $l;?>"><label class="t0" ><b>INTÉRIEUR AVANT</b></label></td><?PHP }?>
                        <td><a href="images_dommage.php?id=<?PHP echo $o[5];?>" target="_blank"><label class="t0"><?PHP echo $o[0]." ".str_replace("Avant","",$o[1]);    ?>   </label></a></td>

                        <td <?PHP if($o[4]=="Cuir"){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td <?PHP if($o[4]=="Plastique"){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td <?PHP if($o[4]=="Tissu"){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td <?PHP if($o[4]=="Moquette"){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td <?PHP if($o[4]=="Velours"){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td ><input maxlength="8" name="<?PHP echo $name ?>" id="<?PHP echo $name ?>" style="border:0; width:90%;text-align: center" /></td>
                    </tr>
                    <?PHP $c++;}}$c=0;
            foreach($arriere as $o) { $name="int".$o[5];
                if($p!=0){
                    ?>

                    <tr>
                        <?PHP if($c==0){?><td rowspan="<?PHP echo $p;?>"><label class="t0" ><b>INTÉRIEUR ARRIERE</b></label></td><?PHP }?>
                        <td><a href="images_dommage.php?id=<?PHP echo $o[5];?>" target="_blank"><label class="t0"><?PHP echo $o[0]." ".str_replace("Arriere","",$o[1]);    ?>   </label></a></td>

                        <td <?PHP if($o[4]=="Cuir"){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td <?PHP if($o[4]=="Plastique"){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td <?PHP if($o[4]=="Tissu"){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td <?PHP if($o[4]=="Moquette"){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td <?PHP if($o[4]=="Velours"){echo 'class="p6" align="center"><label class="lab">';if($o[2]!=""){echo$o[2];}else{echo"x";}echo'</label';} ?>></td>
                        <td ><input maxlength="8" name="<?PHP echo $name ?>" id="<?PHP echo $name ?>" style="border:0; width:90%;text-align: center" /></td>
                    </tr>
                    <?PHP $c++;}}?>

        </table>

        <?PHP  if($m!=0){                    ?>
            <br />
            <table class="tsample" width="100%">
                <tr>
                    <td width="20%" ></td>
                    <td colspan="1" align="center" class="p1" width="20%"><label class="t0"><b>ELEMENT</b></label></td>
                    <td colspan="1" align="center" class="p1"><label class="t0"><b>DESCRIPTION</b></label></td>
                    <td colspan="1" align="center" class="p1" width="10%"><label class="t0"><b>QUANTITE</b></label></td>
                    <td class="p2" width="12%" align="center"><label class="t1">TARIF H.T.</label></td>
                </tr>
                <?PHP
                $c=0;
                foreach($special as $o) {
                    $name="int".$o[5];

                    ?>

                    <tr>
                        <?PHP if($c==0){?><td rowspan="<?PHP echo $m;?>"><label class="t0" ><b>EXTÉRIEUR</b></label></td><?PHP }?>
                        <td><a href="images_dommage.php?id=<?PHP echo $o[5];?>" target="_blank"><label class="t0"><?PHP echo $o[0]." ".$o[1];    ?>   </label></a></td>

                        <td ><label class="t0"><?PHP  echo str_replace("_"," ",$o[3]);?></label></td>
                        <td ><input maxlength="8" name="<?PHP echo "qt".$o[5]; ?>" id="<?PHP echo "qt".$o[5]; ?>" style="border:0; width:90%;text-align: center" /></td>
                        <td ><input maxlength="8" name="<?PHP echo $name ?>" id="<?PHP echo $name ?>" style="border:0; width:90%;text-align: center" /></td>
                    </tr>
                    <?PHP $c++;}?>

            </table>
        <?PHP } ?>
        <br />

        <table class="tsample" width="100%">
            <tr><td class="p3" align="left"><label class="t2" >Sous Total Smart Repair H.T</label></td><td width="12%" class="p4"><input maxlength="8"  style="border:0; width:90%;text-align: center ;background-color: #FDE8D8;" readonly="" id="s_in" name="s_in"  /></td></tr>
        </table>

    <?PHP } ?>
    <br />
    <table class="tsample" width="100%">
        <tr><td class="p5" align="right"><label class="t0" >Forfait de prise en charge</label></td><td width="12%"><input maxlength="8"  style="border:0; width:90%;text-align: center ;"  id="pc" name="pc" value="74"   /></td></tr>
        <tr><td class="p5" align="right"><label class="t0" >Total H.T.</label></td><td ><input maxlength="8"  style="border:0; width:90%;text-align: center ;"  id="tot_ht" name="tot_ht" readonly=""  /></td></tr>
        <tr><td class="p5" align="right"><label class="t0" >Remise</label></td><td ><input maxlength="8"  style="border:0; width:90%;text-align: center ;"  id="remise" name="remise"  value="0%" readonly="" /></td></tr>
        <tr><td class="p5" align="right"><label class="t0" >Total net remisé H.T.</label></td><td ><input maxlength="8"  style="border:0; width:90%;text-align: center ;"  id="tot_ht_r" name="tot_ht_r" readonly=""   /></td></tr>
        <tr><td class="p5" align="right"><label class="t0" >TVA 19,6%</label></td><td ><input maxlength="8"  style="border:0; width:90%;text-align: center ;text-align: center" readonly="" id="tva" name="tva"  /></td></tr>
        <tr><td class="p0" align="right"><label class="t1" >TOTAL T.T.C.</label></td><td class="p5"><input maxlength="8"  style="border:0; width:90%;text-align: center ;text-align: center;background-color: #D9EDF3" readonly="" id="tot" name="tot"  /></td></tr>
    </table>
    <br />


    <table class="tsample" width="100%">
        <tr>
            <td><textarea name="comment" style="width:100%; height: 50px ;border:0;resize: none">Commentaires</textarea></td>
        </tr>
    </table>

    </div>

    <div style="float:right; margin-right:20px;">

        <?php

        $annee=$mois=$jour='';

        $date = $devis->getCreationDate();
        if(isset($date)){
            list( $annee, $mois , $jour ) = explode("-",$date);
        }

        ?>
        <table class="tsample" width="100%">
            <tr>
                <td colspan="2" class="p6" align="center"><label class="t2">CLIENT</label></td>

            </tr>
            <tr>
                <td class="p6" width="40%"><label class="t0"> Nom</label></td>
                <td><label class="t0"><?PHP echo $devis->getUtilisateur()->getCivilite(); ?> <?php echo $devis->getUtilisateur()->getNom() ?></label></td>
            </tr>
            <tr>
                <td class="p6"><label class="t0">Prénom</label></td>
                <td><label class="t0">  <?PHP 	echo $devis->getUtilisateur()->getPrenom();	?></label></td>
            </tr>
            <tr>
                <td class="p6"><label class="t0">Code client</label></td>
                <td><label class="t0"><?PHP 	echo $devis->getUtilisateur()->getCodeClient();	?></label></td>
            </tr>
            <tr>
                <td class="p6"><label class="t0">Adresse</label></td>
                <td><label class="t0"><?PHP 	echo $devis->getUtilisateur()->getAdresse();	?></label></td>
            </tr>
            <tr>
                <td class="p6"><label class="t0">CP</label></td>
                <td><label class="t0"> <?PHP 	echo $devis->getUtilisateur()->getCp();	?></label></td>
            </tr>
            <tr>
                <td class="p6"><label class="t0">Ville</label></td>
                <td><label class="t0"> <?PHP 	echo $devis->getUtilisateur()->getVille();	?></label></td>
            </tr>
            <tr>
                <td class="p6"><label class="t0">Tel.</label></td>
                <td><label class="t0"><?PHP 	echo $devis->getUtilisateur()->getTel();	?></label></td>
            </tr>
            <tr>
                <td class="p6"><label class="t0">mobile.</label></td>
                <td><label class="t0"><?PHP 	echo $devis->getUtilisateur()->getMobile();	?></label></td>
            </tr>
            <tr>
                <td class="p6"><label class="t0">Email</label></td>
                <td><label class="t0"><?PHP 	echo $devis->getUtilisateur()->getEmail();	?></label></td>
            </tr>
        </table>

        <br />
        <table class="tsample" width="100%">
            <tr>
                <td class="p6" colspan="2" align="center"><label class="t2">VEHICULE</label></td>

            </tr>
            <tr>
                <td class="p6" width="40%"><label class="t0">Marque</label></td>
                <td><label class="t0"><?PHP 	echo $devis->getVehicule()->getMarque();	?></label></td>
            </tr>
            <tr>
                <td class="p6"><label class="t0">Modèle</label></td>
                <td><label class="t0"><?PHP 	echo $devis->getVehicule()->getModele() ;	?></label></td>
            </tr>
            <tr>
                <td class="p6"><label class="t0">Année</label></td>
                <td><label class="t0"><?PHP 	echo $annee	?></label></td>
            </tr>
            <tr>
                <td class="p6"><label class="t0">N°Immat</label></td>
                <td><label class="t0"> <?PHP 	echo $devis->getVehicule()->getImmatriculation();	?></label></td>
            </tr>
            <tr>
                <td class="p6"><label class="t0">VIN</label></td>
                <td><label class="t0"><?PHP 	echo $devis->getVehicule()->getNumeroChassis();	?></label></td>
            </tr>

        </table>

        <br />

        <table class="tsample" width="100%">
            <tr><td class="p6" align="center"><label class="t2">date intervention possible:</label> </td></tr>
            <tr>

                <td class="p6">
                    <?PHP echo"<script language=\"JavaScript\" type=\"text/javascript\"> var sel1=0;var sel2=0;var sel3=0;</script>";  ?>
                    <?PHP $l = explode('-', date("y-m-d"));echo" <script>sel1=".$l["2"]." ;</script>"; ?>

                    <label class="t0">Date 1:</label>
                    <label id="lab_jour1" class="t0" style="width:70px ;text-align: center"></label>
                    <select name="jour1" id="jour1" onchange="nom_jour(this.value,mois1.value,annee1.value,1);" size="1" class="p6" style="width:40px;border:0;font-size: 8pt"   >

                        <?PHP $d=1; for($i=0;$i<31;$i++){
                            echo'<option value="'.$d.'"';echo '>'.$d.'</option>'; $d++;
                        }?>
                    </select>

                    <select name="mois1" id="mois1" onchange="remplir('jour1',this.value,annee1.value);" size="1" class="p6" style="width:40px;border:0;font-size: 8pt"  >

                        <?PHP $d=1; for($i=0;$i<12;$i++){echo'<option value="'.$d.'" ';if($l[1]==$d){echo ' selected="selected" ';}echo'>'.$d.'</option>';$d++ ;}?>
                    </select>

                    <select name="annee1" id="annee1" onchange="remplir('jour1',mois1.value,this.value);" size="1" class="p6" style="width:50px;border:0;font-size: 8pt"  >

                        <?PHP $d=date("Y"); for($i=0;$i<10;$i++){
                            echo'<option value="'.$d.'"';if($l[0]==$d){echo ' selected="selected" ';}echo'>'.$d.'</option>';$d++;
                        }?>
                    </select>
                    <br />
                    <div align="center"><label class="t0"><input checked="" type="radio" name="matin_midi1"  value="1" />Matin</label><label class="t0"> <input type="radio" name="matin_midi1" value="2" />Midi</label></div
                </td>
            </tr>
            <tr>
                <td class="p6">
                    <?PHP $l = explode('-', date("y-m-d"));echo" <script>sel2=".$l["2"]." ;</script>";  ?>
                    <label class="t0">Date 2:</label>
                    <label id="lab_jour2" class="t0" style="width:70px ;text-align: center"></label>

                    <select name="jour2" id="jour2" size="1" class="p6" onchange="nom_jour(this.value,mois2.value,annee2.value,2);" style="width:40px;border:0;font-size: 8pt"   >

                        <?PHP $d=1; for($i=0;$i<31;$i++){
                            echo'<option value="'.$d.'"';if($l[2]==$d){echo ' selected="selected" ';}    echo '>'.$d.'</option>'; $d++;
                        }?>
                    </select>

                    <select name="mois2" id="mois2" size="1" onchange="remplir('jour2',this.value,annee2.value);" class="p6" style="width:40px;border:0;font-size: 8pt"  >

                        <?PHP $d=1; for($i=0;$i<12;$i++){echo'<option  value="'.$d.'" ';if($l[1]==$d){echo ' selected="selected" ';} echo'>'.$d.'</option>';$d++;}?>
                    </select>

                    <select  name="annee2" id="annee2" size="1" onchange="remplir('jour2',mois2.value,this.value);" class="p6" style="width:50px;border:0;font-size: 8pt"  >
                        <?PHP $d=date("Y"); for($i=0;$i<10;$i++){
                            echo'<option value="'.$d.'"';if($l[0]==$d){echo ' selected="selected" ';}echo'>'.$d.'</option>'; $d++;
                        }?></select>
                    <br />
                    <div align="center"><label class="t0"><input checked="" type="radio" name="matin_midi2" value="1" />Matin</label><label class="t0"> <input type="radio" name="matin_midi2" value="2" />Midi</label></div
                </td>

            </tr>
            <tr><td class="p6">
                    <?PHP $l = explode('-', date("y-m-d"));echo" <script>sel3=".$l["2"]." ;</script>"; ?>
                    <label class="t0">Date 3:</label>
                    <label id="lab_jour3" class="t0" style="width: 70;text-align: center"></label>

                    <select name="jour3" id="jour3" onchange="nom_jour(this.value,mois3.value,annee3.value,3);" size="1" class="p6" style="width:40px;border:0;font-size: 8pt"   >

                        <?PHP $d=1; for($i=0;$i<31;$i++){
                            echo'<option value="'.$d.'"';if($l[2]==$d){echo ' selected="selected" ';}    echo '>'.$d.'</option>'; $d++;
                        }?>
                    </select>

                    <select name="mois3" id="mois3" onchange="remplir('jour3',this.value,annee3.value);" size="1" class="p6" style="width:40px;border:0;font-size: 8pt"  >

                        <?PHP $d=1; for($i=0;$i<12;$i++){ echo'<option value="'.$d.'"'; if($l[1]==$d){echo ' selected="selected" ';}  echo'>'.$d.'</option>';$d++;}?>
                    </select>

                    <select name="annee3" id="annee3" onchange="remplir('jour3',mois3.value,this.value);" size="1" class="p6" style="width:50px;border:0;font-size: 8pt" >

                        <?PHP $d=date("Y"); for($i=0;$i<10;$i++){
                            echo'<option value="'.$d.'"';if($l[0]==$d){echo ' selected="selected" ';}echo'>'.$d.'</option>'; $d++;
                        }?>
                    </select>
                    <br />
                    <div align="center"><label class="t0"><input checked="" type="radio" name="matin_midi3" value="1" />Matin</label><label class="t0"> <input type="radio" name="matin_midi3" value="2" />Midi</label></div
                </td>

            </tr>
            <tr>
                <td class="p6"><label class="t0">Acompte (frais de déplacements) : <input maxlength="8" name="acompte" <?PHP /*if($det_d["etat"]!="0"){echo ' readonly="" ';}*/?> id="acompte" style=" width:40px;font-size:12px; text-align: center;background-color: #D8D8D8;border:0px solid #585858;"  value="85<?PHP /* echo $det_d["acompte"]; */?>"/>  T.T.C.</label></td>

            </tr>
        </table>

        <br />
        <table class="tsample" width="100%" id="tab_btn_show">
            <tr>
                <td align="center"><input type="hidden" value="<?PHP echo $devis->getUtilisateur()->getEmail();  ?>" name="email"><input style="border: 1px solid #000000 ;background-color: #CCCCCC;color: #000000;text-align: center;cursor: pointer" type="button" onclick="if(test()){form1.submit();}" name="b" value="  Valider  " /> </td>
            </tr>
            <tr><td align=center><div id="aff_mail"><label class="lab">Cliquer pour Valider/Envoye par mail </label></div></td></tr>


        </table>

    </div>

</div>

</form>

<script language="JavaScript" type="text/javascript">
    /*<![CDATA[*/
    remplir('jour1',document.getElementById('mois1').value,document.getElementById('annee1').value);
    remplir('jour2',document.getElementById('mois2').value,document.getElementById('annee2').value);
    remplir('jour3',document.getElementById('mois3').value,document.getElementById('annee3').value);
    //alert(sel1);
    nom_jour(sel1,document.getElementById('mois1').value,document.getElementById('annee1').value,1);
    nom_jour(sel2,document.getElementById('mois2').value,document.getElementById('annee2').value,2);
    nom_jour(sel3,document.getElementById('mois3').value,document.getElementById('annee3').value,3);
    /*]]>*/
</script>



<script language="JavaScript" type="text/javascript">
    function test()
    {  //alert("1");
        var divEls = document.getElementsByTagName('input');
        var i = 0;

        if(document.getElementById('jour1').value==document.getElementById('jour2').value && document.getElementById('mois1').value==document.getElementById('mois2').value && document.getElementById('annee1').value==document.getElementById('annee2').value )
        {
            alert("Date1 et date2 sont identiques!! ");  return false ;
        }

        if(document.getElementById('jour1').value==document.getElementById('jour3').value && document.getElementById('mois1').value==document.getElementById('mois3').value && document.getElementById('annee1').value==document.getElementById('annee3').value )
        {
            alert("Date1 et date3 sont identiques!! ");  return false ;
        }

        if(document.getElementById('jour3').value==document.getElementById('jour2').value && document.getElementById('mois3').value==document.getElementById('mois2').value && document.getElementById('annee3').value==document.getElementById('annee2').value )
        {
            alert("Date3 et date2 sont identiques!! ");  return false ;
        }

        for(i=0;i<divEls.length;i++)
        {

            a=divEls[i].id;

            var n=a.indexOf("ext") ;

            if(n==0)
            {//alert(a);
                if(divEls[i].value=="")
                {
                    alert("Veuillez remplir tous les champs!! "); return false  ;
                }
            }

            var n=a.indexOf("int") ;
            if(n==0)
            { //alert("f2");
                if(divEls[i].value=="")
                {
                    alert("Veuillez remplir tous les champs!! ");  return false ;
                }
            }
        }


        //alert("t");
        return true;
    }

</script>
