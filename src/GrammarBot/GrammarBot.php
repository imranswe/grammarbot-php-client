<?php 

namespace GrammarBot;

class GrammarBot {
	
	/**
     * HTTP Methods
     */
    const HTTP_METHOD_GET    = 'GET';
    const HTTP_METHOD_POST   = 'POST';

	protected $base_uri = 'http://api.grammarbot.io/v2';

	protected $endpoint = '/check';

	protected $api_key = 'php-default';

	protected $language = 'en-US';
	
	/**
     * The path to the certificate file to use for https connections
     *
     * @var string  Defaults to .
     */
    protected $certificate_file = null;

    /**
     * cURL options
     *
     * @var array
     */
    protected $http_headers = array("Content-Type"=>"application/json");

	/**
     * cURL options
     *
     * @var array
     */
    protected $curl_options = array();

    /**
     * Construct
     *
     * @param string $base_uri
     * @param string $api_key
     * @param string $endpoint
     * @param string $language
     * @param string $certificate_file Indicates if we want to use a certificate file to trust the server. Optional, defaults to null.
     * @return void
     */
    public function __construct($base_uri = null, $endpoint = null, $api_key = null, $language = 'en-US', $certificate_file = null)
    {
        if (!extension_loaded('curl')) {
            throw new Exception('The PHP exention curl must be installed to use this library.', Exception::CURL_NOT_FOUND);
        }

        $this->base_uri = ($base_uri) ? $base_uri : $this->base_uri;

        $this->endpoint     = ($endpoint) ? $endpoint : $this->endpoint;

        $this->api_key     = ($api_key) ? $api_key : $this->api_key;
        
        $this->language   = ($language) ? $language : $this->language;
        
        $this->certificate_file = $certificate_file;
        
        if (!empty($this->certificate_file)  && !is_file($this->certificate_file)) {
            throw new InvalidArgumentException('The certificate file was not found', InvalidArgumentException::CERTIFICATE_NOT_FOUND);
        }
    }

    /**
     * Set the API_BASE_URI $base_uri
     *
     * @return void
     */
    public function setBaseUri($base_uri)
    {
        $this->base_uri = $base_uri;
    }


	/**
     * Set the Resource End Point URL $endpoint
     *
     * @return void
     */
    public function setEndPoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Set the API_KEY $api_key
     *
     * @return void
     */
    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * Set the LANGUAGE $language
     *
     * @return void
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Set an option for the curl transfer
     *
     * @param int   $option The CURLOPT_XXX option to set
     * @param mixed $value  The value to be set on option
     * @return void
     */
    public function setCurlOption($option, $value)
    {
        $this->curl_options[$option] = $value;
    }

    /**
     * Set multiple options for a cURL transfer
     *
     * @param array $options An array specifying which options to set and their values
     * @return void
     */
    public function setCurlOptions($options)
    {
        $this->curl_options = array_merge($this->curl_options, $options);
    }

    /**
     * Parse text
     *
     * @param string $text The required text to be parsed by the bot API
     * @return array
     */
    public function check($text)
    {
        if (empty($text)) {
            
            throw new InvalidArgumentException('The text to be parsed can not be empty.');
        }

        if (!$this->base_uri) {
            
            throw new Exception('Base URI must be set before making API call(s)');
        }

        if (!$this->endpoint) {
            
            throw new Exception('API endpoint must not be empty.');
        }

        if (!$this->api_key) {
            
            throw new Exception('API Key is required to make API call.');
        }

        $url = $this->base_uri . $this->endpoint;

        $parameters = array("api_key"=> $this->api_key,"language"=>$this->language, "text"=>$text);
        
        return $this->executeRequest($url, $parameters);
    }

    /**
     * Execute a request (with curl)
     *
     * @param string $url URL
     * @param mixed  $parameters Array of parameters
     * @param string $http_method HTTP Method
     * @param array  $http_headers HTTP Headers
     * @param int    $form_content_type HTTP form content type to use
     * @return array
     */
    private function executeRequest($url, $parameters = array())
    {
        $curl_options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CUSTOMREQUEST  => 'GET'
        );

        if (is_array($parameters) && count($parameters) > 0) 
        {
            $url .= '?' . http_build_query($parameters, null, '&');
        } 
        elseif ($parameters) 
        {
            $url .= '?' . $parameters;
        }

        $curl_options[CURLOPT_URL] = $url;

        if (is_array($this->http_headers)) {
            $header = array();
            foreach($this->http_headers as $key => $value) {
                $header[] = "$key: $value";
            }
            $curl_options[CURLOPT_HTTPHEADER] = $header;
        }

        $ch = curl_init();
        curl_setopt_array($ch, $curl_options);
        // https handling
        if (!empty($this->certificate_file)) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_CAINFO, $this->certificate_file);
        } else {
            // bypass ssl verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }
        if (!empty($this->curl_options)) {
            curl_setopt_array($ch, $this->curl_options);
        }
        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        if ($curl_error = curl_error($ch)) {
            throw new Exception($curl_error, Exception::CURL_ERROR);
        } else {
            $json_decode = json_decode($result);
        }
        curl_close($ch);

        return (null === $json_decode) ? $result : $json_decode;
    }
}