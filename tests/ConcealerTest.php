<?php

namespace Kielabokkie\LaravelConceal\Tests;

use Illuminate\Support\Collection;
use Kielabokkie\LaravelConceal\Concealer;
use Kielabokkie\LaravelConceal\Tests\TestCase;

/**
 * phpcs:disable PSR1.Methods.CamelCapsMethodName
 */
final class ConcealerTest extends TestCase
{
    private $concealer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->concealer = new Concealer;
    }

    /** @test */
    public function it_conceals_default_keys(): void
    {
        $data = [
            'username' => 'wouter',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $output = $this->concealer->conceal($data);

        $this->assertEquals('wouter', $output['username']);
        $this->assertEquals('********', $output['password']);
        $this->assertEquals('********', $output['password_confirmation']);
    }

    /** @test */
    public function it_conceals_given_keys(): void
    {
        $data = [
            'username' => 'wouter',
            'apikey' => 'secret'
        ];

        $hide = ['apikey'];

        $output = $this->concealer->conceal($data, $hide);

        $this->assertEquals('wouter', $output['username']);
        $this->assertEquals('********', $output['apikey']);
    }

    /** @test */
    public function it_conceals_arrays(): void
    {
        $data = [
            'username' => 'wouter',
            'password' => 'secret'
        ];

        $hide = ['password'];

        $output = $this->concealer->conceal($data, $hide);

        $this->assertEquals('wouter', $output['username']);
        $this->assertEquals('********', $output['password']);
    }

    /** @test */
    public function it_conceals_collections(): void
    {
        $data = new Collection([
            'username' => 'wouter',
            'password' => 'secret'
        ]);

        $output = $this->concealer->conceal($data);

        $this->assertEquals('wouter', $output['username']);
        $this->assertEquals('********', $output['password']);
    }

    /** @test */
    public function it_returns_an_array_if_array_is_given(): void
    {
        $data = [
            'password' => 'secret'
        ];

        $output = $this->concealer->conceal($data);

        // Input was an array so output should be too
        $this->assertIsArray($output);
    }

    /** @test */
    public function it_returns_a_collection_if_collection_is_given(): void
    {
        $data = new Collection([
            'password' => 'secret'
        ]);

        $output = $this->concealer->conceal($data);

        // Input was a collection so output should be too
        $this->assertInstanceOf(Collection::class, $output);
    }
}
