<?php

namespace App\Tests\Model;

use App\Model\Investment;
use App\Model\Investor;
use App\Model\Loan;
use DateTime;
use PHPUnit\Framework\TestCase;

class TrancheTest extends TestCase
{
    /**
     * @return array
     * @covers Tranche::validateInvestment()
     */
    public function testValidateInvestment()
    {
        $investor = new Investor('Investor');
        $loan = new Loan(DateTime::createFromFormat('d/m/Y','01/10/2015'), DateTime::createFromFormat('d/m/Y','15/11/2015'));
        $tranche = $loan->createTranche(3, 100000);
        $investment = new Investment($investor, 1000, DateTime::createFromFormat('d/m/Y','03/10/2015'));

        $this->assertTrue($tranche->validateInvestment($investment));

        // after loan is closed
        $investment = new Investment($investor, 1000, DateTime::createFromFormat('d/m/Y','16/11/2015'));
        $this->assertFalse($tranche->validateInvestment($investment));

        // before loan is opened
        $investment = new Investment($investor, 1000, DateTime::createFromFormat('d/m/Y','30/09/2015'));
        $this->assertFalse($tranche->validateInvestment($investment));

        // negative amount
        $investment = new Investment($investor, -1000, DateTime::createFromFormat('d/m/Y','03/10/2015'));
        $this->assertFalse($tranche->validateInvestment($investment));

        return [$investor, $tranche];
    }

    /**
     * @param array $stack
     * @depends testValidateInvestment
     */
    public function testMakeInvestment(array $stack)
    {
        list($investor, $tranche) = $stack;

        // trying to invest more then tranche can accept
        $investment = new Investment($investor, 100100, DateTime::createFromFormat('d/m/Y','03/10/2015'));
        $this->assertEquals(0, $tranche->makeInvestment($investment)->getCurrentAmount());

        // correct value
        $investment = new Investment($investor, 10000, DateTime::createFromFormat('d/m/Y','03/10/2015'));
        $this->assertEquals(10000, $tranche->makeInvestment($investment)->getCurrentAmount());
        $this->assertCount(1, $tranche->getInvestmentList());

        // invalid amount
        $investment = new Investment($investor, 100000, DateTime::createFromFormat('d/m/Y','03/10/2015'));
        $this->assertEquals(10000, $tranche->makeInvestment($investment)->getCurrentAmount());
        $this->assertCount(1, $tranche->getInvestmentList());

        // invalid date
        $investment = new Investment($investor, 90000, DateTime::createFromFormat('d/m/Y','30/09/2015'));
        $this->assertEquals(10000, $tranche->makeInvestment($investment)->getCurrentAmount());
        $this->assertCount(1, $tranche->getInvestmentList());

        // max amount reached
        $investment = new Investment($investor, 90000, DateTime::createFromFormat('d/m/Y','05/10/2015'));
        $this->assertEquals(100000, $tranche->makeInvestment($investment)->getCurrentAmount());
        $this->assertCount(2, $tranche->getInvestmentList());

        // max amount still the same
        $investment = new Investment($investor, 90000, DateTime::createFromFormat('d/m/Y','05/10/2015'));
        $this->assertEquals(100000, $tranche->makeInvestment($investment)->getCurrentAmount());
        $this->assertCount(2, $tranche->getInvestmentList());
    }
}
