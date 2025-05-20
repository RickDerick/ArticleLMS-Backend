<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Nette\Utils\Random;

if (!function_exists('generate_user_otp')) {
    function generate_user_otp(): int
    {
        $unique = mt_rand(100000, 999999);

        if (User::whereOtp($unique)->count() > 0)
            return generate_user_otp();

        return $unique;
    }
}

if (!function_exists('format_phone_no')) {
    function format_phone_no(string $phone): string
    {
        if ($phone[0] === '0' && $phone[1] === '7') {
            return "+254" . ltrim(str_replace(' ', '', $phone), 0);
        } elseif ($phone[0] === '7') {
            return "+254" . $phone;
        } else {
            return $phone;
        }
    }
}

if (!function_exists('generate_rand_password')) {
    function generate_rand_password(): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}

if (! function_exists('generate_slug_code')) {
    function generate_slug_code($string) : string
    {
        return mb_strtoupper(str_replace(' ', '_', $string));
    }
}

if (! function_exists('generate_file_name')) {
    function generate_file_name(\Illuminate\Database\Eloquent\Model $model) : string
    {
        return uniqid(strtolower($model->model .'_'. $model->id . '_' ));
    }
}

if (! function_exists('get_http_status')) {
    function get_http_status($code) : string
    {
        return [
            200 => 'OK',
            201 => 'CREATED',
            202 =>  'ACCEPTED',
            204 => 'NO_CONTENT',
            206 => 'PARTIAL_CONTENT',

            301 => 'MOVED',
            303 => 'OTHER',
            304 => 'UNMODIFIED',
            307 => 'REDIRECT',

            400 => 'BAD',
            402 => 'PAYMENT REQUIRED',
            401 => 'UNAUTHORIZED',
            403 => 'FORBIDDEN',
            404 => 'NOTFOUND',
            405 => 'METHOD NOT ALLOWED',
            410 => 'GONE',
            413 => 'PAYLOAD TOO LARGE',
            415 => 'UNSUPPORTED MEDIA TYPE',
            422 => 'UNPROCESSABLE ENTITY',
            426 => 'UPGRADE REQUIRED',
            432 => 'REQUEST HEADER TOO LARGE',
            451 => 'UNAVAILABLE FOR LEGAL REASONS',

            500 => 'ERROR',
            501 => 'NOT IMPLEMENTED',
            502 => 'BAD GATEWAY',
            503 => 'UNAVAILABLE',
            504 => 'TIMEOUT',
        ][$code];
    }
}

if (!function_exists('get_guid'))
{
    function get_guid( $trim = true ): string
    {
        if (function_exists('com_create_guid')){
            $guid = com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $guid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
        }

        return $trim ? trim($guid, '{}') : $guid ;
    }
}

if (!function_exists('toBoolean')) {
    function toBoolean($booleable)
    {
        return filter_var($booleable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}

if (!function_exists('uniqueCode')) {
    function uniqueCode(Model $model, string $field, int $length = 5, string $prefix = '', bool $alphanumeric = true): string
    {
        $code = $prefix.Random::generate($length,$alphanumeric ? '0-9a-z': '0-9');
        if ($model->query()->where($field, $code)->withTrashed()->exists())
            return uniqueCode($model, $field, $length, $prefix, $alphanumeric);

        return mb_strtoupper($code);
    }
}

