<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12/12/18
 * Time: 4:12 PM
 */

namespace App\Tests\Security;

use App\Security\TokenGenerator;
use PHPUnit\Framework\TestCase;

class TokenGeneratorTest extends TestCase
{
    public function testTokenGeneration()
    {
        $tokenGen = new TokenGenerator();
        $token = $tokenGen->getRandomSecureToken(30);
        $this->assertEquals(30, strlen($token));
        $this->assertTrue(ctype_alnum($token));
    }
}