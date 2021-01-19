<?php
    function print_r_pre($array, $name) {
        echo '<pre>' . $name . ':<br />', "\n";
        print_r($array);
        echo '</pre>', "\n";
    }
    function var_dump_pre($array, $name) {
        echo '<pre>' . $name . ':<br />', "\n";
        var_dump($array);
        echo '</pre>', "\n";
    }
    
    function randomRgb() {
        $r = rand(0, 255);
        $g = rand(0, 255);
        $b = rand(0, 255);
        // echo $r . ' ' . $g . ' ' . $b;
        $return = 'rgb(' . $r . ', ' . $g . ', ' . $b . ')';
        return $return;
    }
    function br($input) {
        $output = '';
        for ($i = 0; $i < $input; ++$i) {
            $output .= '<br />';
        }
        return $output;
    }
    function breakingLine() {
        $output = '';
        $output .= '<br>';
        $output .= '===================================================';
        $output .= '<br>';
        return $output;
    }