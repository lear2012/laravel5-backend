<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class Utils {

    public static function getDateFromExcel($excelDate){
        return Carbon::createFromFormat("Y-m-d H:i:s", gmdate("Y-m-d H:i:s", ($excelDate - 25569) * 86400));
    }

    /**
     * 根据数字返回中文简体序号
     * @param $num
     * @return array
     */
    public static function getNumCn($num){
        $arr = ['零', '一', '二', '三', '四', '五', '六', '七', '八', '九', '十'];

        return $num <= 10 ? $arr[$num] : $arr[floor($num / 10) == 1 ? 10 : floor($num / 10)] . $arr[$num % 10];
    }


    public static function fillObjectWidthArray($object, array $data){
        $has = get_object_vars($object);
        foreach ($has as $name => $oldValue) {
            if (array_key_exists($name, $data)) {
                $object->$name = $data[ $name ];
            }
        }
    }

    public static function getArrayFromArray(array $sourceArray, $fields = null){
        if (!$fields) {
            return (new \ArrayObject($sourceArray))->getArrayCopy();
        }else{
            $arr = [];
            foreach ($fields as $field) {
                if (array_key_exists($field, $sourceArray)) {
                    $arr[ $field ] = $sourceArray[ $field ];
                }
            }
            return $arr;
        }
    }

    /**
     * 判断有效期是否合法
     * @param $date 有效截止日期
     * @return bool
     */
    public static function isDateValidate($date){
        $now = Carbon::today();
        $date = Utils::getCarbonFromString($date);
        return $now->lte($date);
    }

    /**
     * 格式化时间
     * @param $string
     * @return static
     */
    public static function getCarbonFromString($string, $forceDate=false){
        $rule = 'Y-m-d H:i:s';
        if ($forceDate && strpos($string, ':')) {
            $string = self::getDateStringFromDateTimeString($string);
        }
        $string = strpos($string, ':') ? $string : ($string.' 00:00:00');
        return Carbon::createFromFormat($rule, $string);
    }

    /**
     * 约束为'Y-M-D'格式
     * @param $string
     * @return string
     */
    public static function getDateStringFromDateTimeString($string){
        return Carbon::createFromFormat('Y-m-d H:i:s',$string)->toDateString();
    }

    /**
     * 加密字符串
     * @param $string 传入字符
     * @param int $starNum 星星替代字符
     * @param int $showNum 首尾显示字符数
     */
    public static function encodeString($string,$showNum=2,$starString='**',$hideLast=false){
        return $hideLast ? iconv_substr($string,0,$showNum).$starString : iconv_substr($string,0,$showNum).$starString.iconv_substr($string,-$showNum,$showNum);
    }

    public static function encodeMobile($mobile){
        return substr_replace($mobile, '****', 3, 4);
    }

    /**
     * 生成当前时间+随机码的数字，用作测试ID
     * @return string
     */
    public static function generateId(){
        return date('zGs').str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
    }


    /**
     * 得到字符串byte长度
     * @param $string
     * @return int
     */
    public static function getByteLenOfString($string){
        return mb_strlen($string,'iso-8859-1');
    }

    /**
     * 根据字符串长度加后缀
     * @param $string
     * @return int
     */
    public static function getShortStringWithLen($string){
        return (mb_strlen($string)>16)?(mb_substr($string,0,16)."..."):$string;
    }

    public static function shortUrl($long_url){
        return App::make('wechat.url')->short($long_url);
    }

    /**
     * 判断有几位小数
     * @param $long_url
     * @return mixed
     */
    public static function numberLen($number){
        $count = 0;
        $temp = explode ( '.', $number);

        if (sizeof ( $temp ) > 1) {
            $decimal = end ( $temp );
            $count = strlen ( $decimal );
        }
        return $count;
    }

    /**
     * 判断整数部分有几位
     * @param $long_url
     * @return mixed
     */
    public static function numberIntLen($number){
        $count = 0;
        $temp = explode ( '.', $number);

        if (sizeof ( $temp ) > 1) {
            $decimal = $temp[0];
            $count = strlen ( $decimal );
        }
        return $count;
    }

    public static function isMobile($string){
        return preg_match("/^1[0-9]{2}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/", $string);
    }

}