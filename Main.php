<?php

require_once 'include.php';


/*$view = new VUser();
$view->showFormLogin();
$info= new VInfo();
$info->showInformazioni();
*/
$index= new VIndex();
$index->showHomepage();

/*$booking = new EBooking('','professionista','livello molto alto');
FBooking::store($booking);
FPren_creata::insert('1','luca.visco@hotmail.com');
FFasceorarie::update('08:00-09:00','Non Disponibile', 'giornoFascia', '19/09/2019');
*/
/*$acc=new EAccount("luca.visco@hotmail.com", "lucvisc", "lucvisc", "0123456789", 0, "Livello medio", "1");
$adr=new EAddress("Popoli", "PE", "65026", "Viale dei tigli ", "26");
$use=new EUser("Luca", "Visconti", "19/09/1997", "M", $adr, $acc);

$booking=new EBooking("basso", "20/03/2001", "8.00-9.00","");
FBooking::store($booking);

/*$acc=new EAccount("bla", "blu", "bli", "0123456789", 0, "blu", "1");
$adr=new EAddress("Pescara", "PE", "65120", "Via sela", "134");
$use=new EUser("blabla", "blibli", "00/00/2000", "M", $adr, $acc);
>>>>>>> eb42dd5f5e6d41b614a900c8744c7233d0534866
FAccount::store($acc, $use, $adr);
*/
//FAccount::update('conto', '50','conto','luca.visco@hotmail.com');
//FAccount::delete('email', 'luca.visco@hotmail.com')

/*$acc=FAccount::loadByField("username", "Garcia");
print_r($acc);
$acc=Faccount::exist("username", "Garcia");
print ("$acc\n");
FAccount::update("username", "Zorro", "username", "Garcia");
$acc=FAccount::loadByField("username", "Zorro");
print_r($acc);
$tot=FAccount::loadContoTot();
print("$tot[totale]\n");
$acc=FAccount::LoadAccount("Zorro");
print_r($acc);
$bo=Faccount::delete("username", "Zorro");
echo $bo;*/

//FAccount::deleteAccount($var51);
/*
$var70 ='ERFJ678';
$var71 =new EGiorno('10/12/2019');
$var72 = 60.5;
$var73 = array('Luca','Catriel','Giovanni','Franco','Francesco');
$var74= new EBooking($var70, $var71, $var72, $var73);
print_r($var74);
//print $var71[08]['Disp'];
*/
//$var71 =new EGiorno('14/12/2019');
///rint_r($var71);

/*
$var72 = $var71->getSingolaFasciaOraria(10);
$var72 = $var72."-->".$var71->getDisponibilta(10 );
print_r($var72);
*/

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


?>