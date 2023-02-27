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

    public static function getIpAddress()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ipAddress = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipAddress = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ipAddress = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ipAddress = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ipAddress = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $ipAddress = getenv('REMOTE_ADDR');
        } else {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }

        return $ipAddress;
    }

    public static function getWords($string, $numberOfWords) 
    {
        $words = explode(' ', $string);
        return implode(' ', array_slice($words, 0, $numberOfWords));
    }

    public static function escape($input) 
    {
        // Remove leading and trailing whitespace from input
        $input = trim($input);
        
        // Remove tags
        $input = strip_tags($input);

        // Remove any backslashes that could be used in an XSS attack
        $input = stripslashes($input);
        
        // Convert special characters to their HTML entities
        $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML401, 'UTF-8');
        
        // Replace newline characters with their HTML entity equivalents
        $input = str_replace(array("\r", "\n"), array("&#13;", "&#10;"), $input);
        
        // Return the escaped input
        return $input;
    }
}