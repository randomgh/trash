<?php

class GithubWebhook {

    protected $project;
    protected $secret;

    protected $headers = array();

    public function __construct($project, $secret = '') {
        $this->project = $project;
        $this->secret = $secret;

        $headers = getallheaders();

        foreach ($headers as $title => $content) {
            $this->headers[strtolower($title)] = $content;
        }
    }

    public function __destruct() {

    }

    public function run() {
        if (!$this->headers['content-type']) {
            throw new \Exception("Missing HTTP 'content-type' header.");
        } elseif (!$this->headers['x-github-event']){
            throw new \Exception("Missing HTTP 'x-github-event' header.");
        }

        if (!isset($this->headers['x-hub-signature'])) {
            throw new \Exception("HTTP header 'x-hub-signature' is missing.");
        } elseif (!extension_loaded('hash')) {
            throw new \Exception("Missing 'hash' extension to check the secret code validity.");
        }

        list($algorithm, $hash) = explode('=', $this->headers['x-hub-signature'], 2) + array('', '');
        if (!in_array($algorithm, hash_algos(), TRUE)) {
            throw new \Exception("Hash algorithm {$algorithm} is not supported.");
        }

        $raw = file_get_contents('php://input');
        if ($hash !== hash_hmac($algorithm, $raw, $this->secret)) {
            throw new \Exception("Hook secret does not match.");
        }

        $json = $_POST['payload'];
        $payload = json_decode($json);

        switch (strtolower($this->headers['x-github-event'])) {
            case 'ping':
                header('HTTP/1.0 200 OK');
                echo "Event: ".$this->headers['x-github-event']."\n\nPayload: \n";
                print_r($payload);
                die();
                break;
            case 'push':
                $banch = array_pop(explode('/', $payload->ref));

                if (!in_array($banch, array('master', 'develop'))) {
                    throw new \Exception("Unknown branch {$banch}.");
                } else {
                    $out = shell_exec("cd /var/www/{$this->project}/{$banch}/ && git reset HEAD --hard && git pull");

                    header('HTTP/1.0 200 OK');
                    echo "Event: ".$this->headers['x-github-event']."\n\nOut: \n".$out."\n\nPayload: \n";
                    print_r($payload);
                    die();
                }
                break;
            default:
                header('HTTP/1.0 404 Not Found');
                echo "Event: ".$this->headers['x-github-event']."\n\nPayload: \n";
                print_r($payload);
                die();
        }
    }
}
