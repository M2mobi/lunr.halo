<?php

/**
 * This file contains the LunrBaseTestCaseMockTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Halo\Tests;

/**
 * This class contains the tests for the unit test base class.
 *
 * @covers Lunr\Halo\LunrBaseTestCase
 */
class LunrBaseTestCaseMockTest extends LunrBaseTestCaseTestCase
{

    /**
     * Test mockFunction()
     *
     * @covers Lunr\Halo\LunrBaseTestCase::mockFunction()
     */
    public function testMockFunction(): void
    {
        $this->mockFunction('is_int', function () { return 'Nope!'; });

        $this->assertEquals('Nope!', is_int(1));

        $this->unmockFunction('is_int');
    }

    /**
     * Test unmockFunction()
     *
     * @covers Lunr\Halo\LunrBaseTestCase::unmockFunction()
     */
    public function testUnmockFunction(): void
    {
        $this->mockFunction('is_int', function () { return 'Nope!'; });

        $this->assertEquals('Nope!', is_int(1));

        $this->unmockFunction('is_int');

        $this->assertTrue(is_int(1));
    }

    /**
     * Test mockMethod()
     *
     * @covers Lunr\Halo\LunrBaseTestCase::mockMethod()
     */
    public function testMockMethod(): void
    {
        $class = new MockClass();

        $this->mockMethod([ $class, 'baz' ], function () { return 'Nope!'; });

        $this->assertEquals('Nope!', $class->baz());

        $this->unmockMethod([ $class, 'baz' ]);
    }

    /**
     * Test mockMethod()
     *
     * @covers Lunr\Halo\LunrBaseTestCase::mockMethod()
     */
    public function testMockMethodFromObject(): void
    {
        $this->mockMethod([ $this->class, 'baz' ], function () { return 'Nope!'; });

        $this->assertEquals('Nope!', $this->class->baz());

        $this->unmockMethod([ $this->class, 'baz' ]);
    }

    /**
     * Test mockMethod()
     *
     * @covers Lunr\Halo\LunrBaseTestCase::mockMethod()
     */
    public function testMockMethodFromParent(): void
    {
        $this->mockMethod([ $this->childClass, 'baz' ], function () { return 'Nope!'; });

        $this->assertEquals('Nope!', $this->class->baz());

        $this->unmockMethod([ $this->childClass, 'baz' ]);
    }

    /**
     * Test unmockMethod()
     *
     * @covers Lunr\Halo\LunrBaseTestCase::unmockMethod()
     */
    public function testUnmockMethod(): void
    {
        $class = new MockClass();

        $this->mockMethod([ $class, 'baz' ], function () { return 'Nope!'; });

        $this->assertEquals('Nope!', $class->baz());

        $this->unmockMethod([ $class, 'baz' ]);

        $this->assertEquals('string', $class->baz());
    }

    /**
     * Test unmockMethod()
     *
     * @covers Lunr\Halo\LunrBaseTestCase::unmockMethod()
     */
    public function testUnmockMethodFromObject(): void
    {
        $this->mockMethod([ $this->class, 'baz' ], function () { return 'Nope!'; });

        $this->assertEquals('Nope!', $this->class->baz());

        $this->unmockMethod([ $this->class, 'baz' ]);

        $this->assertEquals('string', $this->class->baz());
    }

    /**
     * Test unmockMethod()
     *
     * @covers Lunr\Halo\LunrBaseTestCase::unmockMethod()
     */
    public function testUnmockMethodFromParent(): void
    {
        $this->mockMethod([ $this->childClass, 'baz' ], function () { return 'Nope!'; });

        $this->assertEquals('Nope!', $this->class->baz());

        $this->unmockMethod([ $this->childClass, 'baz' ]);

        $this->assertEquals('string', $this->class->baz());
    }

    /**
     * Test redefineConstant()
     *
     * @covers Lunr\Halo\LunrBaseTestCase::redefineConstant()
     */
    public function testConstantRedefineWithPublicConstant(): void
    {
        $this->assertSame('constant', $this->class::FOOBAR);

        $this->redefineConstant('Lunr\Halo\Tests\MockClass::FOOBAR', 'new value');

        $class = new MockClass();

        $this->assertSame('new value', $class::FOOBAR);

        $this->redefineConstant('Lunr\Halo\Tests\MockClass::FOOBAR', 'constant');

        $class = new MockClass();

        $this->assertSame('constant', $class::FOOBAR);
    }

    /**
     * Test redefineConstant()
     *
     * @covers Lunr\Halo\LunrBaseTestCase::redefineConstant()
     */
    public function testConstantRedefineWithProtectedConstant(): void
    {
        $this->assertSame('constant', $this->class->constant());

        $constant = $this->reflection->getConstant('BARFOO');

        $this->assertSame('constant', $constant);

        $this->redefineConstant('Lunr\Halo\Tests\MockClass::BARFOO', 'new value');

        // https://github.com/krakjoe/uopz/issues/111
        //$this->assertSame('new value', $this->class->constant());

        $constant = $this->reflection->getConstant('BARFOO');

        $this->assertSame('new value', $constant);

        $this->redefineConstant('Lunr\Halo\Tests\MockClass::BARFOO', 'constant');

        $this->assertSame('constant', $this->class->constant());

        $constant = $this->reflection->getConstant('BARFOO');

        $this->assertSame('constant', $constant);
    }

    /**
     * Test redefineConstant() with a global constant
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Halo\LunrBaseTestCase::redefineConstant()
     */
    public function testGlobalConstantRedefine(): void
    {
        define('FOOBAR', 'constant');
        $this->assertSame('constant', FOOBAR);

        $this->redefineConstant('FOOBAR', 'new value');

        $this->assertSame('new value', FOOBAR);

        $this->redefineConstant('FOOBAR', 'constant');

        $this->assertSame('constant', FOOBAR);
    }

    /**
     * Test undefineConstant()
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Halo\LunrBaseTestCase::undefineConstant()
     */
    public function testConstantUndefineWithPublicConstant(): void
    {
        $this->assertSame('constant', $this->class::FOOBAR);

        $this->undefineConstant('Lunr\Halo\Tests\MockClass::FOOBAR');

        $this->assertFalse(defined('Lunr\Halo\Tests\MockClass::FOOBAR'));
    }

    /**
     * Test undefineConstant()
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Halo\LunrBaseTestCase::undefineConstant()
     */
    public function testConstantUndefineWithProtectedConstant(): void
    {
        $this->assertSame('constant', $this->class->constant());

        $constant = $this->reflection->getConstant('BARFOO');

        $this->assertSame('constant', $constant);

        $this->undefineConstant('Lunr\Halo\Tests\MockClass::BARFOO');

        $this->assertFalse(defined('Lunr\Halo\Tests\MockClass::BARFOO'));
    }

    /**
     * Test undefineConstant() with a global constant
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Halo\LunrBaseTestCase::undefineConstant()
     */
    public function testGlobalConstantUndefine(): void
    {
        define('FOOBAR', 'constant');
        $this->assertSame('constant', FOOBAR);

        $this->undefineConstant('FOOBAR');

        $this->assertFalse(defined('FOOBAR'));
    }

}

?>
