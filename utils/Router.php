<?php

namespace utils;

/**
 * Our class to handle requests
 */
class Router
{
    private $routes;

    private string $uri;
    private string $path;
    private string $args;

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
        print_r($this->routes);
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
        $this->args = parse_url($this->uri,PHP_URL_QUERY);
    }

    /**
     * Here we try to detect where we go, which one controller need
     * @return void
     */
    protected function handleRoute()
    {
        $isFounded = false;
        if($this->uri==""){
            $isFounded=true;
        } else {
            $isFounded=true;
            $pathParsed = explode('/',$this->path);
            foreach ($this->routes['customRoutes'] as $uriTemplate=> $cntrlInfo){
                $tmplPath = parse_url($uriTemplate,PHP_URL_PATH);
                $tmplPathParsed = explode('/',$tmplPath);
                if(count($tmplPathParsed) == count($pathParsed)){
                    foreach ($tmplPathParsed as $k => $p){

                        if($pathParsed[$k] != $p){
                            break;
                        } else {
                            if($k == count($tmplPathParsed)-1){
                                echo " ".$uriTemplate." ";
                                $tmplArgs = explode(parse_url($uriTemplate,PHP_URL_QUERY),"&");
                                print_r($tmplArgs);
//                                foreach ($tmplArgs as $ka =>$va){
//                                    if($va)
//                                }
                                echo 'we found route';
                            }
                        }
                    }
                }
            }
        }
//        if($uri == ""){
//            $this->routes['indexRoute'];
//            $isFounded = true;
//        } else {
//            $parsedUriValue = explode('/', $uri);
//
//            foreach ($parsedUriValue as $uriPart){
//                foreach ($this->routes['customRoutes'] as $uriPartFrom => $path){
//
//                }
//            }
//
////            foreach($this->routes['customRoutes'] as $uriPattern => $path)
////            {
////                if(preg_match("~$uriPattern~", $uri) && $uriPattern != "")
////                {
////                    $foundedValue = explode('/', $path);
////                    $isFounded = true;
////                    break;
////                }
////            }
//        }
//
//        if(!$isFounded){
//            $this->routes['notFoundRoute'];
//        } else {
//
//        }
    }

    /**
     * @return void
     */
    protected function handleNotFound(){

    }
}
