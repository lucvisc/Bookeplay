<?php
//include "EAdmin.php";
//include "EAccount.php";
include "EGiorno.php";
//include "EBooking.php";

/*
$var70 ='ERFJ678';
$var71 =new EGiorno('10/12/2019');
$var72 = 60.5;
$var73 = array('Luca','Catriel','Giovanni','Franco','Francesco');
$var74= new EBooking($var70, $var71, $var72, $var73);
print_r($var74);
//print $var71[08]['Disp'];
*/
$var71 =new EGiorno('14/12/2019');
///rint_r($var71);

$var72 = $var71->getSingolaFasciaOraria(10);
$var72 = $var72."-->".$var71->getDisponibilta(10 );
print_r($var72);

/*
$var= "25/10/2019";
$comodo=EGiorno::verificaGiorno($var);
if($comodo==true){
	$var2=new EGiorno($var);
	print_r($var2);
}
else echo "cat scemo";
*/

/*
$var1='ERD5678';
$var2='CiaoLuca';
$var3='geegexrxfex@univaq.it';
$var4=45.6;

$var=new EAccount($var1, $var2, $var3, $var4);
print_r($var);

echo $var5=50;
echo "\n";
echo $var->RicaricaAccount($var5);
print_r($var);
*/

/*
$var40= "15/10/2019";
echo $var40;
//$var41= array('9.00-10.00', 'Disponibile');
$var41=new EGiorno($var40);
//$var42->setFasceOrarie();
print_r($var41);
*/

?>