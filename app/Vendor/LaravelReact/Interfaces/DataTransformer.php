<?php

namespace LaravelReact\Interfaces;

interface DataTransformer
{

    /**
     * @param mixed ...$data
     * @return array
     */
    public function transform(...$data);

}