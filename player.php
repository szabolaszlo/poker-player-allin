<?php

class Player
{
    const VERSION = "Default PHP folding player";

    public function betRequest($game_state)
    {
        return $game_state['pot'];
    }

    public function showdown($game_state)
    {
    }
}
