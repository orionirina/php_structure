<?php
require_once 'includes/functions.php';

/**
 * Class HttpResponse
 * Manages HTTP responses, including rendering templates and setting HTTP status codes.
 */
class HttpResponse {
    /**
     * @var int HTTP status code
     */
    private $statusCode;

    /**
     * @var array Data to pass to the template
     */
    private $data;

    /**
     * HttpResponse constructor.
     * @param int $statusCode HTTP status code (default: 200)
     * @param array $data Data to pass to the template (default: empty array)
     */
    public function __construct($statusCode = 200, $data = []) {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }

    /**
     * Set the HTTP status code.
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Add or update data to pass to the template.
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setData($key, $value) {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * Render a template with the provided data and send the response.
     * @param string $templatePath Path to the template file
     * @return void
     */
    public function render($templatePath) {
        // Set the HTTP status code
        http_response_code($this->statusCode);

        // Call the render function with the template path and data
        render($templatePath, $this->data);
    }

    /**
     * Redirect to a specified URL with an optional status code.
     * @param string $url
     * @param int $statusCode
     * @return void
     */
    public function redirect($url, $statusCode = 302) {
        $this->statusCode = $statusCode;
        http_response_code($this->statusCode);
        header("Location: $url");
        exit;
    }
}
?>