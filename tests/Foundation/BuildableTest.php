<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-21 10:46:35
 */

namespace CodeSinging\AdminView\Tests\Foundation;

use CodeSinging\AdminView\Foundation\Buildable;
use PHPUnit\Framework\TestCase;

class BuildableTest extends TestCase
{
    public function testBuild()
    {
        $example = new BuildableExample();
        self::assertEquals('example', $example);
    }
}

class BuildableExample extends Buildable
{

    /**
     * @inheritDoc
     */
    public function build()
    {
        return 'example';
    }
}