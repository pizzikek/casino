<?php

namespace App\misc;

class Card
{
    protected string|int $value;
    protected string $code;

    /**
     * Create a new class instance.
     */
    public function __construct(public string $suit, public string $rank)
    {
        // setting $value
        $intofrank = intval($rank);
        $this->value = $intofrank !== 0 ? $intofrank : $rank;

        // setting $code
        $this->code = $rank . "-" . $suit;
    }
    // for saving as json in db
    public function toArray(): array
    {
        return ['suit' => $this->suit, 'rank' => $this->rank];
    }

    public static function fromArray(array $data): self
    {
        return new self($data['suit'], $data['rank']);
    }
}
