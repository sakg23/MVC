<?php

namespace App\Card;

class Player {
    private $name;
    private $cards = [];

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    public function addCard(Card $card) {
        $this->cards[] = $card;
    }

    public function getCards(): array {
        return $this->cards;
    }
}
