<?php

namespace Kielabokkie\LaravelConceal\Tests;

use PHPUnit\Framework\TestCase;

/**
 * phpcs:disable PSR1.Methods.CamelCapsMethodName
 */
final class HelperTest extends TestCase
{
    /** @test */
    public function it_can_conceal_data_using_the_helper(): void
    {
        $data = [
            'username' => 'wouter',
            'password' => 'secret'
        ];

        $hide = ['password'];

        $output = conceal($data, $hide);

        $this->assertEquals('wouter', $output['username']);
        $this->assertEquals('********', $output['password']);
    }
}
