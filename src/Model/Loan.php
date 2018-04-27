<?php

namespace App\Model;

class Loan
{
    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $endDate;

    /**
     * @var Tranche[]
     */
    private $trancheList;

    /**
     * Loan constructor.
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     */
    public function __construct(\DateTime $startDate, \DateTime $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @return Tranche[]
     */
    public function getTrancheList(): array
    {
        return $this->trancheList;
    }

    /**
     * @param int $monthlyInterest
     * @param int $maxAmount
     * @return Tranche
     */
    public function createTranche(int $monthlyInterest, int $maxAmount): Tranche
    {
        $tranche = new Tranche($monthlyInterest, $maxAmount);
        $tranche->setLoan($this);

        $this->trancheList[] = $tranche;

        return $tranche;
    }

    /**
     * @param \DateTime $date
     * @return bool
     */
    public function isOpen(\DateTime $date): bool
    {
        if ($this->getStartDate() <= $date && $date <= $this->getEndDate()) {
            return true;
        }

        return false;
    }
}
