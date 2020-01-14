<?php 
/*
 * Plugin name: All in one event calendar disable activate
 * Version: 1.0.0
 * Description: The all in one event calendar introduced a 'forced' sign-in for version 2.6 up. This plugin aims to remove that requirement.
 */
namespace Antanova\Wordpress\Ai1ec;

class DisableActivate
{
    const API_URL = 'https://api.time.ly/api/feature/availability';

    public function assignHooks()
    {
        add_filter('http_response', [$this, 'modify_http_response'], 10, 3);
    }

    public function modify_http_response($response, $parsed_args, $url) {
    
        if ($url !== self::API_URL) {
            return $response;
        }
    
        $search  = '"code":"api-access","available":true';
        $replace = '"code":"api-access","available":false';
    
        $new_response_body = str_replace($search, $replace, $response['body']);
        $response['body'] = $new_response_body;
        
        return $response;
    }
}

(new DisableActivate)->assignHooks();

