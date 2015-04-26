<?php

namespace Kivi;

class CountBasedMerger
{
    public static function merge($array1, $array2)
    {


        if(count($array1) == 0) {
            return $array2;
        }


        if(count($array2) == 0) {
            return $array1;
        }

        if(count($array2) > count($array1)) {
            $tmpArray = $array1;
            $array1 = $array2;
            $array2 = $tmpArray;
        }

        $countArray1 = count($array1);
        $countArray2 = count($array2);

        $mergedArray = [];

        $ratio = intval($countArray1/$countArray2 + 0.5);
        for($i = 1; $i <= $countArray1; $i++) {
            $mergedArray[] = array_shift($array1);
            if($i % $ratio == 0 && count($array2) != 0) {
                $mergedArray[] = array_shift($array2);
            }
        }
        return array_merge($mergedArray, $array1, $array2);
    }
}
