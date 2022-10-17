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

    /**
     * @test test004
     *
     * @return void
     */
    public function test004()
    {
        try {
            throw new \LogicException('ロジックエラー');
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'ロジックエラー');
        } catch (\LogicException $e) {
            // 上に書かれたcatchであてはまるものがあればそこで処理される
            // 従ってここには来ない
            $this->assertTrue(false);
        }
    }

    /**
     * @test test005
     *
     * @return void
     */
    public function test005()
    {
        try {
            throw new \LogicException('ロジックエラー');
        } catch (\LogicException $e) {
            $this->assertEquals($e->getMessage(), 'ロジックエラー');
        } catch (\Exception $e) {
            // 上に書かれたcatchであてはまるものがあればそこで処理される
            // 従ってここには来ない
            $this->assertTrue(false);
        }
    }

    /**
     * @test test006
     *
     * @return void
     */
    public function test006()
    {
        try {
            throw new \LogicException('ロジックエラー');
        } catch (\RuntimeException $e) {
            // ここには来ない
            $this->assertTrue(false);
        } catch (\LogicException $e) {
            $this->assertEquals($e->getMessage(), 'ロジックエラー');
        } catch (\Exception $e) {
            // 上に書かれたcatchであてはまるものがあればそこで処理される
            // 従ってここには来ない
            $this->assertTrue(false);
        }
    }

    /**
     * @test test007
     *
     * @return void
     */
    public function test007()
    {
        try {
            throw new \RuntimeException('ランタイムエラー');
        } catch (\LogicException $e) {
            // ここには来ない
            $this->assertTrue(false);
        } catch (\RuntimeException $e) {
            $this->assertEquals($e->getMessage(), 'ランタイムエラー');
        } catch (\Exception $e) {
            // 上に書かれたcatchであてはまるものがあればそこで処理される
            // 従ってここには来ない
            $this->assertTrue(false);
        }
    }
}
