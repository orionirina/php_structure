<?php

/**
 * Class HttpRequest
 * Manages HTTP client requests, including method, parameters, headers, and sanitization.
 */
class HttpRequest {
    /**
     * @var string HTTP method (GET, POST, etc.)
     */
    private $method;

    /**
     * @var array GET parameters
     */
    private $get;

    /**
     * @var array POST parameters
     */
    private $post;

    /**
     * @var array URL parameters (e.g., from route /reservations/{id})
     */
    private $params;

    /**
     * @var array Request headers
     */
    private $headers;

    /**
     * @var string Request URI
     */
    private $uri;

    /**
     * @var string Client IP address
     */
    private $clientIp;

    /**
     * HttpRequest constructor.
     * Initializes the request data.
     */
    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->get = $_GET ?? [];
        $this->post = $_POST ?? [];
        $this->params = [];
        $this->uri = $_SERVER['REQUEST_URI'] ?? '/';
        $this->clientIp = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $this->headers = $this->getAllHeaders();
    }

    /**
     * Get the HTTP method.
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Get a GET parameter by key.
     * @param string $key
     * @param mixed $default Default value if key does not exist
     * @return mixed
     */
    public function getQuery($key, $default = null) {
        return $this->sanitize($this->get[$key] ?? $default);
    }

    /**
     * Get all GET parameters.
     * @return array
     */
    public function getQueryParams() {
        return array_map([$this, 'sanitize'], $this->get);
    }

    /**
     * Get a POST parameter by key.
     * @param string $key
     * @param mixed $default Default value if key does not exist
     * @return mixed
     */
    public function getPost($key, $default = null) {
        return $this->sanitize($this->post[$key] ?? $default);
    }

    /**
     * Get all POST parameters.
     * @return array
     */
    public function getPostParams() {
        return array_map([$this, 'sanitize'], $this->post);
    }

    /**
     * Get an URL parameter by key.
     * @param string $key
     * @param mixed $default Default value if key does not exist
     * @return mixed
     */
    public function getParam($key, $default = null) {
        return $this->sanitize($this->params[$key] ?? $default);
    }

    /**
     * Set an URL parameter.
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setParam($key, $value) {
        $this->params[$key] = $value;
    }

    /**
     * Get the request URI.
     * @return string
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * Get the client IP address.
     * @return string
     */
    public function getClientIp() {
        return $this->clientIp;
    }

    /**
     * Get a specific header.
     * @param string $key
     * @param mixed $default Default value if header does not exist
     * @return string|null
     */
    public function getHeader($key, $default = null) {
        $key = strtoupper(str_replace('-', '_', $key));
        return $this->headers[$key] ?? $default;
    }

    /**
     * Get all headers.
     * @return array
     */
    private function getAllHeaders() {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headerKey = str_replace('HTTP_', '', $key);
                $headers[$headerKey] = $value;
            }
        }
        return $headers;
    }

    /**
     * Sanitize input data to prevent XSS and other issues.
     * @param mixed $data
     * @return mixed
     */
    private function sanitize($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        if (is_string($data)) {
            return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
        }
        return $data;
    }

    /**
     * Check if the request method matches the given method.
     * @param string $method
     * @return bool
     */
    public function isMethod($method) {
        return strtoupper($this->method) === strtoupper($method);
    }
}
?>