<?php

namespace App\misc;

class DeckOfCards
{
    public array $cards = [];
    public array $drawn_cards = [];
    /**
     * Create a new class instance.
     */
    public function __construct(public int $amnt_of_std_decks = 1, bool $shuffled = false)
    {
        for ($i = 1; $i <= $amnt_of_std_decks; $i++) {
            foreach (["2", "3", "4", "5", "6", "7", "8", "9", "10", "JACK", "QUEEN", "KING", "ACE"] as $rank) {
                foreach (["S", "C", "D", "H"] as $suit) {
                    array_push($this->cards, new Card($suit, $rank));
                }
            }
        }
        if ($shuffled) {
            shuffle($this->cards);
        }
    }
    // to save deck in db as json
    public function toArray(): array
    {
        return [
            'amnt_of_std_decks' => $this->amnt_of_std_decks,
            'cards' => array_map(fn(Card $c) => $c->toArray(), $this->cards),
            'drawn_cards' => array_map(fn(Card $c) => $c->toArray(), $this->drawn_cards),
        ];
    }
    public static function fromArray(array $data): self {
        $deck = new self();
        $deck->cards = array_map(fn ($c) => Card::fromArray($c), $data['cards']);
        $deck->drawn_cards = array_map(fn ($c) => Card::fromArray($c), $data['drawn_cards']);
        return $deck;
    }



    public function shuffle(bool $include_drawn_cards = false)
    {
        if ($include_drawn_cards) {
            array_push($this->cards, ...$this->drawn_cards);
        };

        shuffle($this->cards);
    }
    public function draw_card($amnt_of_cards = 1)
    {
        $new_drawn_cards = [];

        for ($i = 1; $i <= $amnt_of_cards; $i++){
            array_push($new_drawn_cards, array_pop($this->cards));
        }

        array_push($this->drawn_cards, ...$new_drawn_cards);

        return $new_drawn_cards;
    }
}