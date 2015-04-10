<?php
class Number
{
    /**
     * Use this function for output prices
     * @param int $base value in cents
     * @param int $centsInOne quantity of cents in one currency unit
     * @return string
     */
    public static function FormatPrice($base,$centsInOne = 100)
    {
        return number_format($base / $centsInOne,2,'.','');
    }

    /**
     * Converts entered by hand price to base format (cents)
     * @param $formattedPrice
     * @param int $centsInOne
     * @return float|int
     */
    public function priceToBase($formattedPrice,$centsInOne = 100)
    {
        if(is_numeric($formattedPrice))
        {
            $clean = floatval(str_replace(',','.',$formattedPrice));
            return $clean * $centsInOne;
        }

        return 0;
    }
}