<?php
namespace CsrfShield\Tests\Unit;

use CsrfShield\CsrfShield;
use CsrfShield\Exception\SessionException;
use PHPUnit\Framework\TestCase;

class CsrfShieldTest extends TestCase
{
    public function setUp()
    {
        session_start();
        $_SESSION = [];
        session_destroy();
    }

    /**
     * @test
     */
    public function get_instance()
    {
        $csrfShield = CsrfShield::getInstance();

        $this->assertInstanceOf(CsrfShield::class, $csrfShield);
    }

    /**
     * @test
     */
    public function get_empty_token()
    {
        $this->expectException(SessionException::class);

        $token = CsrfShield::getInstance()->getToken();
    }

    /**
     * @test
     */
    public function get_token_by_initializing_first()
    {
        CsrfShield::getInstance()->init();

        $token = CsrfShield::getInstance()->getToken();

        $this->assertTrue(is_string($token));
        $this->assertEquals(40, strlen($token));
    }

    /**
     * @test
     */
    public function get_token_by_chaining_methods()
    {
        $token = CsrfShield::getInstance()->init()->getToken();

        // print_r($_SESSION); exit;

        $this->assertTrue(is_string($token));
        $this->assertEquals(40, strlen($token));
    }
}
