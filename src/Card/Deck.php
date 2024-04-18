<?php
namespace App\Card;

class Deck {
    private $cards = [];

    public function __construct() {
        $suits = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
        $values = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $this->cards[] = new Card($suit, $value);
            }
        }
    }

    public function shuffle() {
        shuffle($this->cards);
    }

    public function draw(): ?Card {
        return array_shift($this->cards);
    }

    public function getCards(): array {
        return $this->cards;
    }
}
