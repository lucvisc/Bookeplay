<?php
/**
 * La classe CFrontController gestisce il collegamento tra le varie classi dei controller
 * @author Luca, Catriel
 * @package Controller
 */
require_once 'include.php';
//require_once 'ConfSmarty.php';

class CFrontController {

    public function run($path){
        $request = preg_split("#[][&?/]#", $path);
        $controller="C".$request[2];

        print_r($path); echo "\n";
        print_r($controller); echo "\n";

        if(class_exists($controller)){
            $function=$request[3];

            print_r($function); echo "\n";

            if(method_exists($controller,$function)) {
                $param = array();
                for ($i = 4; $i < count($request); $i++) {
                    $param[] = $request[$i];
                }
                if (count($param) == 1) $controller::$function($param[0]);
                else if (count($param) == 2) $controller::$function($param[0], $param[1]);
                else if (count($param) == 3) $controller::$function($param[0], $param[1], $param[2]);
                else {
                    print "ok";
                    print_r($controller);
                    echo "\n";
                    print_r($function);
                    echo "\n";
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


    /*public function run($path)
    {
        $resource = explode('/', $path);
        print_r($path); echo "\n";

        array_shift($resource);
        array_shift($resource);
        print_r($resource); echo "\n";

        if ($resource[0] != 'api') {

            $controller = "C" . $resource[0];
            print_r($controller); echo "\n";
            $dir = 'Controller';
            $eledir = scandir($dir);
            print_r($eledir); echo "\n";

            if (in_array($controller . ".php", $eledir)) {
                if (isset($resource[1])) {
                    $function = $resource[1];
                    print_r($function); echo "\n";
                    if (method_exists($controller, $function)) {

                        $param = array();
                        for ($i = 2; $i < count($resource); $i++) {
                            $param[] = $resource[$i];
                            $a = $i - 2;
                        }
                        $num = (count($param));
                        print_r($num); echo "\n";
                        if ($num == 0) {print "ok";
                                        print ($controller);  echo "\n";
                                        print ($function);  echo "\n";
                            $controller::$function();
                        }
                        else if ($num == 1) $controller::$function($param[0]);
                        else if ($num == 2) $controller::$function($param[0], $param[1]);
                        //else if ($num == 3) $controller::$function($param[0], $param[1], $param[2]);
                        //else if ($num == 4) $controller::$function($param[0], $param[1], $param[2], $param[3]);
                        //else if ($num == 5) $controller::$function($param[0], $param[1], $param[2], $param[3], $param[4]);
                        //else if ($num == 6) $controller::$function($param[0], $param[1], $param[2], $param[3], $param[4], $param[5]);

                    } else {
                        if (CUser::isLogged()) {
                            $utente = unserialize($_SESSION['account']);
                            if ($utente->getEmail() == 'admin@admin.com')
                                header('Location: /BookAndPlay/Admin/homepage');
                            else {
                                CUser::showHomepage();
                            }
                        } else {
                            CUser::showHomepage();
                        }
                    }
                } else {
                    if (CUser::isLogged()) {
                        $utente = unserialize($_SESSION['account']);
                        if ($utente->getEmail() == 'admin@admin.com')
                            header('Location: /BookAndPlay/Admin/homepage');
                        else {
                            CUser::showHomepage();
                        }
                    } else {
                        CUser::showHomepage();
                    }
                }
            } else {
                if (CUser::isLogged()) {
                    $utente = unserialize($_SESSION['account']);
                    if ($utente->getEmail() == 'admin@admin.com')
                        header('Location: /BookAndPlay/Admin/homepage');
                    else {
                        CUser::showHomepage();
                    }
                } else {
                    CUser::showHomepage();
                }
            }

        }
    }
    */
}

?>