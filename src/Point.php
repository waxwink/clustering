<?php

namespace Waxwink\Clustering;


class Point
{
    protected $x;
    protected $y;

    const SHOULD_BE_INTEGER = 'The input variables should be integer';

    /**
     * Point constructor.
     * @param $x
     * @param $y
     */
    public function __construct($x, $y)
    {
        if (! is_numeric($x) || ! is_numeric($y)){
            throw new \Exception(static::SHOULD_BE_INTEGER);
        }

        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if($name == 'x' || $name =='y'){
            return $this->$name;
        }
    }


}
