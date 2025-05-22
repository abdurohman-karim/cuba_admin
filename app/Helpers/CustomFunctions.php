<?php

if (!function_exists('abort_if_forbidden'))
{
    function abort_if_forbidden(string $permission)
    {
        if (env('WRITE_PERMISSION'))
        {
            \Spatie\Permission\Models\Permission::updateOrCreate(
                ['name' => $permission],
                ['title' => $permission],
            );
        }
        abort_if(!auth()->user()->can($permission),403,'Требуется разрешение!');
    }
}



if (!function_exists('get_auto_count'))
{
    function get_auto_count($key,$before)
    {
        $key = $key."_".date('H:i',strtotime("- $before minutes"));
        return \Illuminate\Support\Facades\Cache::get($key) ?? 0;
    }
}

if (!function_exists('auto_incerement'))
{
    function auto_incerement($int,$processing)
    {
        $key = $processing."_".date('H:i');
        if (!\Illuminate\Support\Facades\Cache::has($key))
            return \Illuminate\Support\Facades\Cache::put($key, $int,  3600);
        else{
            $cnt = \Illuminate\Support\Facades\Cache::get($key);
            return \Illuminate\Support\Facades\Cache::put($key, $int+$cnt, 3600);
        }
    }
}

if (!function_exists('array_string'))
{
    function array_string(array $array):string
    {
        $string = "";
        foreach ($array as $key => $item) {
            if (strlen(removeSpaces($item)))
                $string .= "$item | , ";
        }
        return $string;
    }
}

if (!function_exists('expire_mmyy'))
{
    function expire_mmyy($expire)
    {
        $a = substr($expire,0,2);
        $b = substr($expire,-2);

        if ((int)$a > 12)
            return $b.$a;
        else
            return $expire;
    }
}

if (!function_exists('expire_yymm'))
{
    function expire_yymm($expire)
    {
        $a = substr($expire,0,2);
        $b = substr($expire,-2);

        if ((int)$a > 12)
            return $expire;
        else
            return $b.$a;
    }
}

if (!function_exists('price_format')) {
    function price_format($price)
    {
        return number_format($price, 2, ".", " ");
    }
}
if (!function_exists('nf')) {
    function nf($number)
    {
        return number_format($number, 2, ".", " ");
    }
}

if (!function_exists('convert_text_latin')) {
    function convert_text_latin($text)
    {
        $cyr = [
            'қ','Қ','а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п',
            'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я',
            'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П',
            'Р', 'С', 'Т', 'У', 'Ў', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
        ];
        $lat = [
            'q','Q','a', 'b', 'v', 'g', 'd', 'e', 'yo', 'j', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p',
            'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sh', 'a', 'i', 'y', 'e', 'yu', 'ya',
            'A', 'B', 'V', 'G', 'D', 'E', 'Yo', 'J', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P',
            'R', 'S', 'T', 'U', 'O', 'F', 'H', 'Ts', 'Ch', 'Sh', 'Sh', 'A', 'I', 'Y', 'e', 'Yu', 'Ya'
        ];
        return str_replace($cyr, $lat, $text);
    }
}

if (!function_exists('is_cyril')) {
    function is_cyril($text)
    {
        return preg_match('/[А-Яа-яЁё]/u', $text);
    }
}

if (!function_exists('removeSpaces')) {
    function removeSpaces($string)
    {
        return str_replace(' ', '', $string);
    }
}

if (!function_exists('excel_to_date')) {
    function excel_to_date($time)
    {
        return date('Y-m-d',((int)$time - 25569) * 86400);
    }
}

if (!function_exists('removeChars')) {
    function removeChars($value)
    {
        $title = str_replace(array('\'', '"',"'","`", ',', ';', '.', '’','-','‘','/','+',')','(',' '), "", $value);
        return $title;
    }
}

if (!function_exists('removeMarks')) {
    function removeMarks($value)
    {
        $title = str_replace(array('\'', '’','‘','`','?'), '', $value);
        return $title;
    }
}

if (!function_exists('phoneFormat')) {
    function phoneFormat($value)
    {
        if (strlen($value) == 9)
            return '+998'.$value;
        else
            return $value;
    }
}
if (!function_exists('message_set'))
{
    function message_set($message,$type,$timer = 15)
    {
        session()->put('_message',$message);
        session()->put('_type',$type);
        session()->put('_timer',$timer*1000);
    }
}

if (!function_exists('message_clear'))
{
    function message_clear()
    {
        session()->pull('_message');
        session()->pull('_type');
        session()->pull('_timer');
    }
}

if (!function_exists('sendByTelegram'))
{
    function sendByTelegram($message,$chatID = null)
    {
        $chatID = $chatID ?? env('CHAT_ID','');
        return \App\Jobs\SendTgMessage::dispatch($message,$chatID);
    }
}

if (!function_exists('logObj'))
{
    function logObj($object)
    {
        $unset_list = [
            'updated_at',
            'created_at',
            'email_verified_at',
            'roles'
        ];

        foreach ($unset_list as $item) {
            unset($object->{$item});
            unset($object[$item]);
        }

        return json_encode($object);
    }
}

if (!function_exists('excelHeaderValidate'))
{
    function excelHeaderValidate(array $headers,array $needle)
    {
        foreach ($headers as $index => $header) {

            if (!isset($needle[$index])) break;

            if (!str_contains(mb_strtolower($header),mb_strtolower($needle[$index]))) return [
                'status' => false,
                'message' => "Столбец `$needle[$index]` не найден! Убедитесь что вы загружаете правилный файл!"
            ];
        }

        return [
            'status' => true
        ];
    }
}

if (!function_exists('card_mask')) {
    function card_mask($card)
    {
        return substr($card,0,6).'******'.substr($card,-4);
    }
}
if (!function_exists('get_error_message'))
{
    function get_error_message($response){
        # initial set default info message
        $message = "Undefined error: ".json_encode($response);

        # find error message
        if (isset($response['error']))
        {
            if (isset($response['error']['message']))
            {
                if (is_array($response['error']['message']))
                {
                    if (isset($response['error']['message']['en']))
                        $message = $response['error']['message']['en'];
                    elseif($response['error']['message']['message'])
                        $message = $response['error']['message']['message'];
                    else
                        $message = array_shift($response['error']['message']);
                }
                else $message = $response['error']['message'];
            }
        }
        return $message;
    }
}

if (!function_exists('get_card_type'))
{
    function get_card_type($card)
    {
        $bin = substr($card,0,4);
        $humo_bins = [
            '9860' => 1,
            '4073' => 1,
            '4008' => 1,
            '4067' => 1,
            '4097' => 1,
            '4166' => 1,
            '4187' => 1,
            '4294' => 1,
            '4790' => 1,
            '5555' => 1,
            '4198' => 1,
            '4242' => 1,
            '4916' => 1,
            '4027' => 1,
            '4062' => 1,
            '4728' => 1,
        ];

        if(strlen($card) > 20)
            return "UZCARD";
        elseif (isset($humo_bins[$bin]))
            return 'HUMO';
        elseif(substr($card,0,8) == '86004888')
            return "UNIRED";

        else
            return 'SV';
    }
}
if (!function_exists('is_card_expired'))
{
    function is_card_expired($expire)
    {
        $a = substr($expire,0,2);
        $b = substr($expire,-2);
        if ((int)$b > 12)
            $expire = $b.$a;;

        return date("ym") > $expire;
    }
}

if (!function_exists('is_loan_card'))
{
    function is_loan_card($card)
    {
        $bin = substr($card,0,8);
        $lastTwo = substr($bin,-2);
        if ($lastTwo == '02' || $lastTwo == '32')
            return true;

        $humo_bins = [
            '98601504' => true,
            '98606003' => true,
            '98606066' => true,
            '98606070' => true,
            '98606069' => true,
            '98606068' => true,
            '98600304' => true,
            '98600305' => true,
            '98600404' => true,
            '98600613' => true,
            '98600607' => true,
            '98600611' => true,
            '98600804' => true,
            '98600815' => true,
            '98600816' => true,
            '98601006' => true,
            '98601203' => true,
            '98601307' => true,
            '98601468' => true,
            '98601466' => true,
            '98601666' => true,
            '98601807' => true,
            '98601907' => true,
            '98601905' => true,
            '98602604' => true,
            '98606005' => true,
            '98600330' => true,
        ];
        return $humo_bins[$bin] ?? false;
    }
}

if (!function_exists('humo_card_errors')) {
    function humo_card_errors($code)
    {
        $statuses = [
            104 => 'Карта активна, подключено смс уведомление.',
            125 =>  "Decline, card not effective",
            204 =>  "Pick-up, restricted card",
            207 =>  "Pick-up, special conditions",
            208 =>  "Pick-up, lost card",
            209 =>  "Pick-up, stolen card",
            280 =>  "Decline, Card is not active at Bank will",
            281 =>  "Decline, Card is not active at Cardholder will"
        ];

        return $statuses[$code] ?? $code;
    }
}

if (!function_exists('get_card_status_list')) {
    function get_card_status_list()
    {
        $statuses = [
            '0' => 'Карта активна, подключено смс уведомление.',
            '1' => 'Карта просрочано',
            '2' => 'Карта не найдена',
            '3' => 'Пан неверный, неправильный формат!',
            '4' => 'Статус карты не активен!',
            '5' => 'Карта заблокировано',
            '6' => 'Карта утеряна',
            '20' => 'Временно блокированная карта',
            '12' => 'Временно заблокирован пользователем ',
            '18' => 'Карта в стоп листе',
            '13' => 'Превышено количество попыток ввода PIN',
            '17' => 'PIN Сброшен. Необходимо установить PIN',
            '99' => 'Неизвестная ошибка карты',
        ];

        return $statuses;
    }
}

if (!function_exists('get_card_status')) {
    function get_card_status($status)
    {
        $statuses = get_card_status_list();

        return $statuses[(int)$status] ?? "Временно блокированная карта";
    }
}

if (!function_exists('excel_to_date')) {
    function excel_to_date($time)
    {
        return date('Y-m-d',((int)$time - 25569) * 86400);
    }
}

if (!function_exists('compare_strings')) {
    function compare_strings(string $a, string $b):int
    {
//        $a = preg_replace('/[a-z A-Z]/','',strtolower(convert_text_latin($a)));
//        $b = preg_replace('/[a-z A-Z]/','',strtolower(convert_text_latin($b)));
        $a = strtolower(removeChars(convert_text_latin($a)));
        $b = strtolower(removeChars(convert_text_latin($b)));

        if ($a == $b) return 100;

        $exList = [
            "'" => '',
            'u' => 'o',
            'q' => 'k',
            'kh' => 'h',
            'x' => 'h',
            'dj' => 'j',
            'ie' => 'iye',
            'oev' => 'oyev',
            'ae' => 'aye',
        ];

        foreach ($exList as $key => $list) {
            $a = str_ireplace($key,$list,$a);
            $b = str_ireplace($key,$list,$b);

            $a_first = substr($a,0,1);
            $b_first = substr($b,0,2);
            if ($a_first == 'e' && $b_first == 'ye') $a = 'y'.$a;

            $a_first = substr($a,0,2);
            $b_first = substr($b,0,1);
            if ($b_first == 'e' && $a_first == 'ye') $b = 'y'.$b;

        }
        if (substr($a,0,3) != substr($b,0,3))
        {
            return -1;
        }
        else
            return compare($a,$b);
    }
}
if (!function_exists('compare')) {
    function compare(string $fio_1, string $fio_2):int
    {
        $min_length = min(strlen($fio_1),strlen($fio_2));
        $fio_1 = str_split(substr($fio_1,0,$min_length));
        $fio_2 = str_split(substr($fio_2,0,$min_length));
        foreach ($fio_1 as $item) {
            foreach ($fio_2 as $key => $val) {
                if ($item == $val){
                    unset($fio_2[$key]);
                    break;
                }
            }
        }

        return 100 - intval(count($fio_2)*100/$min_length);
    }
}

if (!function_exists('compare_fio')) {
    function compare_fio(string $fio_1, string $fio_2, $type = 1):int
    {
        $fio_1 = str_replace('  ',' ',$fio_1);
        $fio_2 = str_replace('  ',' ',$fio_2);
        $fio_1 = explode(' ',str_replace('/',' ',$fio_1));
        $fio_2 = explode(' ',str_replace('/',' ',$fio_2));
//        asort($fio_1);
        $fio_1 = array_slice($fio_1,0,2);
//        asort($fio_2);
        $fio_2 = array_slice($fio_2,0,2);

        if (count($fio_1) < 2 || count($fio_2) < 2) return -2;
        // first
        $x = compare_strings($fio_1[0],$fio_2[0]);
        $y = compare_strings($fio_1[1],$fio_2[1]);

        $tmp = $fio_2[0];
        $fio_2[0] = $fio_2[1];
        $fio_2[1] = $tmp;

        $x2 = compare_strings($fio_1[0],$fio_2[0]);
        $y2 = compare_strings($fio_1[1],$fio_2[1]);

        if (($x+$y) < ($x2 + $y2))
        {
            $x = $x2;
            $y = $y2;
        }

        if ($type == 1)
            return min($x,$y);
        else
            return intval(($x+$y)/2);
    }
}

if (!function_exists('int_microtime'))
{
    function int_microtime():int
    {
        return intval(microtime(true) * 1000);
    }
}

if (!function_exists('appStatus')) {
    function appStatus($code):string
    {
        $status = [
            -2 => 'отказано',
            -1 => "не завершен",
            0 => 'новый',
            1 => 'одобрен'
        ];

        return $status[$code] ?? $code;
    }
}
