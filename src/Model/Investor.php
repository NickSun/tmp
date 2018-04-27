<?php

namespace App\Model;

class Investor
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Wallet
     */
    private $wallet;

    /**
     * Investor constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->wallet = new Wallet();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Wallet
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @param int $amount
     * @return Investor
     */
    public function credit(int $amount): Investor
    {
        $this->wallet->credit($amount);

        return $this;
    }

    /**
     * @param int $amount
     * @return bool
     */
    private function canWithdraw(int $amount): bool
    {
        return $this->wallet->canWithdraw($amount);
    }

    /**
     * @param int $amount
     * @return Investor
     */
    private function withdraw(int $amount): Investor
    {
        $this->wallet->withdraw($amount);

        return $this;
    }

    /**
     * @param Tranche   $tranche
     * @param int       $amount
     * @param \DateTime $date
     * @return bool
     */
    public function invest(Tranche $tranche, int $amount, \DateTime $date): bool
    {
        $investment = new Investment($this, $amount, $date);

        if ($this->canWithdraw($amount) && $tranche->validateInvestment($investment)) {
            $tranche->makeInvestment($investment);
            $this->withdraw($amount);

            return true;
        }

        return false;
    }
}
