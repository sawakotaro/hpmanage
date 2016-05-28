<?php

class DateUtil {
    
    /**
     * $defaultYearから$span分の前後配列を返却します。
     * @param int $defaultYear
     * @param int $span
     * @return Array
     */
    public static function generateYearArray($defaultYear, $span, $nullable = false) {
        $min = $defaultYear - $span;
        $max = $defaultYear + $span;
        
        $array = array();
        if($nullable) {
            $array[''] = '';
        }
        while($min <= $max) {
            $array[$min] = $min;
            $min++;
        }
        
        return $array;
    }
    
    /**
     * $defaultYearから$span分の前後配列を返却します。
     * @param int $defaultYear
     * @param int $span
     * @return Array
     */
    public static function generateBirthYearArray($defaultYear, $span, $nullable = false) {
        $min = $defaultYear - $span;
        $max = $defaultYear;
        
        $array = array();
        if($nullable) {
            $array[''] = '';
        }
        while($min <= $max) {
            $array[$max] = $max;
            $max--;
        }
        
        return $array;
    }
    /**
     * 月の配列リストを返却します。
     * $zero_valueがtrueの時は0埋め
     * @param boolean $zero_value
     * @return Array
     */
    public static function generateMonthArray($zero_value = false, $nullable = false) {
        $array = array();
        if($nullable) {
            $array[''] = '';
        }
        for($i = 1; $i <= 12; $i++) {
            $array[$i] = (($zero_value) ? sprintf("%02d", $i) : $i);
        }
        return $array;
    }
    
    /**
     * 日の配列リストを返却します。
     * $zero_valueがtrueの時は0埋め
     * @param boolean $zero_value
     * @return Array
     */ 
    public static function generateDayArray($zero_value = false, $nullable = false) {
        $array = array();
        if($nullable) {
            $array[''] = '';
        }
        for($i = 1; $i <= 31; $i++) {
            $array[$i] = (($zero_value) ? sprintf("%02d", $i) : $i);
        }
        return $array;
    }
    
    
    /**
     * 時間の配列リストを返却します。
     * $zero_valueがtrueの時は0埋め
     * @param boolean $zero_value
     * @return Array
     */ 
    public static function generateHourArray($zero_value = false, $nullable = false) {
        $array = array();
        if($nullable) {
            $array[''] = '';
        }
        for($i = 0; $i < 24; $i++) {
            $array[$i] = (($zero_value) ? sprintf("%02d", $i) : $i);
        }
        return $array;
    }
    
    
    /**
     * 分の配列リストを返却します。
     * $zero_valueがtrueの時は0埋め
     * @param boolean $zero_value
     * @return Array
     */ 
    public static function generateMinuteArray($zero_value = false, $nullable = false) {
        $array = array();
        if($nullable) {
            $array[''] = '';
        }
        for($i = 0; $i < 60; $i++) {
            $array[$i] = (($zero_value) ? sprintf("%02d", $i) : $i);
        }
        return $array;
    }
    
    
    
    
    
    
    /**
     * 日時配列リストを取得します。
     * @return Array
     */
    public static function generateDateList() {
        return array(
            "year"      =>  DateUtil::generateYearArray(date('Y'), 2),
            "month"     =>  DateUtil::generateMonthArray(),
            "day"       =>  DateUtil::generateDayArray(),
            "hour"      =>  DateUtil::generateHourArray(),
            "minute"    =>  DateUtil::generateMinuteArray(),
        );
    }
}
