<?php
namespace Core;

class Router
{
    private $routes = [];
    
    public function add($method, $route, $handler)
    {
        $route = trim($route, '/');
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[a-z0-9-]+)', $route);
        $route = '#^' . $route . '$#';
        
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'handler' => $handler
        ];
    }
    
    public function dispatch($method, $uri)
    {
        // Supprimer le query string et normaliser le chemin.
        $uri = parse_url((string) $uri, PHP_URL_PATH) ?? '/';

        // Retirer le chemin de base de l'application (ex: /S6/projet-iran-news/public).
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
        if ($basePath !== '' && $basePath !== '/' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        $uri = trim((string) $uri, '/');
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['route'], $uri, $matches)) {
                // Extraire les paramètres nommés
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                // Appeler le contrôleur
                $handler = explode('@', $route['handler']);
                $controllerName = '\\Controllers\\' . $handler[0];
                $methodName = $handler[1];
                
                $controller = new $controllerName();
                return $controller->$methodName($params);
            }
        }
        
        // Route non trouvée - 404
        http_response_code(404);
        echo '404 Not Found';
    }
}