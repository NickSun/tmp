<?php

namespace App\Tests\Model;

use App\Model\Wallet;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    /**
     * @return array
     * @covers Wallet::credit()
     */
    public function testCredit()
    {
        $wallet = new Wallet();
        $wallet->credit(10);

        $this->assertEquals(10, $wallet->getAmount());

        return [$wallet];
    }

    /**
     * @param array $stack
     * @return array
     * @depends testCredit
     * @covers Wallet::canWithdraw()
     */
    public function testCanWithdraw(array $stack)
    {
        list($wallet) = $stack;

        $this->assertFalse($wallet->canWithdraw(100));
        $this->assertFalse($wallet->canWithdraw(-5));
        $this->assertTrue($wallet->canWithdraw(5));

        return [$wallet];
    }

    /**
     * @param array $stack
     * @depends testCanWithdraw
     * @covers Wallet::withdraw()
     */
    public function testWithdraw(array $stack)
    {
        list($wallet) = $stack;

        $this->assertEquals(10, $wallet->withdraw(0)->getAmount());
        $this->assertEquals(10, $wallet->withdraw(-5)->getAmount());
        $this->assertEquals(5, $wallet->withdraw(5)->getAmount());
    }
}
