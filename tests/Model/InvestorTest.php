<?php

namespace App\Tests\Model;

use App\Model\Investor;
use App\Model\Loan;
use DateTime;
use PHPUnit\Framework\TestCase;

class InvestorTest extends TestCase
{
    /**
     * @covers Investor::invest()
     */
    public function testInvest()
    {
        $investor = new Investor('Investor');

        $loan = new Loan(DateTime::createFromFormat('d/m/Y','01/10/2015'), DateTime::createFromFormat('d/m/Y','15/11/2015'));
        $tranche = $loan->createTranche(3, 100000);

        // trying to invest with empty wallet
        $this->assertFalse($investor->invest($tranche, 1000, DateTime::createFromFormat('d/m/Y','03/10/2015')));

        $investor->credit(100000);

        // trying to invest more than we can
        $this->assertFalse($investor->invest($tranche, 1000000, DateTime::createFromFormat('d/m/Y','03/10/2015')));

        // trying to invest correct amount
        $this->assertTrue($investor->invest($tranche, 100000, DateTime::createFromFormat('d/m/Y','03/10/2015')));

        // trying to invest correct amount again (for now wallet should be empty)
        $this->assertFalse($investor->invest($tranche, 100000, DateTime::createFromFormat('d/m/Y','03/10/2015')));
    }
}