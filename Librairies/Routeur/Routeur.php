<?php
namespace App\Routeur;
/*
Author: fpodev (fpodev@gmx.fr)
Routeur.php (c) 2020
Desc: Gestion des routes
Created:  2020-04-14T08:10:34.130Z
Modified: !date!
*/


use Exception;
use App\Routeur\Route;
class Routeur{
    
     private $routes=[];
     private $namedRoutes = [];
     private $url;      

    public function __construct($url)
    {                    
        $this->url = $url;
    }
      
    public function get($path, $callable, $name = null){
        return $this->add($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null){
        return $this->add($path, $callable, $name, 'POST');
    }

    private function add($path, $callable, $name, $method){
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null){
            $name = $callable;
        }
        if($name){
            $this->namedRoutes[$name] = $route;
        }
        
        return $route;
    }

    public function run(){
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new Exception('REQUEST_METHOD does not exist');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call();
            }
        }
        throw new Exception('No matching routes');
    }

    public function url($name, $params = []){
        if(!isset($this->namedRoutes[$name])){
            throw new Exception('No route matches this name');
        }        
        return $this->namedRoutes[$name]->getUrl($params);
    }

}

      
       