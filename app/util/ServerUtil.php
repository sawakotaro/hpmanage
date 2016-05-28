<?php

class ServerUtil {
    
    
    
    /**
     * URLを分割した配列を取得します。
     * @param String $url
     * @return Array
     */
    public static function getDomain($url = null) {
        if(empty($url)) {
            $url = Request::root();
        } else {
            $parse_url = parse_url($url);
            $url = $parse_url['scheme'] . "://" . $parse_url['host'];
        }
        
        $matches = array();
        
        preg_match('/^(https?:\/\/(.*)\.|https?:\/\/)(.*)\.(.*)$/', $url, $matches);
        $subdomain = htmlspecialchars($matches[2], ENT_QUOTES, "utf-8");
        $domain = htmlspecialchars($matches[3], ENT_QUOTES, "utf-8");
        $tld = htmlspecialchars($matches[4], ENT_QUOTES, "utf-8");
        
        // プロトコルを判定して変数に格納する
        if(Request::secure()) {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        
        return array($protocol,$subdomain, $domain, $tld);
    }
    
}