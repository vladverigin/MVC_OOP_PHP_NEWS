<?php

namespace utils;

/**
 * class to handle requests and move them to correct controller
 */
class Router
{
    private $routes;
    private string $uri;
    private string $path;
    private string $args;
    private array $argsArray = [];

    public function __construct()
    {
        $this->routes = include('./config/routes.php');
    }

    /**
     * Here we start do staff wth our routes and try to find controller for them from config file
     * @return void
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
     */
    protected function parseUri()
    {
        $this->uri = trim($_SERVER['REQUEST_URI'],'/');
        $this->path = parse_url($this->uri,PHP_URL_PATH);
        $this->args = parse_url($this->uri,PHP_URL_QUERY) ?? "";
        if($this->args != ""){
            $argsParsed = explode('&',$this->args);
            foreach ($argsParsed as $k =>$arg){
                $argsParsed[$k] = explode("=",$arg)[0];
            }
            $this->argsArray = $argsParsed;
        }
    }

    /**
     * Here we try to detect where we go, which one controller need
     * @return void
     */
    protected function handleRoute()
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
                                    if(count($tmplArgsParsed) == count($this->argsArray)){
                                        foreach ($tmplArgsParsed as $tak=> $tmplArg){
                                            if($tmplArg != $this->argsArray[$tak]){
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
                                    if(count($this->argsArray) == 0){
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
        print_r($cntrlValue);
    }

    /**
     * @return void
     */
    protected function handleNotFound(){

    }
}
