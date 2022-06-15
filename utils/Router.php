<?php

namespace utils;

use Exception;

/**
 * class to handle requests and move them to correct controller
 */
class Router
{
    private $routes;
    private string $uri;
    private string $path;
    private string $args;
    private array $argsNamesArray = [];
    private array $argsValuesArray = [];

    public function __construct()
    {
        $this->routes = include('./config/routes.php');
    }

    /**
     * Here we start do staff wth our routes and try to find controller for them from config file
     * @return void
     * @throws Exception
     */
    public function run()
    {
//        print_r($this->routes);
        $this->parseUri();
        $this->handleRoute();
    }

    /**
     * parse address info for our needs.
     * @return void
     * @throws Exception
     */
    private function parseUri()
    {
        $this->uri = trim($_SERVER['REQUEST_URI'],'/');
        $this->path = parse_url($this->uri,PHP_URL_PATH) ?? "";
        $this->args = parse_url($this->uri,PHP_URL_QUERY) ?? "";
        if($this->args != ""){
            $argsParsed = explode('&',$this->args);
            $argsValuesArray = [];
            foreach ($argsParsed as $k =>$arg){
                $parsed = explode("=",$arg);
                $argsParsed[$k] = $parsed[0];
                if($parsed[1] != ""){
                    $argsValuesArray[] = $parsed[1];
                } else {
                    throw new Exception('Some args are empty');
                }
            }
            $this->argsValuesArray = $argsValuesArray;
            $this->argsNamesArray = $argsParsed;
        }
    }

    /**
     * Here we try to detect where we go, which one controller need
     * @return void
     * @throws Exception
     */
    private function handleRoute()
    {
        $cntrlValue = [];
        if($this->uri==""){
            $cntrlValue = $this->routes['indexRoute'];
        } else {
            $pathParsed = explode('/',$this->path);
            foreach ($this->routes['customRoutes'] as $uriTemplate=> $cntrlInfo){
                $tmplPath = parse_url($uriTemplate,PHP_URL_PATH);
                $tmplPathParsed = explode('/',$tmplPath);
                if(count($tmplPathParsed) == count($pathParsed)){
                    foreach ($tmplPathParsed as $k => $p){
                        if($pathParsed[$k] != $p && !($k == count($tmplPathParsed)-1 && $pathParsed[$k] == $p.".php")){
                            break;
                        } else {
                            if($k == count($tmplPathParsed)-1){
                                // here we go when all parts of the path correct for current path template, and now we check params list
                                $tmplArgs = parse_url($uriTemplate,PHP_URL_QUERY);
                                if($tmplArgs != ""){
                                    $tmplArgsParsed = explode("&",$tmplArgs);
                                    if(count($tmplArgsParsed) == count($this->argsNamesArray)){
                                        foreach ($tmplArgsParsed as $tak=> $tmplArg){
                                            if($tmplArg != $this->argsNamesArray[$tak]){
                                                break;
                                            } else {
                                                if($tak == count($tmplArgsParsed)-1){
                                                    $cntrlValue = $cntrlInfo;
                                                    break 3;
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if(count($this->argsNamesArray) == 0){
                                        $cntrlValue = $cntrlInfo;
                                        break 2;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if(!$cntrlValue){
            $cntrlValue = $this->routes['notFoundRoute'];
        }
        $cntrlValueParsed = explode('/',$cntrlValue);
        if(count($cntrlValueParsed) == 2){
            $controllerName = $cntrlValueParsed[0];
            $methodName = $cntrlValueParsed[1];
            if(class_exists('\controllers\\'.$controllerName)){
                if(method_exists('\controllers\\'.$controllerName,$methodName)){
                    $controllerClass = '\controllers\\'.$controllerName;
                    $controller = new $controllerClass;
                    $controller->$methodName(...$this->argsValuesArray);
                } else {
                    throw new Exception("Controller's method from configuration for route $cntrlValue does not exist ");
                }
            } else {
                throw new Exception("Controller from configuration for route $cntrlValue does not exist ");
            }
//            echo " ".$controllerName." ".$methodName;
        } else {
            throw new Exception("Bad configuration for route".$cntrlValue);
        }
    }
}
