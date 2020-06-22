<?php


namespace Pugofka\Yametrika\Test;

/**
 * Class GetConfigDataTest
 * @package Pugofka\Yametrika\Test
 */
class GetConfigDataTest extends TestCase
{

    /** @test */
    public function it_correctly_set_default_config()
    {
        $this->assertSame('test app', config('yametrika.app_id'));
    }
}
