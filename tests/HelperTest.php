<?php

namespace Kielabokkie\LaravelConceal\Tests;

use Kielabokkie\LaravelConceal\Tests\TestCase;

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
            'password' => 'secret',
        ];

        $output = conceal($data);

        $this->assertEquals('wouter', $output['username']);
        $this->assertEquals('********', $output['password']);
    }
}
