<?php

    //Function to ellipsize text without breaking words.
    function ellipsize($string) {

        $maxLength = 128;

        if (strlen($string) <= $maxLength) {
            return $string;
        }
    
        // Find the last space before the cutoff
        $cutoff = strrpos(substr($string, 0, $maxLength), ' ');
    
        // If no space was found, fallback to hard cutoff
        if ($cutoff === false) {
            $cutoff = $maxLength;
        }
    
        return substr($string, 0, $cutoff) . '...';
    }
?>    