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
            'apikey' => 'secret',
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
            'password' => 'secret',
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
            'password' => 'secret',
        ]);

        $output = $this->concealer->conceal($data);

        $this->assertEquals('wouter', $output['username']);
        $this->assertEquals('********', $output['password']);
    }

    /** @test */
    public function it_conceals_multidimensional_collections(): void
    {
        $sub = new Collection([
            'username' => 'wouter',
            'password' => 'secret',
        ]);

        $data = new Collection([
            'username' => 'wouter',
            'password' => 'secret',
            'single' => $sub,
            'multi' => new Collection([
                'test' => $sub,
            ]),
        ]);

        $output = $this->concealer->conceal($data);

        $this->assertEquals('wouter', $output['username']);
        $this->assertEquals('********', $output['password']);
        $this->assertEquals('wouter', $output['single']['username']);
        $this->assertEquals('********', $output['single']['password']);
        $this->assertEquals('wouter', $output['multi']['test']['username']);
        $this->assertEquals('********', $output['multi']['test']['password']);
    }

    /** @test */
    public function it_conceals_multidimensional_arrays(): void
    {
        $sub = [
            'username' => 'wouter',
            'password' => 'secret',
        ];

        $data = [
            'username' => 'wouter',
            'password' => 'secret',
            'single' => $sub,
            'multi' => [
                'test' => $sub,
            ],
        ];

        $output = $this->concealer->conceal($data);

        $this->assertEquals('wouter', $output['username']);
        $this->assertEquals('********', $output['password']);
        $this->assertEquals('wouter', $output['single']['username']);
        $this->assertEquals('********', $output['single']['password']);
        $this->assertEquals('wouter', $output['multi']['test']['username']);
        $this->assertEquals('********', $output['multi']['test']['password']);
    }

    /** @test */
    public function it_conceals_mixed_objecs(): void
    {
        $sub = [
            'username' => 'wouter',
            'password' => 'secret',
        ];

        $data = [
            'username' => 'wouter',
            'password' => 'secret',
            'array' => [
                'array' => $sub,
                'collection' => new Collection($sub),
            ],
            'collection' => new Collection([
                'array' => $sub,
                'collection' => new Collection($sub),
            ]),
        ];

        $output = $this->concealer->conceal($data);

        $this->assertEquals('wouter', $output['username']);
        $this->assertEquals('********', $output['password']);
        // Arrays and collection inside an array
        $this->assertEquals('wouter', $output['array']['array']['username']);
        $this->assertEquals('********', $output['array']['array']['password']);
        $this->assertEquals('wouter', $output['array']['collection']['username']);
        $this->assertEquals('********', $output['array']['collection']['password']);
        // Arrays and collection inside a collection
        $this->assertEquals('wouter', $output['collection']['array']['username']);
        $this->assertEquals('********', $output['collection']['array']['password']);
        $this->assertEquals('wouter', $output['collection']['collection']['username']);
        $this->assertEquals('********', $output['collection']['collection']['password']);
    }

    /** @test */
    public function it_returns_an_array_if_array_is_given(): void
    {
        $data = [
            'password' => 'secret',
        ];

        $output = $this->concealer->conceal($data);

        // Input was an array so output should be too
        $this->assertIsArray($output);
    }

    /** @test */
    public function it_returns_a_collection_if_collection_is_given(): void
    {
        $data = new Collection([
            'password' => 'secret',
        ]);

        $output = $this->concealer->conceal($data);

        // Input was a collection so output should be too
        $this->assertInstanceOf(Collection::class, $output);
    }
}
