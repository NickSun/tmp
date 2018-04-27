<?php

namespace App\Model;

class Interest
{
    /**
     * @var Loan[]
     */
    private $loanList;

    /**
     * Interest constructor.
     * @param array $loanList
     */
    public function __construct(array $loanList)
    {
        $this->loanList = $loanList;
    }

    public function calculate(\DateTime $startDate, \DateTime $endDate)
    {
        $result = [];

        foreach ($this->loanList as $loan) {
            foreach ($loan->getTrancheList() as $tranche) {
                foreach ($tranche->getInvestmentList() as $investment) {
                    if ($startDate <= $investment->getDate() && $investment->getDate() <= $endDate) {
                        $fullDaysCount = (int) $investment->getDate()->diff($endDate)->format("%a") + 1;
                        $period = (int) $startDate->diff($endDate)->format("%a") + 1;

                        $result[$investment->getInvestor()->getName()] = round($investment->getAmount() * $tranche->getMonthlyInterest() * $fullDaysCount / $period / 10000, 2);
                    }
                }
            }
        }

        return $result;
    }
}
