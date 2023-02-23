<?php 

namespace Core;

use Carbon\Carbon;

class Utility {
    
    public static function slug($string) 
    {
        // Remove all characters except letters, digits, and hyphens
        $string = preg_replace('/[^a-zA-Z0-9-]+/', '-', $string);
        
        // Remove any leading or trailing hyphens
        $string = trim($string, '-');
        
        // Convert to lowercase
        $string = strtolower($string);
        
        // Return the resulting slug
        return $string;
    }

    public static function formatDate($dateTime, $format = 'Y-m-d H:i:s')
    {
        $carbon = Carbon::parse($dateTime);
        return $carbon->format($format);
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }

    public static function generateAvatar($email, $size = 128, $type = 'identicon', $rating = 'pg') 
    {
        $gravatar = sprintf('https://secure.gravatar.com/avatar/%s?d=%s&s=%d&r=%s', md5($email), $type, $size, $rating);
        
        return $gravatar;
    }

    public static function getDisplayNames($username, $firstName, $lastName) {
        // Initialize an array of possible display names
        $names = array($username);
        
        // Add first name if not empty
        if (!empty($firstName)) {
            array_push($names, $firstName);
        }
        
        // Add last name if not empty
        if (!empty($lastName)) {
            array_push($names, $lastName);
        }
        
        // Add first name and last name if not empty
        if (!empty($firstName) && !empty($lastName)) {
            array_push($names, $firstName . ' ' . $lastName);
        }
        
        // Add last name and first name if not empty
        if (!empty($firstName) && !empty($lastName)) {
            array_push($names, $lastName . ' ' . $firstName);
        }
        
        return $names;
    }
}