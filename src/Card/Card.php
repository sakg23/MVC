<?php

namespace App\Card;

class Card {
    private $suit;
    private $value;

    public function __construct(string $suit, string $value) {
        $this->suit = $suit;
        $this->value = $value;
    }

    public function getSuit(): string {
        return $this->suit;
    }

    public function getValue(): string {
        return $this->value;
    }
}
