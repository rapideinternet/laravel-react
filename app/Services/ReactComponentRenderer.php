<?php namespace App\Services;


class ReactComponentRenderer
{

    public function render($component, array $variables, ...$extraVariables)
    {
        $container = uniqid('react_component');

        echo "
       
        <div id=\"$container\"></div> 
        <script>
//        const e = React.createElement;

        const domContainer = document.querySelector('#$container');
        window.loadBlog(domContainer," . $this->transformVariables($variables) . ");
//        ReactDOM.render(e(" . $component . ", " . $this->transformVariables($variables) . " ), domContainer);
        </script>";
    }

    public function transformVariables($variables)
    {
        return json_encode($variables);
    }
}