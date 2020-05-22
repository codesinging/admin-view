<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-22 08:16:42
 */

namespace CodeSinging\AdminView\Tests\Foundation;

use CodeSinging\AdminView\Foundation\Property;
use PHPUnit\Framework\TestCase;

class PropertyTest extends TestCase
{
    public function testName()
    {
        self::assertEquals('id', (new Property('id'))->name());
        self::assertEquals('id', (new Property(':id'))->name());
        self::assertEquals('id', (new Property('id', '3'))->name());
        self::assertEquals('id', (new Property('id', ':3'))->name());
        self::assertEquals('id', (new Property('id', 3))->name());
    }

    public function testDefault()
    {
        self::assertEquals('default title', (new Property('title', ':title', 'default title'))->default());
        self::assertEquals(20, (new Property(':id', 'id', 20))->default());
    }

    public function testHasDefault()
    {
        self::assertFalse((new Property('title'))->hasDefault());
        self::assertTrue((new Property('title', ':title', 'Title'))->hasDefault());
    }

    public function testIsBindIsFalse()
    {
        self::assertFalse((new Property('disabled'))->isBind());
        self::assertFalse((new Property('title', 'Title'))->isBind());
        self::assertFalse((new Property('title', '\:Title'))->isBind());
        self::assertFalse((new Property('title', '\\Title'))->isBind());
    }

    public function testIsBindIsTrue()
    {
        self::assertTrue((new Property('title', ':title'))->isBind());
        self::assertTrue((new Property(':title', 'title'))->isBind());
        self::assertTrue((new Property(':age', '20'))->isBind());
        self::assertTrue((new Property('age', ':20'))->isBind());
        self::assertTrue((new Property('age', 20))->isBind());
        self::assertTrue((new Property('disabled:', true))->isBind());
        self::assertTrue((new Property('disabled:', false))->isBind());
        self::assertTrue((new Property('disabled:', ":true"))->isBind());
        self::assertTrue((new Property('disabled:', ":false"))->isBind());
        self::assertTrue((new Property('data:', []))->isBind());
    }

    public function testIsWithString()
    {
        self::assertTrue((new Property('title'))->is('title'));
        self::assertTrue((new Property(':title'))->is('title'));
    }

    public function testIsWithInstance()
    {
        self::assertTrue((new Property('title'))->is(new Property('title')));
        self::assertTrue((new Property('title'))->is(new Property(':title')));
        self::assertTrue((new Property(':title'))->is(new Property('title')));
        self::assertTrue((new Property(':title'))->is(new Property(':title')));
    }

    public function testBuildNameIsEmpty()
    {
        self::assertNull((new Property(''))->build());
    }

    public function testBuildValueIsNull()
    {
        self::assertEquals('disabled', new Property('disabled'));
        self::assertEquals(':disabled="true"', new Property(':disabled'));
    }

    public function testBuildValueIsString()
    {
        self::assertEquals('title="Title"', (new Property('title', 'Title'))->build());
        self::assertEquals('title="true"', new Property('title', 'true'));
        self::assertEquals('title="false"', new Property('title', 'false'));
        self::assertEquals('title="20"', new Property('title', '20'));
    }

    public function testBuildValueIsBoolean()
    {
        self::assertEquals(':disabled="true"', new Property('disabled', true));
        self::assertEquals(':disabled="false"', new Property('disabled', false));
    }

    public function testBuildValueIsNumber()
    {
        self::assertEquals(':age="20"', new Property('age', 20));
        self::assertEquals(':score="60.5"', new Property('score', 60.5));
    }

//    public function testBuildValueIsArray()
//    {
//        self::assertEquals(':class="[\"margin\"]"', (new Property('class', ["margin"]))->build());
//        self::assertEquals(':data="{\"title\"=>\"Title\"}"', new Property('data', ["title" => 'Title']));
//    }

    public function testBuildValueStartsWithColon()
    {
        self::assertEquals(':title="title"', new Property('title', ':title'));
        self::assertEquals(':age="20"', new Property('age', ':20'));
        self::assertEquals(':disabled="true"', new Property('disabled', ':true'));
        self::assertEquals(':disabled="false"', new Property('disabled', ':false'));
    }

    public function testBuildValueStartsWithSlashes()
    {
        self::assertEquals('title=":title"', new Property('title', '\:title'));
        self::assertEquals('title="\title"', new Property('title', '\\\\title'));
    }

    public function testBuildNameStartsWithColon()
    {
        self::assertEquals(':title="title"', new Property(':title', 'title'));
        self::assertEquals(':age="22"', new Property(':age', '22'));
        self::assertEquals(':disabled="true"', new Property(':disabled', 'true'));
        self::assertEquals(':disabled="false"', new Property(':disabled', 'false'));
    }

    public function testBuildNameStartsWithColonAndValueStartsWithColon()
    {
        self::assertEquals(':title="title"', new Property(':title', ':title'));
        self::assertEquals(':age="22"', new Property(':age', ':22'));
        self::assertEquals(':disabled="true"', new Property(':disabled', ':true'));
        self::assertEquals(':disabled="false"', new Property(':disabled', ':false'));
    }

    public function testBuildNameStartsWithColonAndValueIsBoolean()
    {
        self::assertEquals(':disabled="true"', new Property(':disabled', true));
        self::assertEquals(':disabled="false"', new Property(':disabled', false));
    }

    public function testBuildNameStartsWithColonAndValueIsNumber()
    {
        self::assertEquals(':age="20"', new Property(':age', 20));
        self::assertEquals(':score="60.5"', new Property(':score', 60.5));
    }

//    public function testBuildNameStartsWithColonAndValueIsArray()
//    {
//        self::assertEquals(':class="[\"margin\"]"', new Property(':class', ["margin"]));
//        self::assertEquals(':data="{\"title\"=>\"Title\"}"', new Property(':data', ["title" => 'Title']));
//    }
}
