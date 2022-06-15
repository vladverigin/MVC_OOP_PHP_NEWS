<?php

namespace views;

abstract class BaseView
{
    protected string $layout;

    abstract public function output():string;

    abstract protected function prepareLayout($data);
}
