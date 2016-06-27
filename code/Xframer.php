<?php
/**
 * Silverstripe X-Framer
 *
 * @package silverstripe-x-framer
 * @license MIT License https://github.com/Cyber-Duck/silverstripe-x-framer/blob/master/LICENSE
 * @author  <andrewm@cyber-duck.co.uk>
 **/
class Xframer {

	private static $ip;

	private static $excluded = array();

	private static $headers = array(
		'HTTP_CLIENT_IP', 
		'HTTP_X_FORWARDED_FOR', 
		'HTTP_X_FORWARDED', 
		'HTTP_X_CLUSTER_CLIENT_IP', 
		'HTTP_FORWARDED_FOR', 
		'HTTP_FORWARDED', 
		'REMOTE_ADDR'
	);

	public static function init($header = 'SAMEORIGIN')
	{
		self::getUserIP();
		self::getExcludedIPs();

		if(!in_array(self::$ip, self::$excluded))
		{
			if(is_object(Controller::curr()->response))
			{
				Controller::curr()->response->addHeader('X-Frame-Options', $header);
			}
		}
	}

	private static function getUserIP()
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

	private static function getExcludedIPs()
	{
		self::$excluded = Config::inst()->get('Xframer','ips');
	}
}