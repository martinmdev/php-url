<?php

namespace Martinm\Test\Url;

use Martinm\Url\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function test__construct()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);

        $this->assertEquals('http://example.com/', $url->toString());
    }

    public function testOverwriteQueryParameters()
    {
        $urlStr = 'http://example.com/?x=1&y=2';

        $url = new Url($urlStr);
        $url->overwriteQueryParameters([
            'foo' => 123,
            'bar' => 'hello',
        ]);

        $this->assertEquals('http://example.com/?x=1&y=2&foo=123&bar=hello', $url->toString());
    }

    public function testSetUrl()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);
        $url->setUrl('ftp://user1:foopass@local.domain/path/to/dir');

        $this->assertEquals('ftp://user1:foopass@local.domain/path/to/dir', $url->toString());
    }

    public function testJsonSerialize()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);

        $this->assertEquals('"http:\/\/example.com\/"', json_encode($url));
    }

    public function testGetPort()
    {
        $urlStr = 'http://example.com:8080/';

        $url = new Url($urlStr);

        $this->assertEquals('8080', $url->getPort());
    }

    public function testSetScheme()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);
        $url->setScheme('https');

        $this->assertEquals('https://example.com/', $url->toString());
    }

    public function testSetQuery()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);
        $url->setQuery('foo=bar&x=2');

        $this->assertEquals('http://example.com/?foo=bar&x=2', $url->toString());
    }

    public function testGetHost()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);

        $this->assertEquals('example.com', $url->getHost());
    }

    public function testGetUser()
    {
        $urlStr = 'http://john:test123@example.com/';

        $url = new Url($urlStr);

        $this->assertEquals('john', $url->getUser());
    }

    public function test__toString()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);

        $this->assertEquals('http://example.com/', $url . '');
    }

    public function testGetScheme()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);

        $this->assertEquals('http', $url->getScheme());
    }

    public function testBuildQuery()
    {
        $this->assertEquals('x=1&foo=bar', Url::buildQuery([
            'x' => 1,
            'foo' => 'bar'
        ]));
    }

    public function testGetFragment()
    {
        $urlStr = 'http://example.com/#example1';

        $url = new Url($urlStr);

        $this->assertEquals('example1', $url->getFragment());
    }

    public function testGetDomainFromUrl()
    {
        $this->assertEquals('google.com', Url::getDomainFromUrl('http://google.com/hello'));
    }

    public function testOverwriteExistingQueryParameters()
    {
        $urlStr = 'http://example.com/?x=1&y=2';

        $url = new Url($urlStr);
        $url->overwriteExistingQueryParameters([
            'y' => 3,
            'foo' => 'bar',
        ]);

        $this->assertEquals('http://example.com/?x=1&y=3', $url->toString());
    }

    public function testToString()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);

        $this->assertEquals('http://example.com/', $url->toString());
    }

    public function testGetProtocolRelativeUrl()
    {
        $this->assertEquals('//example.com/', Url::getProtocolRelativeUrl('http://example.com/'));
    }

    public function testSetUser()
    {
        $urlStr = 'ftp://admin:foobar@example.com/path';

        $url = new Url($urlStr);
        $url->setUser('guest');

        $this->assertEquals('ftp://guest:foobar@example.com/path', $url->toString());
    }

    public function testSetFragment()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);
        $url->setFragment('foobar');

        $this->assertEquals('http://example.com/#foobar', $url->toString());
    }

    public function testIsValidUrl()
    {
        $this->assertTrue(Url::isValidUrl('http://example.com/'));
    }

    public function testGetQueryParameters()
    {
        $urlStr = 'http://example.com/?a=1&b=2';

        $url = new Url($urlStr);

        $this->assertEquals([
            'a' => '1',
            'b' => '2',
        ], $url->getQueryParameters());
    }

    public function testGetPath()
    {
        $urlStr = 'http://example.com/foo/bar/index.php?x=1';

        $url = new Url($urlStr);

        $this->assertEquals('/foo/bar/index.php', $url->getPath());
    }

    public function testAddQueryParameters()
    {
        $urlStr = 'http://example.com/?x=1';

        $url = new Url($urlStr);
        $url->addQueryParameters([
            'y' => 2,
            'z' => 3,
        ]);

        $this->assertEquals('http://example.com/?x=1&y=2&z=3', $url->toString());
    }

    public function testGetPass()
    {
        $urlStr = 'ftp://admin:foobar@example.com/path';

        $url = new Url($urlStr);

        $this->assertEquals('foobar', $url->getPass());
    }

    public function testSetHost()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);
        $url->setHost('test');

        $this->assertEquals('http://test/', $url->toString());
    }

    public function testSetPass()
    {
        $urlStr = 'ftp://admin:foobar@example.com/path';

        $url = new Url($urlStr);
        $url->setPass('abc');

        $this->assertEquals('ftp://admin:abc@example.com/path', $url->toString());
    }

    public function testSetQueryParameters()
    {
        $urlStr = 'http://example.com/?x=1&y=2';

        $url = new Url($urlStr);
        $url->setQueryParameters([
            'a' => 11,
            'b' => 12,
        ]);

        $this->assertEquals('http://example.com/?a=11&b=12', $url->toString());
    }

    public function testGetQuery()
    {
        $urlStr = 'http://example.com/?x=foo&y=bar';

        $url = new Url($urlStr);

        $this->assertEquals('x=foo&y=bar', $url->getQuery());
    }

    public function testSetPort()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);
        $url->setPort(1234);

        $this->assertEquals('http://example.com:1234/', $url->toString());
    }

    public function testSetPath()
    {
        $urlStr = 'http://example.com/foo/test.jpg';

        $url = new Url($urlStr);
        $url->setPath('/my/files/index.html');

        $this->assertEquals('http://example.com/my/files/index.html', $url->toString());
    }

    public function testGetDomainFromUrl2()
    {
        $this->assertEquals('example.com', Url::getDomainFromUrl('example.com/123'));
    }

    public function testAssembleEmptyPath()
    {
        $urlStr = 'http://example.com';

        $url = new Url($urlStr);
        $url->setScheme('https');

        $this->assertEquals('https://example.com/', $url->toString());
    }
}
