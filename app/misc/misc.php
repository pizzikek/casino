<?php

namespace App\misc;

class misc
{
    public function safe_items($array): array
    {
        $whitelist = [
            'id',
            'points_curr_table',
            'action_table',
            'curr_bet',
            'username',
        ];

        return array_intersect_key($array, array_flip($whitelist));
    }
}
