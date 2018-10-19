<?php

use Illuminate\Support\Facades\Blade;

Blade::directive('component', function ($component, $attributes) {
    app()->make(\LaravelReact\ComponentRenderer::class)->render($component, $attributes);
});