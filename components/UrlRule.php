<?php
namespace app\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\base\Object;
use app\components\AesCtr;

class UrlRule extends Object implements UrlRuleInterface
{
    var $skey = "KEYUNICA123456"; // you can change it

    public function createUrl($manager, $route, $params)
    {
        $args='?';
        $idx = 0;
        foreach($params as $num=>$val){
            if(in_array($num,['id'])){
                $val = $this->encode($val);
            }
            $args .= $num . '=' . $val;
            $idx++;
            if($idx!=count($params)) $args .= '&';
        }
        $suffix = Yii::$app->urlManager->suffix;
        if ($args=='?') $args = '';
        return $route .$suffix. $args;
        return false;  // this rule does not apply
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        $url = $request->getUrl();
        $queryString = parse_url($url);
        if(isset($queryString['query'])){
            $queryString = $queryString['query'];
            $args = [];
            parse_str($queryString, $args);
            $params = [];
            foreach($args as $num=>$val){
                if(in_array($num,['id'])){
                    $val =  $this->decode($val);
                }
                $params[$num]=$val;
            }
            $suffix = Yii::$app->urlManager->suffix;
            $route = str_replace($suffix,'',$pathInfo);
            return [$route,$params];
        }
        return false;  // this rule does not apply
    }

    public function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(['+', '/', '='], ['-', '_', ''], $data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(['-', '_'], ['+', '/'], $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public function encode($value) {
        //return $this->mencrypt($value);
        return AesCtr::encrypt($value, '123456', 256);
    }

    public function decode($value) {
        //return $this->mdecrypt($value);
        return AesCtr::decrypt($value, '123456', 256);
    }

    function mencrypt($input) {
        $key = substr(md5($this->skey), 0, 24);
        $td = mcrypt_module_open('tripledes', '', 'ecb', '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $encrypted_data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return trim(chop($this->url_base64_encode($encrypted_data)));
    }

    function mdecrypt($input) {
        $input = trim(chop($this->url_base64_decode($input)));
        $td = mcrypt_module_open('tripledes', '', 'ecb', '');
        $key = substr(md5($this->skey), 0, 24);
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $decrypted_data = mdecrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return trim(chop($decrypted_data));
    }

    function url_base64_encode($str)
    {
        return strtr(base64_encode($str), [
            '+' => '.',
            '=' => '-',
            '/' => '~'
          ]);
    }

    function url_base64_decode($str) {
        return base64_decode(strtr($str, [
            '.' => '+',
            '-' => '=',
            '~' => '/'
        ]));
    }
}
