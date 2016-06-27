<?php
/**
 * Silverstripe X-Framer
 *
 * @package Silverstripe-X-Framer
 * @license MIT License https://github.com/Cyber-Duck/Silverstripe-X-Framer/blob/master/LICENSE
 * @author  <andrewm@cyber-duck.co.uk>
 **/
class Xframer {

    /**
     * @since version 1.0.0
     *
     * @static string $ip The current user IP address
     **/
    private static $ip;

    /**
     * @since version 1.0.0
     *
     * @static array $excluded An array of IP addresses to exclude from returning X-Frame header
     **/
    private static $excluded = array();
    
    /**
     * @since version 1.0.0
     *
     * @static array $headers An array of server headers to check for an IP
     **/
    private static $headers = array(
        'HTTP_CLIENT_IP', 
        'HTTP_X_FORWARDED_FOR', 
        'HTTP_X_FORWARDED', 
        'HTTP_X_CLUSTER_CLIENT_IP', 
        'HTTP_FORWARDED_FOR', 
        'HTTP_FORWARDED', 
        'REMOTE_ADDR'
    );

    /**
     * Run the plugin by setting and checking the current user IP and setting
     * an X-Frame header if required
     *
     * @since version 1.0.0
     *
     * @param string $header X-Frame option DENY | SAMEORIGIN
     *
     * @return void
     **/
    public static function init($header = 'SAMEORIGIN')
    {
        self::setUserIP();
        self::setExcludedIPs();

        if(!in_array(self::$ip, self::$excluded))
        {
            if(is_object(Controller::curr()->response))
            {
                Controller::curr()->response->addHeader('X-Frame-Options', $header);
            }
        }
    }

    /**
     * Set the current user IP
     *
     * @since version 1.0.0
     *
     * @return void
     **/
    private static function setUserIP()
    {
        $ips = [];

        foreach(self::$headers as $header)
        {
            if(array_key_exists($header, $_SERVER) === true)
            {
                foreach(explode(',', $_SERVER[$header]) as $ip) $ips[] = trim($ip);
            }
        }

        if(!empty($ips))
        {
            self::$ip = implode(',', $ips);
        }
    }

    /**
     * Set an array of IPs to exclude X-Frame headers from
     *
     * @since version 1.0.0
     *
     * @return void
     **/
    private static function setExcludedIPs()
    {
        self::$excluded = Config::inst()->get('Xframer','ips');
    }
}