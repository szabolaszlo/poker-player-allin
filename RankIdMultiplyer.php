<?php
/**
 * Created by PhpStorm.
 * User: gabornagy
 * Date: 2019. 02. 02.
 * Time: 11:28
 */

class RankIdMultiplyer
{
    public function getMultiply($rank,$stack)
    {


        switch ($rank['rank']) {
            case '1':
            case '2':
                if ($rank['strength'] >= 1){
                    return (int)$stack * 0.4;
                }
                return 0;
            case '3':
            case '4':
            case '5':
                return (int)$stack;
            //case 'raise':
            case '6':
            case '7':
            case '8':
                return (int)$stack;
            default:
                return 0;
        }
    }
}