<?php

namespace Kielabokkie\LaravelConceal\Tests;

use Illuminate\Support\Collection;
use Kielabokkie\LaravelConceal\Concealer;
use PHPUnit\Framework\TestCase;

/**
 * phpcs:disable PSR1.Methods.CamelCapsMethodName
 */
final class ConcealerTest extends TestCase
{
    private $concealer;

    protected function setUp(): void
    {
        $this->concealer = new Concealer;
    }

    /** @test */
    public function it_conceals_only_given_keys(): void
    {
        $data = [
            'username' => 'wouter',
            'password' => 'secret'
        ];

        $hide = ['password'];

        $output = $this->concealer->conceal($data, $hide);

        // Input was an array so output should be too
        $this->assertIsArray($output);

        $this->assertEquals('wouter', $output['username']);
        $this->assertEquals('********', $output['password']);
    }

    /** @test */
    public function it_can_handle_collections(): void
    {
        $data = new Collection([
            'username' => 'wouter',
            'password' => 'secret'
        ]);

        $hide = ['password'];

        $output = $this->concealer->conceal($data, $hide);

        // Input was a collection so output should be too
        $this->assertInstanceOf(Collection::class, $output);

        $this->assertEquals('wouter', $output['username']);
        $this->assertEquals('********', $output['password']);
    }
}
