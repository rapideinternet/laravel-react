<?php

namespace LaravelReact;

class ComponentRenderer
{

    public function render($name, array $attributes)
    {
        $id = uniqid();

        // add validation and transforming
        $jsonAttributes = json_encode($attributes);
        $componentURI = asset(sprintf('js/components/%s.js', strtolower($name)));

        return "
<span id='$id'></span>
<script src='$componentURI'></script>
<script type='text/babel'>
ReactDOM.render(React.createElement($name, $jsonAttributes, document.getElementById('$id')))
</script>
        ";
    }

}