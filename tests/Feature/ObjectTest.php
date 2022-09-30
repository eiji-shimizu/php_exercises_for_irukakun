<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Number
{
    public function __construct()
    {
        $this->value = 0;
    }

    public function incriment()
    {
        $this->value  = $this->value + 1;
    }

    public function add($num)
    {
        $this->value = $this->value + $num;
    }

    public function getValue()
    {
        return $this->value;
    }

    private $value;
}

class ObjectTest extends TestCase
{
    public function passByValIncriment($numObject)
    {
        $numObject->incriment();
    }

    public function passByRefIncriment(&$numObject)
    {
        $numObject->incriment();
    }

    /**
     * @test test001
     *
     * @return void
     */
    public function test001()
    {
        $numberA = new Number;
        $numberB = $numberA;
        $numberA->incriment();
        $numberB->add(39);
        $numberA->incriment();
        $this->assertEquals($numberA->getValue(), 41);
        $this->assertEquals($numberB->getValue(), 41);
    }

    /**
     * @test test002
     *
     * @return void
     */
    public function test002()
    {
        $numberA = new Number;
        $numberB = $numberA;
        $numberA->incriment();
        $numberB->add(39);
        $numberA->incriment();
        $numberC = new Number;
        $numberC->add(5);
        $numberB = $numberC;
        $numberB->incriment();

        $this->assertEquals($numberA->getValue(), 41);
        $this->assertEquals($numberB->getValue(), 6);
        $this->assertEquals($numberC->getValue(), 6);
    }

    /**
     * @test test003
     *
     * @return void
     */
    public function test003()
    {
        $numberA = new Number;
        $numberB = &$numberA;
        $numberA->incriment();
        $numberB->add(39);
        $numberA->incriment();
        $numberC = new Number;
        $numberC->add(5);
        $numberB = &$numberC;
        $numberB->incriment();

        $this->assertEquals($numberA->getValue(), 41);
        $this->assertEquals($numberB->getValue(), 6);
        $this->assertEquals($numberC->getValue(), 6);
    }

    /**
     * @test test004
     *
     * @return void
     */
    public function test004()
    {
        $numberA = new Number;
        $numberB = $numberA;
        $numberA->incriment();
        $numberB->add(39);
        $numberA->incriment();
        $this->assertEquals($numberA->getValue(), 41);
        $this->assertEquals($numberB->getValue(), 41);

        $this->passByValIncriment($numberA);
        $this->assertEquals($numberA->getValue(), 42);
        $this->assertEquals($numberB->getValue(), 42);
    }

    /**
     * @test test005
     *
     * @return void
     */
    public function test005()
    {
        $numberA = new Number;
        $numberB = $numberA;
        $numberA->incriment();
        $numberB->add(39);
        $numberA->incriment();
        $this->assertEquals($numberA->getValue(), 41);
        $this->assertEquals($numberB->getValue(), 41);

        $this->passByRefIncriment($numberA);
        $this->assertEquals($numberA->getValue(), 42);
        $this->assertEquals($numberB->getValue(), 42);
    }
}
