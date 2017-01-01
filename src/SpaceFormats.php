<?php
/**
 * @file SpaceFormats.php
 * @namespace Spaceboy
 * @class SpaceFormats
 * @author: Spaceboy
 */

namespace Spaceboy;

use Nette;
use Nette\Utils\DateTime;

class SpaceFormats extends \Nette\Object {

    /**
     * Formátování datetime na relativní čas (k aktuálnímu času)
     * @param Nette\Utils\Datetime $time Vstupní datetime
     * @return string "relativní" čas (typu "před minutou", "před týdnem" ...)
     */
    public static function getRelativeTime ($time) {
        $dateTime = new DateTime();
        $dateDiff = $dateTime->diff($time, time());
        if ($dateDiff->y) {
            if (1 == $dateDiff->y) {
                return 'Před rokem';
            }
            return "Před {$dateDiff->y} lety";
        }
        if ($dateDiff->m) {
            if (1 == $dateDiff->m) {
                return 'Před měsícem';
            }
            return "Před {$dateDiff->m} měsíci";
        }
        if ($w = floor($dateDiff->days / 7)) {
            if (1 == $w) {
                return 'Před týdnem';
            }
            return "Před {$w} týdny";
        }
        if ($dateDiff->d) {
            if (1 == $dateDiff->d) {
                return 'Včera';
            }
            return "Před {$dateDiff->d} dny";
        }
        switch ($dateDiff->h) {
            case 0:
                return 'Právě teď!';
                break;
            case 1:
                return 'Před hodinou';
                break;
            case 2:
            case 3:
                return "Před {$dateDiff->h} hodinami";
                break;
            default:
                return 'Dnes';
                break;
        }
        return "někdy";
    }

    /**
     * Formátování vzdálenosti na "čitelný" formát
     * @param integer $distance Vzdálenost v metrech
     * @return string "relativní" čas (typu "před minutou", "před týdnem" ...)
     */
    public static function getReadableDistance ($distance) {
        if ($distance < 10) {
            return "v okolí";
        }
        if ($distance < 100) {
            $distance = round($distance, -1);
            return "{$distance} metrů";
        }
        if ($distance < 1000) {
            $distance = round($distance, -2);
            return "{$distance} metrů";
        }
        if ($distance < 5000) {
            $distance = number_format(round($distance / 1000, 1), 0, ',', ' ');
            return "{$distance} km";
        }
        $distance = number_format(round($distance / 1000), 0, ',', ' ');
        return "{$distance} km";
    }

    /**
     * Formátování čísel do tvaru římských čísel
     * @param integer Vstupní hodnota
     * @return string
     */
    public static function getRomanic ($num) {
        $table = array(
            'M'     => 1000,
            'IM'    => 999,
            'VM'    => 995,
            'XM'    => 990,
            'LM'    => 950,
            'CM'    => 900,
            'D'     => 500,
            'ID'    => 499,
            'VD'    => 495,
            'XD'    => 490,
            'LD'    => 450,
            'CD'    => 400,
            'C'     => 100,
            'IC'    => 99,
            'VC'    => 95,
            'XC'    => 90,
            'L'     => 50,
            'IL'    => 49,
            'VL'    => 45,
            'XL'    => 40,
            'X'     => 10,
            'IX'    => 9,
            'V'     => 5,
            'IV'    => 4,
            'I'     => 1,
        );
        $return = '';
        while ($num > 0) {
            foreach ($table as $rom=>$arb) {
                if ($num >= $arb) {
                    $num -= $arb;
                    $return .= $rom;
                    break;
                }
            }
        }
        return $return;
    }

}
