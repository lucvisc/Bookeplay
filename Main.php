<?php

require_once 'include.php';
$acc=new EAccount("bla", " ", "bli", "0123456789", 0, "blu", "1");
$adr=new EAddress("Pescara", "PE", "65120", "Via sela", "134");
$use=new EUser("blabla", "blibli", "00/00/2000", "M", $adr, $acc);
FAccount::store($acc, $use, $adr);

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




?>