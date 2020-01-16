<?php

class CurlJsonTest extends PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getDataProvider
     */
    public function testJSON($url, $data, $responseCode, $contentType, $content)
    {
        $response = \Zver\Curl::json($url, $data);

        $this->assertEquals($response->getResponseCode(), $responseCode);
        $this->assertEquals($response->getContentType(), $contentType);
        $responseContent = $response->getContent();
        $this->assertEquals($responseContent, $content);

    }

    public function getDataProvider()
    {
        return [
            [
                'url'          => 'https://jsonplaceholder.typicode.com/posts',
                'data'         => [
                    'title'  => 'foo',
                    'body'   => 'bar',
                    'userId' => 1,
                ],
                'responseCode' => 201,
                'contentType'  => 'application/json; charset=utf-8',
                'content'      => [
                    "title"  => "foo",
                    "body"   => "bar",
                    "userId" => 1,
                    "id"     => 101,
                ],
            ],
        ];
    }
}