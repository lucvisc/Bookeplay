<?php
require('Smarty/Smarty.class.php');

class ConfSmarty{
   static function configuration(){
   $smarty=new Smarty();
   $smarty->template_dir='Smarty/template/';
   $smarty->compile_dir='Smarty/templates_c/';
   $smarty->config_dir='Smarty/configs/';
   $smarty->cache_dir='Smarty/cache/';
   return $smarty;
   }
}

