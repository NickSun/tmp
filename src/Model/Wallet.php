<?php

namespace App\Model;

class Wallet
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return Wallet
     */
    public function credit(int $amount): Wallet
    {
        $this->amount += $amount;

        return $this;
    }

    /**
     * @param int $amount
     * @return Wallet
     */
    public function withdraw(int $amount): Wallet
    {
        if ($this->canWithdraw($amount)) {
            $this->amount -= $amount;
        }

        return $this;
    }

    /**
     * @param int $amount
     * @return bool
     */
    public function canWithdraw(int $amount): bool
    {
        if ($amount <= 0 || $this->amount < $amount) {
            return false;
        }

        return true;
    }
}
