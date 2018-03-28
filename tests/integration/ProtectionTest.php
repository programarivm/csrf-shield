<?php
namespace CsrfShield\Tests\Integration;

use CsrfShield\Protection;
use PHPUnit\Framework\TestCase;

class ProtectionTest extends TestCase
{
    public function setUp()
    {
        // ...
    }

    public function tearDown()
    {
        // ...
    }

    /**
     * @test
     */
    public function get_request()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';

        session_start();
        $csrfProtection = new Protection;
        // ...
        session_destroy();

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function post_request()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';

        session_start();
        $csrfProtection = new Protection;
        // ...
        session_destroy();

        $this->assertTrue(true);
    }    
}
