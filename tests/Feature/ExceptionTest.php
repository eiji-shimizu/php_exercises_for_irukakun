<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExceptionTest extends TestCase
{
    /**
     * @test test001
     *
     * @return void
     */
    public function test001()
    {
        try {
            throw new \Exception('エラーメッセージA');
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'エラーメッセージA');
        }
    }

    /**
     * @test test002
     *
     * @return void
     */
    public function test002()
    {
        try {
            try {
                throw new \Exception('エラーメッセージA');
            } catch (\Exception $e) {
                // 改めてスロー
                throw $e;
            }
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'エラーメッセージA');
        }
    }

    /**
     * @test test003
     *
     * @return void
     */
    public function test003()
    {
        try {
            try {
                throw new \Exception('エラーメッセージA');
            } catch (\Exception $e) {
                // ネストさせてスロー
                throw new \Exception('エラーメッセージB', -1, $e);
            }
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'エラーメッセージB');
            $this->assertEquals($e->getPrevious()->getMessage(), 'エラーメッセージA');
            // ネストされていない場合はnullが返る
            $this->assertNull($e->getPrevious()->getPrevious());
        }
    }
}
