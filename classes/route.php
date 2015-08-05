<?php

class Route
{
    /** @var Route */
    static private $sharedInstance;
    private $baseUrl;
    private $urlVarName;
    private $routes = array();
    private $routesDynamic = array();
    private $routesByName = array();
    
    static function sharedInstance()
    {
        if ( is_null(self::$sharedInstance))
        {
            self::$sharedInstance = new self();
        }
        return self::$sharedInstance;
    }
    
    function setBaseUrl($url)
    {
        $this->baseUrl = $url;
    }
    
    function getBaseUrl()
    {
        return $this->baseUrl;
    }
    
    function setUrlVar($varName)
    {
        $this->urlVarName = $varName;
    }
    
    function getCurrentRoute()
    {
        $urlQuery = isset($_GET[$this->urlVarName])?$_GET[$this->urlVarName]:'/';
        $currentRoute = KY::getRoute()->routeByUrl($urlQuery);
        return $currentRoute;
    }
    
    function loadRoute($route)
    {
        $controller = $route['controller'];
        $action = $route['action'];
        $params = key_exists('params', $route)?$route['params']:null;
        
        
        include 'controllers/'.$controller.'.php'; //Including the controller
        if (is_null($params))
        {
            //Call function into the controller using the content of $action as name of the function
            $action(); 
        }
        else
        {
            //Call function into the controller using the content of $action as name of the function passing the params
            $action($params); 
        }
    }
    
    function addRoute($url, $name, $controller, $action)
    {
        $url = $this->purgeTrailingSlash($url);
        $this->routes[$url] = array(
            'name'=>$name,
            'url'=>$url,
            'controller'=>$controller,
            'action'=>$action
        );
        
        $this->routesByName[$name] = &$this->routes[$url]; //Pass by reference, array is NOT duplicated
        
        
        //checkinf if the route contains :params 
        if (!$this->isStaticRoute($url))
        {
            $paramsPattern = ':([^/]+)'; 
            $paramsReplace = '(?<\1>[^/]+)';
            //converting :params into proper regular espression
            //  /db/delete/:id -> /db/delete/.* -> /db/delete/(.*) -> /db/delete/(?<id>.*)
            $regexUrl = preg_replace('|'.$paramsPattern.'|', $paramsReplace, $url);
            
            $this->routesDynamic[$regexUrl] = &$this->routes[$url];
        }
        
        
        
    }
    
    function routeByUrl($url)
    {
        $url = $this->purgeTrailingSlash($url);
        
        if (key_exists($url, $this->routes))
        {
            return $this->routes[$url];
        }
        else
        {
            $route = null;
            foreach($this->routesDynamic as $regex=>$r)
            {
                //Force the regex to match the exact string.
                // ^ refers to the "begining of string" 
                // $ refers to "end of the string"
                $completeRegex = '^'.$regex.'$';
                // test all rexex like /db/delete/(?<id>.*) against actual url /db/delete/1
                $matches = array();
                if (preg_match('|'.$completeRegex.'|', $url,$matches) === 1)
                {
                    $params = array();
                    foreach($matches as $key=>$value)
                    {
                        if (!is_int($key))
                        {
                            $params[$key]=$value;
                        }
                    }
                    $route = $r;
                    $route['params']=$params;
                    break;
                }
            }
            if (!is_null($route))
            {
                //print_r($route);
                return $route;
            }
            
        }
        
        
    }
    
    function urlForRoute($name,$params=null)
    {
        $url = $this->purgeStartingSlash($this->routesByName[$name]['url']);
        
        if (!is_null($params))
        {
            foreach($params as $key=>$value)
            {
                $url=str_replace(':'.$key, $value, $url);
            }
        }
        
        $baseurl = $this->purgeTrailingSlash($this->baseUrl);
        
        
        $url = $baseurl.'/'.$url;
        return $url;
    }
    
    private function isStaticRoute($url)
    {
        return (strstr($url,':') === FALSE);
        
    }
    
    private function purgeTrailingSlash($url)
    {
        if (strlen($url)==0)
        {
            return $url;
        }   
        return substr($url,-1) == '/' ?substr($url,0,-1):$url;
    }
    
    private function purgeStartingSlash($url)
    {
        if (strlen($url)==0)
        {
            return $url;
        }   
        return $url[0] == '/' ?substr($url,1):$url;
    }
    
}