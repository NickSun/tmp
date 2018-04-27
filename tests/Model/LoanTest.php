<?php

namespace App\Tests\Model;

use App\Model\Loan;
use DateTime;
use PHPUnit\Framework\TestCase;

class LoanTest extends TestCase
{
    /**
     * @covers Loan::isOpen()
     */
    public function testIsOpen()
    {
        $loan = new Loan(DateTime::createFromFormat('d/m/Y','01/10/2015'), DateTime::createFromFormat('d/m/Y','15/11/2015'));

        $this->assertTrue($loan->isOpen(DateTime::createFromFormat('d/m/Y','12/10/2015')));
        $this->assertFalse($loan->isOpen(DateTime::createFromFormat('d/m/Y','30/09/2015')));
        $this->assertFalse($loan->isOpen(DateTime::createFromFormat('d/m/Y','16/11/2015')));
    }
}
