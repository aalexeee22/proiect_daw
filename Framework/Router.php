<?php
class Router {
    protected $routes = [];
    public function registerRoute($method,$uri, $controller) {
        $this->routes[] =[
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller
        ];
    }
    public function get($uri, $controller) {
        $this->registerRoute('GET', $uri, $controller);
    }
    public function post($uri, $controller) {
        $this->registerRoute('POST', $uri, $controller);
    }
    public function put($uri, $controller) {
        $this->registerRoute('PUT', $uri, $controller);
    }
    public function delete($uri, $controller) {
        $this->registerRoute('DELETE', $uri, $controller);
    }
    public function route($uri, $method) {
        if($method == 'POST'&& isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }
        foreach ($this->routes as $route) {
            if ($route['uri'] == $uri) {
                require basePath('App/'.$route['controller']);
                return;
            }
        }
        loadView('error/404');
        exit;
    }
}

?>