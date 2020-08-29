<?php

declare(strict_types=1);


namespace Resource;


interface Resource
{

    public function __set($name, $value);

    public function __get($name);



}