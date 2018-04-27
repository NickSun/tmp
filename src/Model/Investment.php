<?php

namespace App\Model;

class Investment
{
    /**
     * @var Investor
     */
    private $investor;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * Investment constructor.
     * @param Investor $investor
     * @param int $amount
     * @param \DateTime $date
     */
    public function __construct(Investor $investor, int $amount, \DateTime $date)
    {
        $this->investor = $investor;
        $this->amount = $amount;
        $this->date = $date;
    }

    /**
     * @return Investor
     */
    public function getInvestor(): Investor
    {
        return $this->investor;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }
}
