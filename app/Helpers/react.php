<?php

namespace App\Helpers;

class React
{



    public function build($name, $data)
    {
        $id = uniqid($name."-");
        // String to save the data
        $string = "";
        // Loop through data and save it in the string
        foreach ($data as $key => $data) {
            $string .= "data-" . $key . "='" . json_encode($data) . "'";
        }
        // Return string
        return "
            <script id='$id-script'>
                document.addEventListener('DOMContentLoaded', function() {
                   window.ReactLoad('$name', document.getElementById('$id'));
                   let script = document.getElementById('$id-script');
                   script.parentNode.removeChild(script);
                })
            </script>
            <div id='$id' $string></div>
        ";
    }

}