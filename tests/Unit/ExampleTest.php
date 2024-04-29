<?php

namespace Tests\Unit;

use Nette\Utils\Random;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function test_is_this_a_string()
    {
        $this->assertIsString(
            Random::generate()
        );
    }
}
