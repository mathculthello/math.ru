<?php
    function toNumeral($num) {
        $conv = array(10 => array('X', 'C', 'M'),
                      5  => array('V', 'L', 'D'),
                      1  => array('I', 'X', 'C'));
        $roman = '';

        if ($num < 0) {
            return '';
        }

        $num = (int) $num;

        $digit  = (int) ($num / 1000);
        $num   -= $digit * 1000;
        while ($digit > 0) {
            $roman .= 'M';
            $digit--;
        }

        for ($i = 2; $i >= 0; $i--) {
            $power = pow(10, $i);
            $digit = (int) ($num / $power);
            $num -= $digit * $power;

            if (($digit == 9) || ($digit == 4)) {
                $roman .= $conv[1][$i] . $conv[$digit+1][$i];
            } else {
                if ($digit >= 5) {
                    $roman .= $conv[5][$i];
                    $digit -= 5;
                }

                while ($digit > 0) {
                    $roman .= $conv[1][$i];
                    $digit--;
                }
            }
        }

        return $roman;
    }
	
	
    function toNumber($roman)
    {
        $conv = array(
            array("letter" => 'I', "number" => 1),
            array("letter" => 'V', "number" => 5),
            array("letter" => 'X', "number" => 10),
            array("letter" => 'L', "number" => 50),
            array("letter" => 'C', "number" => 100),
            array("letter" => 'D', "number" => 500),
            array("letter" => 'M', "number" => 1000),
            array("letter" => 0,   "number" => 0)
        );
        $arabic = 0;
        $state  = 0;
        $sidx   = 0;
        $len    = strlen($roman) - 1;

        while ($len >= 0) {
            $i = 0;
            $sidx = $len;

            while ($conv[$i]['number'] > 0) {
                if (strtoupper($roman[$sidx]) == $conv[$i]['letter']) {
                    if ($state > $conv[$i]['number']) {
                        $arabic -= $conv[$i]['number'];
                    } else {
                        $arabic += $conv[$i]['number'];
                        $state   = $conv[$i]['number'];
                    }
                }
                $i++;
            }

            $len--;
        }

        return($arabic);
    }	
?>
