<?php
namespace CsrfShield\Tests\Unit;

use CsrfShield\CsrfShield;
use PHPUnit\Framework\TestCase;

class CsrfShieldTest extends TestCase
{
    public function setUp()
    {
        // ...;
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
        $token = CsrfShield::getInstance()->getToken();

        $this->assertNull($token);
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

    public function get_token_by_chaining_methods()
    {
        $token = CsrfShield::getInstance()->init()->getToken();

        $this->assertTrue(is_string($token));
        $this->assertEquals(40, strlen($token));
    }
}
