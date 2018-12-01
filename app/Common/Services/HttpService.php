<?php
namespace App\Common\Services;

use Log;
use Exception;

class HttpService
{
    const ACCESS_TOKEN_CACHE_KEY = "";
    const ACCESS_TOKEN_CACHE_SEC = 3600;

    private static $boundary = '';

    public function __construct()
    {
    }

    public static function get($url, $params = null)
    {
        if (!empty($params)) {
            if (stripos($url, "?") !== false) {
                $url = $url . '&' . http_build_query($params);
            } else {
                $url = $url . '?' . http_build_query($params);
            }
        }
        return self::http($url, 'GET');
    }

    public static function post($url, $params, $files = array())
    {
        $headers = array();
        if (!$files) {
            $body = $params;
        } else {
            $body = self::build_http_query_multi($params, $files);
            $headers[] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
        }
        return self::http($url, 'POST', $body, $headers);
    }

    public static function postJson($url, $params, $headers = array())
    {
        $body = $params;
        $headers[] = "Content-Type:application/json";
        return self::http($url, 'POST', $body, $headers);
    }

    /**
     * Make an HTTP request
     *
     * @return string API results
     * @ignore
     */

    public static function http($url, $method, $postfields = null, $headers = array())
    {
        $curl = curl_init();
        /* Curl settings */
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, config('params.curl_connecttimeout'));
        curl_setopt($curl, CURLOPT_TIMEOUT, config('params.curl_exectimeout'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);

        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                if (!empty($postfields)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
                }
                break;
        }

        $response = curl_exec($curl);
        $curl_error = curl_error($curl);
        curl_close($curl);
        if ($response === false || $curl_error) {
            throw new Exception(json_encode(['url' => $url, 'postfields' => $postfields, 'headers' => $headers,
                'method' => $method, 'response' => $response, 'curl_error' => $curl_error], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }
        return $response;
    }

    private static function build_http_query_multi($params, $files)
    {
        if (!$params) {
            return '';
        }

        $pairs = array();

        self::$boundary = $boundary = uniqid('------------------');
        $MPboundary = '--' . $boundary;
        $endMPboundary = $MPboundary . '--';
        $multipartbody = '';

        foreach ($params as $key => $value) {
            $multipartbody .= $MPboundary . "\r\n";
            $multipartbody .= 'content-disposition: form-data; name="' . $key . "\"\r\n\r\n";
            $multipartbody .= $value . "\r\n";
        }
        foreach ($files as $key => $value) {
            if (!$value) {
                continue;
            }

            if (is_array($value)) {
                $url = $value['url'];
                if (isset($value['name'])) {
                    $filename = $value['name'];
                } else {
                    $parts = explode('?', basename($value['url']));
                    $filename = $parts[0];
                }
                $field = isset($value['field']) ? $value['field'] : $key;
            } else {
                $url = $value;
                $parts = explode('?', basename($url));
                $filename = $parts[0];
                $field = $key;
            }
            $content = file_get_contents($url);

            $multipartbody .= $MPboundary . "\r\n";
            $multipartbody .= 'Content-Disposition: form-data; name="' . $field . '"; filename="' . $filename . '"' . "\r\n";
            $multipartbody .= "Content-Type: image/unknown\r\n\r\n";
            $multipartbody .= $content . "\r\n";
        }

        $multipartbody .= $endMPboundary;
        return $multipartbody;
    }
}
