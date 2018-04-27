<?php

namespace App\Tests\Model;

use App\Model\Interest;
use App\Model\Investor;
use App\Model\Loan;
use DateTime;
use PHPUnit\Framework\TestCase;

class InterestTest extends TestCase
{
    public function testCalculate()
    {
        $investor1 = new Investor('Investor 1');
        $investor1->credit(100000);

        $investor2 = new Investor('Investor 2');
        $investor2->credit(100000);

        $investor3 = new Investor('Investor 3');
        $investor3->credit(100000);

        $investor4 = new Investor('Investor 4');
        $investor4->credit(100000);

        $loan = new Loan(DateTime::createFromFormat('d/m/Y','01/10/2015'), DateTime::createFromFormat('d/m/Y','15/11/2015'));
        $trancheA = $loan->createTranche(3, 100000);
        $trancheB = $loan->createTranche(6, 100000);

        $investor1->invest($trancheA, 100000, DateTime::createFromFormat('d/m/Y','03/10/2015'));
        $investor2->invest($trancheA, 100, DateTime::createFromFormat('d/m/Y','04/10/2015'));
        $investor3->invest($trancheB, 50000, DateTime::createFromFormat('d/m/Y','10/10/2015'));
        $investor4->invest($trancheB, 110000, DateTime::createFromFormat('d/m/Y','25/10/2015'));

        $interest = new Interest([$loan]);
        $result = $interest->calculate(DateTime::createFromFormat('d/m/Y','01/10/2015'), DateTime::createFromFormat('d/m/Y','31/10/2015'));

        $this->assertArrayHasKey('Investor 1', $result);
        $this->assertArrayHasKey('Investor 3', $result);
        $this->assertEquals(28.06, $result['Investor 1']);
        $this->assertEquals(21.29, $result['Investor 3']);
    }
}
