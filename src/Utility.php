<?php 

namespace Core;

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
}