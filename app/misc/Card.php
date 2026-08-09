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
        //
    }
}
