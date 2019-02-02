<?php

class Player
{
    const VERSION = "TEAM ALL IN";

    public function betRequest($game_state)
    {
        return $game_state['pot'];
    }

    public function showdown($game_state)
    {
    }

    public function getMe($game_state)
    {
        foreach ($game_state["players"] as $player) {
            if ($player["version"] === self::VERSION) {
                return $player;
            }
        }
    }
}
