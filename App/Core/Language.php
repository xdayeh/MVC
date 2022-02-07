<?php

namespace AbuDayeh\Core;

class Language
{
    private array $dictionary = [];

    public function load($path)
    {
        $lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2) : 'en';

        if(!empty($_COOKIE['lang'])){
            $_COOKIE['lang'] = htmlspecialchars($_COOKIE['lang']) === 'en' ? 'en' : 'ar';
        } else {
            $_COOKIE['lang'] = $lang == 'ar' ? 'ar' : 'en';
            setcookie('lang', $_COOKIE['lang'], time() + (86400 * 7), '/', FALSE, TRUE);
        }

        $languageFileToLoad = LANGUAGES_PATH.$_COOKIE['lang']. DS . $path . '.lang.php';
        if(file_exists($languageFileToLoad)) {
            require $languageFileToLoad;
            if(is_array($Lang) && !empty($Lang)) {
                foreach ($Lang as $key => $value) {
                    $this->dictionary[$key] = $value;
                }
            }
        } else {
            trigger_error('Sorry the language file ' . $path . ' not exists', E_USER_WARNING);
        }
    }

    public function get($key)
    {
        if(array_key_exists($key, $this->dictionary)) {
            return $this->dictionary[$key];
        }
    }

    public function feedKey($key, $data)
    {
        if(array_key_exists($key, $this->dictionary)) {
            array_unshift($data, $this->dictionary[$key]);
            return call_user_func_array('sprintf', $data);
        }
    }

    public function getDictionary(): array
    {
        return $this->dictionary;
    }
}