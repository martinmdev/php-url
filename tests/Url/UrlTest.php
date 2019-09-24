<?php

namespace Martinm\Test\Url;

use Martinm\Url\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function test1()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);

        $this->assertEquals($urlStr, $url->toString());
    }

    public function test2()
    {
        $urlStr = 'http://example.com/';

        $url = new Url($urlStr);
        $url->setHost('test.com');

        $this->assertEquals('http://test.com/', $url->toString());
    }

    public function test3()
    {
        $urlStr = 'http://user:passwd@example.com/foo/bar/index.php?x=1&y=hello#iAmTheFragment';

        $url = new Url($urlStr);
        $url->setHost('test.com');

        $this->assertEquals('http://user:passwd@test.com/foo/bar/index.php?x=1&y=hello#iAmTheFragment', $url->toString());
    }

    public function testSetPass()
    {
        $urlStr = 'http://user:passwd@example.com/foo/bar/index.php?x=1&y=hello#iAmTheFragment';

        $url = new Url($urlStr);
        $url->setPass('passfoo');

        $this->assertEquals('http://user:passfoo@example.com/foo/bar/index.php?x=1&y=hello#iAmTheFragment', $url->toString());
    }
}
