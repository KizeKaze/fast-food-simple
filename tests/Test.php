<?php

use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testFalse()
    {
        $variable = false;

        $this->assertFalse($variable);
    }
}