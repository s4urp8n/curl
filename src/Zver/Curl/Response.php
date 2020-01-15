<?php

namespace Zver\Curl;

class Response
{
    protected $content = null;
    protected $contentType = null;
    protected $responseCode = null;
    protected $error = null;

    public function __construct($content, $contentType, $responseCode, $error)
    {
        $this->content = $content;
        $this->contentType = $contentType;
        $this->responseCode = $responseCode;
        $this->error = $error;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function getResponseCode()
    {
        return $this->responseCode;
    }

    public function getError()
    {
        return $this->error;
    }
}