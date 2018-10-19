<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class React
 * @package App\Facades
 */
class React extends Facade
{

    /**
     * @param $name
     * @param $data
     * @return mixed
     */

    public static function build($name, $data)
    {
        // String to save the data
        $string = "";

        // Loop through data and save it in the string
        foreach ($data as $key => $data) {
            $string .= "data-" . $key . "='" . json_encode($data) . "'";
        }

        // Return string
        return "
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                   window.ReactLoad('Blog', document.getElementById('$name'));
                })
            </script>
            <div id='$name' $string></div>
        ";
    }
}