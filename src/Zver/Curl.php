<?php

namespace Zver;

use Zver\Curl\Response;

class Curl
{
    protected $handle = null;

    protected function __construct($handle)
    {
        $this->handle = $handle;
    }

    protected static function init()
    {
        $options = [
            CURLOPT_USERAGENT         => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36',
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_AUTOREFERER       => true,
            CURLOPT_SSL_VERIFYPEER    => false,
            CURLOPT_SSL_VERIFYHOST    => 0,
            CURLOPT_FOLLOWLOCATION    => true,
            CURLOPT_TIMEOUT           => 120,
            CURLOPT_CONNECTTIMEOUT    => 120,
            CURLOPT_UNRESTRICTED_AUTH => true,
        ];

        $curlHandle = curl_init();
        if (!is_resource($curlHandle)) {
            throw new \Exception('Can\'t init curl');
        }

        $curl = new static($curlHandle);

        foreach ($options as $optionName => $optionValue) {
            $curl->opt($optionName, $optionValue);
        }

        return $curl;
    }

    protected function setProxy($proxy)
    {
        if ($proxy) {
            return $this->opt(CURLOPT_PROXY, $proxy);
        }
        return $this;
    }

    protected function opt($name, $value)
    {
        if (!curl_setopt($this->handle, $name, $value)) {
            throw new Options('Can\'t set option: "' . $name . '" = "' . $value . '"');
        }
        return $this;
    }

    protected function exec()
    {
        return new Response(curl_exec($this->handle),
                            $this->getContentType(),
                            $this->getStatusCode(),
                            $this->getError());
    }

    protected function getError()
    {
        return curl_error($this->handle);
    }

    protected function getContentType()
    {
        return curl_getinfo($this->handle, CURLINFO_CONTENT_TYPE);
    }

    protected function getStatusCode()
    {
        return curl_getinfo($this->handle, CURLINFO_RESPONSE_CODE);
    }

    public static function get($url, $proxy = false)
    {
        return static::init()
                     ->opt(CURLOPT_URL, $url)
                     ->setProxy($proxy)
                     ->exec();
    }
}