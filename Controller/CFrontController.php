<?php
/**
 * La classe CFrontController gestisce il collegamento tra le varie classi dei controller
 * @author Luca, Catriel
 * @package Controller
 */
require_once 'include.php';

class CFrontController {

    /**
     * Funzione utilizzata per eseguire e collegare le varie classi, le loro funzioni e i vari parametri passati
     * @param $path
     * @throws SmartyException
     */
    public function run($path){
        $request = preg_split("#[][&?/]#", $path);
        $controller="C".$request[2];
        if(class_exists($controller)){
            $function=$request[3];
            if(method_exists($controller,$function)) {
                $param = array();
                for ($i = 4; $i < count($request); $i++) {
                    $param[] = $request[$i];
                }
                if (count($param) == 1) {
                    $controller::$function($param[0]);
                }
                else if (count($param) == 2) $controller::$function($param[0], $param[1]);
                else if (count($param) == 3) $controller::$function($param[0], $param[1], $param[2]);
                else {
                    $controller::$function();
                }
            }
            else{
                $smarty=ConfSmarty::configuration();
                if(!CUser::isLogged()) {
                    $smarty->display('index.tpl');
                }
                else{
                    $smarty->assign('userlogged',$_SESSION['account']);
                    $smarty->display('index.tpl');
                }
            }
        }
        else{
            $smarty=ConfSmarty::configuration();
            if(!CUser::isLogged()){
                $smarty->display('index.tpl');}
            else{
                $smarty->assign('userlogged',$_SESSION['account']);
                $smarty->display('index.tpl');
            }
        }
    }
}

?>