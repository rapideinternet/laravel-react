<?php

namespace LaravelReact\Abstracts;

abstract class DataTransformer
{

    protected $attributes = [];

    public function transform(...$data)
    {
        foreach ($this->attributes as $attribute) {
            if (!array_key_exists($attribute, $data)) {
                return sprintf('"%s" does not exist in provided data', $attribute);
            }

            $value = $data[$attribute];

            if (method_exists($this, ($methodName = sprintf('transform %s', camel_case($attribute))))) {
                $value = $this->{$methodName}($value);
            }

            return $value;
        }
    }

}