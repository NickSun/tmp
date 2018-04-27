<?php

namespace App\Model;

class Tranche
{
    /**
     * @var int
     */
    private $monthlyInterest;

    /**
     * @var int
     */
    private $maxAmount;

    /**
     * @var int
     */
    private $currentAmount;

    /**
     * @var Loan
     */
    private $loan;

    /**
     * @var Investment[]
     */
    private $investmentList;

    /**
     * Tranche constructor.
     * @param int $monthlyInterest
     * @param int $maxAmount
     */
    public function __construct(int $monthlyInterest, int $maxAmount)
    {
        $this->monthlyInterest = $monthlyInterest;
        $this->maxAmount = $maxAmount;
        $this->currentAmount = 0;
    }

    /**
     * @return int
     */
    public function getMonthlyInterest(): int
    {
        return $this->monthlyInterest;
    }

    /**
     * @return int
     */
    public function getMaxAmount(): int
    {
        return $this->maxAmount;
    }

    /**
     * @param Loan $loan
     */
    public function setLoan(Loan $loan)
    {
        $this->loan = $loan;
    }

    /**
     * @return Loan
     */
    public function getLoan(): Loan
    {
        return $this->loan;
    }

    /**
     * @return Investment[]
     */
    public function getInvestmentList(): array
    {
        return $this->investmentList;
    }

    /**
     * @param Investment $investment
     * @return bool
     */
    public function validateInvestment(Investment $investment): bool
    {
        if ($this->getLoan()->isOpen($investment->getDate())
            && $investment->getAmount() > 0
            && $this->currentAmount + $investment->getAmount() <= $this->maxAmount
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param Investment $investment
     * @return Tranche
     */
    public function makeInvestment(Investment $investment): Tranche
    {
        if ($this->validateInvestment($investment)) {
            $this->setCurrentAmount($this->getCurrentAmount() + $investment->getAmount());
            $this->investmentList[] = $investment;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentAmount(): int
    {
        return $this->currentAmount;
    }

    /**
     * @param int $currentAmount
     * @return Tranche
     */
    private function setCurrentAmount(int $currentAmount): Tranche
    {
        $this->currentAmount = $currentAmount;

        return $this;
    }
}
