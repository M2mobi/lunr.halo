<?php

/**
 * This file contains the LunrBaseTestTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Halo
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Halo\Tests;

use Lunr\Halo\LunrBaseTest;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains the tests for the unit test base class.
 *
 * @covers Lunr\Halo\LunrBaseTest
 */
class LunrBaseTestTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the LunrBaseTest class.
     * @var LunrBaseTest
     */
    protected $class;

    /**
     * Reflection instance of the LunrBaseTest class.
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Unit test constructor.
     */
    public function setUp()
    {
        $this->class      = $this->getMockForAbstractClass('Lunr\Halo\LunrBaseTest');
        $this->reflection = new ReflectionClass('Lunr\Halo\LunrBaseTest');
    }

    /**
     * Unit test destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Test that the 'class' property is not set by default.
     */
    public function testClassIsUnset()
    {
        $property = $this->reflection->getProperty('class');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->class));
    }

    /**
     * Test that the 'reflection' property is not set by default.
     */
    public function testReflectionIsUnset()
    {
        $property = $this->reflection->getProperty('reflection');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->class));
    }

}

?>
