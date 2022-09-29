<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VariableTest extends TestCase
{
    public function passByValIncriment($num)
    {
        ++$num;
    }

    public function passByRefIncriment(&$num)
    {
        ++$num;
    }

    /**
     * @test test001
     *
     * @return void
     */
    public function test001()
    {
        $numberA = 1;
        $numberB = $numberA;
        $numberB = $numberB + 39;
        $numberA++;
        $this->assertEquals($numberA, 2);
        $this->assertEquals($numberB, 40);
    }

    /**
     * @test test002
     *
     * @return void
     */
    public function test002()
    {
        $numberA = 1;
        $numberB = &$numberA;
        $numberB = $numberB + 39;
        $numberA++;
        $this->assertEquals($numberA, 41);
        $this->assertEquals($numberB, 41);
    }

    /**
     * @test test003
     *
     * @return void
     */
    public function test003()
    {
        $numberA = 1;
        $numberB = &$numberA;
        $numberC = &$numberB;
        $numberB = $numberB + 39;
        $numberC = $numberC * 2;
        $numberA++;
        $this->assertEquals($numberA, 81);
        $this->assertEquals($numberB, 81);
        $this->assertEquals($numberC, 81);
    }

    /**
     * @test test004
     *
     * @return void
     */
    public function test004()
    {
        $numberA = 1;
        $numberB = $numberA;
        $numberC = &$numberB;
        $numberB = $numberB + 39;
        $numberC = $numberC * 2;
        $numberA++;
        $this->assertEquals($numberA, 2);
        $this->assertEquals($numberB, 80);
        $this->assertEquals($numberC, 80);
    }

    /**
     * @test test005
     *
     * @return void
     */
    public function test005()
    {
        $numberA = 1;
        $numberB = &$numberA;
        $numberC = $numberB;
        $numberB = $numberB + 39;
        $numberC = $numberC * 2;
        $numberA++;
        $this->assertEquals($numberA, 41);
        $this->assertEquals($numberB, 41);
        $this->assertEquals($numberC, 2);
    }

    /**
     * @test test006
     *
     * @return void
     */
    public function test006()
    {
        $numberA = 1;
        $numberB = $numberA;
        $numberC = $numberB;
        $numberB = $numberB + 39;
        $numberC = $numberC * 3;
        $numberA++;
        $this->assertEquals($numberA, 2);
        $this->assertEquals($numberB, 40);
        $this->assertEquals($numberC, 3);

        $this->passByValIncriment($numberA);
        $this->passByValIncriment($numberB);
        $this->passByValIncriment($numberC);
        $this->assertEquals($numberA, 2);
        $this->assertEquals($numberB, 40);
        $this->assertEquals($numberC, 3);
    }

    /**
     * @test test007
     *
     * @return void
     */
    public function test007()
    {
        $numberA = 1;
        $numberB = $numberA;
        $numberC = $numberB;
        $numberB = $numberB + 39;
        $numberC = $numberC * 3;
        $numberA++;
        $this->assertEquals($numberA, 2);
        $this->assertEquals($numberB, 40);
        $this->assertEquals($numberC, 3);

        $this->passByRefIncriment($numberA);
        $this->passByRefIncriment($numberB);
        $this->passByRefIncriment($numberC);
        $this->assertEquals($numberA, 3);
        $this->assertEquals($numberB, 41);
        $this->assertEquals($numberC, 4);
    }
}
