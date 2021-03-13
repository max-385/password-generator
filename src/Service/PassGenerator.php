<?php

namespace App\Service;


class PassGenerator
{

    private int $numberOfSymbols;
    private bool $allowNumbers;
    private bool $allowUppercase;
    private bool $allowLowercase;

    private array $allowableNumbers = [2, 3, 4, 5, 6, 7, 8, 9];
    private array $allowableUppercase = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    private array $allowableLowercase = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];


    public function __construct(int $numberOfSymbols, bool $allowNumbers, bool $allowUppercase, bool $allowLowercase)
    {
        $this->numberOfSymbols = $numberOfSymbols;
        $this->allowNumbers = $allowNumbers;
        $this->allowUppercase = $allowUppercase;
        $this->allowLowercase = $allowLowercase;
    }


    public function generatePassword()
    {
        $allowableSymbols = $this->getAllowableSymbols();
        $password = [];

        foreach ($allowableSymbols as $type => $symbol) {
            $password[] = array_pop($allowableSymbols[$type]); // at least 1 symbol from each selected subset in password
        }

        $allowableSymbolsShuffle = array_merge(...$allowableSymbols);// merge all selected subsets

        if (count($allowableSymbolsShuffle) < $this->numberOfSymbols - count($password) // non-repeating symbols not enough
            || count($allowableSymbols) > $this->numberOfSymbols) { // number of subsets > number of symbols
            return false;
        }


        $needSymbols = $this->numberOfSymbols - count($password); //check password length
        if ($needSymbols > 0) {
            $extraSymbols = array_rand(array_flip($allowableSymbolsShuffle), $needSymbols);
            is_array($extraSymbols) ? array_push($password, ...$extraSymbols) : array_push($password, $extraSymbols);
        } //

        shuffle($password);
        $password = implode("", $password);
        return $password;
    }


    private function getAllowableSymbols(): array
    {
        $allowableSymbols = [];

        if ($this->allowNumbers) {
            shuffle($this->allowableNumbers);
            $allowableSymbols[] = $this->allowableNumbers;
        }
        if ($this->allowUppercase) {
            shuffle($this->allowableUppercase);
            $allowableSymbols[] = $this->allowableUppercase;
        }
        if ($this->allowLowercase) {
            shuffle($this->allowableLowercase);
            $allowableSymbols[] = $this->allowableLowercase;
        }

        return $allowableSymbols;
    }

    public function getNumberOfSymbols(): ?int
    {
        return $this->numberOfSymbols;
    }

    public function setNumberOfSymbols(int $numberOfSymbols): self
    {
        $this->numberOfSymbols = $numberOfSymbols;

        return $this;
    }

    public function isAllowNumbers(): bool
    {
        return $this->allowNumbers;
    }

    public function isAllowUppercase(): bool
    {
        return $this->allowUppercase;
    }

    public function isAllowLowercase(): bool
    {
        return $this->allowLowercase;
    }


}
