<?php

class CurlGetTest extends PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getDataProvider
     */
    public function testGet($url, $responseCode, $contentType, $wordsInContent)
    {
        $response = \Zver\Curl::get($url);

        $this->assertEquals($response->getResponseCode(), $responseCode);
        $this->assertEquals($response->getContentType(), $contentType);

        $strings = is_array($wordsInContent) ? $wordsInContent : [$wordsInContent];
        $content = $response->getContent();

        foreach ($strings as $string) {
            $isContain = strpos($content, $string) !== false;
            $this->assertTrue($isContain, 'Can\'t find "' . $string . '" in content');
        }
    }

    public function getDataProvider()
    {
        return [
            [
                'url'          => 'http://ya.ru',
                'responseCode' => 200,
                'contentType'  => 'text/html; charset=UTF-8',
                'content'      => ['body', 'html', 'Войти'],
            ],
            [
                'url'          => 'https://ya.ru',
                'responseCode' => 200,
                'contentType'  => 'text/html; charset=UTF-8',
                'content'      => ['body', 'html', 'Войти'],
            ],
        ];
    }
}