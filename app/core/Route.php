<?php 
namespace App\core;

class Route{

    //Store All routes
    private $route=[];

    //Add a route
    public function add($uri, $controller,$action, $method){
        $this->route[] = ['controller' => $controller,'action'=>$action,'method' => $method,'uri'=>$uri];
    }

    //Store get method  routes
    public function get($uri, $controller, $action):void
    {
          $this->add($uri, $controller, $action, 'GET');
    }


    //Store post method routes

    public function post($uri, $controller, $action):void
    {
        $this->add($uri, $controller, $action, 'POST');
    }

    public function delete($uri, $controller, $action):void
    {
        $this->add($uri, $controller, $action, 'DELETE');
    }

    public function put($uri, $controller, $action):void
    {
        $this->add($uri, $controller, $action, 'PUT');
    }

    public function patch($uri,$controller,$action):void
    {
       $this->add($uri,$controller,$action,'PATCH');    
    }

    public function route()
    {
        //get the requested uri
        $uri = explode('?',$_SERVER['REQUEST_URI']);
        //dd($uri);
        $method=$_SERVER['REQUEST_METHOD'];

        if($method == 'POST' || isset($_POST['_method']))
        {
            $method = $_POST['_method']??'POST';
        }

       //  dd($uri);
        //check uri and method is valid or not
        //dd($this->route);

        foreach($this->route as $route){

            
            if($this->uriCheck($route['uri'],$uri[0]) && $route['method']==strtoupper($method)){
               
                $controller=new $route['controller'];

                
                if($this->checkParameter($route['uri'],$uri[0])==false)
                {
                    return $controller->{$route['action']}();
                }
                
                return $controller->{$route['action']}($this->checkParameter($route['uri'],$uri[0]));
                
            }

        }

       
        
        //if no route found
        $this->abort('No route found');
       

    }

    private function uriCheck($routeUri,$reqUri):bool
    {
        if($reqUri == $routeUri){
            return true;
        }
       
        $routeUri=explode('/',trim( $routeUri,'/'));
        $reqUri=explode('/',trim( $reqUri,'/'));
       // dd($reqUri);
        if($reqUri[0] != $routeUri[0]){
            return false;
        }
        if(count($reqUri)!=count($routeUri)){
          return false;
        }
        foreach($routeUri as $index=>$route){
            if($route=='{id}')
            {
              continue;
            }
            if($route!=$reqUri[$index])
            {
              return  false;
            }
        }

        return true;
    }

    private function checkParameter(string $routeUri,string $reqUri):bool|string
    {
       // dd("HI");
        $routeUri=explode('/',trim( $routeUri,'/'));
        $reqUri=explode('/',trim( $reqUri,'/'));
        if($routeUri[count($routeUri)-1]=='{id}')
        {
            return $reqUri[count($routeUri)-1];
        }
        return false;
    }

    public function abort(string $message, int $code=404)
    {
        http_response_code($code);
        //require_once __DIR__.'/../../views/errors/__404.php';
        return view('errors/__404',['message'=>$message]);
        exit;
    }
}

?>