<?php
/**
 */
class StringHelper extends CApplicationComponent
{
    public function substr($string, $start = 0, $length = 0, $append = '...')
    {
        $stringLast = "";
        if ($start < 0 || $length < 0 || strlen($string) <= $length)
        {
            $stringLast = $string;
        }
        else
        {
            $i = 0;
            while ($i < $length)
            {
                $stringTMP = substr($string, $i, 1);
                if ( ord($stringTMP) >=224 )
                {
                    $stringTMP = substr($string, $i, 3);
                    $i = $i + 3;
                }
                elseif( ord($stringTMP) >=192 )
                {
                    $stringTMP = substr($string, $i, 2);
                    $i = $i + 2;
                }
                else
                {
                    $i = $i + 1;
                }
                $stringLast[] = $stringTMP;
            }
            $stringLast = implode("",$stringLast);
            if(!empty($append))
            {
                $stringLast .= $append;
            }
        }
        return $stringLast;
    }
}