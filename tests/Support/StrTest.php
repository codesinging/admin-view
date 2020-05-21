<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-21 17:17:13
 */

namespace CodeSinging\AdminView\Tests\Support;

use CodeSinging\AdminView\Support\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{
    public function testAfter()
    {
        $this->assertSame('nah', Str::after('hannah', 'han'));
        $this->assertSame('nah', Str::after('hannah', 'n'));
        $this->assertSame('nah', Str::after('ééé hannah', 'han'));
        $this->assertSame('hannah', Str::after('hannah', 'xxxx'));
        $this->assertSame('hannah', Str::after('hannah', ''));
        $this->assertSame('nah', Str::after('han0nah', '0'));
        $this->assertSame('nah', Str::after('han0nah', 0));
        $this->assertSame('nah', Str::after('han2nah', 2));
    }

    public function testAfterLast()
    {
        $this->assertSame('tte', Str::afterLast('yvette', 'yve'));
        $this->assertSame('e', Str::afterLast('yvette', 't'));
        $this->assertSame('e', Str::afterLast('ééé yvette', 't'));
        $this->assertSame('', Str::afterLast('yvette', 'tte'));
        $this->assertSame('yvette', Str::afterLast('yvette', 'xxxx'));
        $this->assertSame('yvette', Str::afterLast('yvette', ''));
        $this->assertSame('te', Str::afterLast('yv0et0te', '0'));
        $this->assertSame('te', Str::afterLast('yv0et0te', 0));
        $this->assertSame('te', Str::afterLast('yv2et2te', 2));
        $this->assertSame('foo', Str::afterLast('----foo', '---'));
    }

    public function testBefore()
    {
        $this->assertSame('han', Str::before('hannah', 'nah'));
        $this->assertSame('ha', Str::before('hannah', 'n'));
        $this->assertSame('ééé ', Str::before('ééé hannah', 'han'));
        $this->assertSame('hannah', Str::before('hannah', 'xxxx'));
        $this->assertSame('hannah', Str::before('hannah', ''));
        $this->assertSame('han', Str::before('han0nah', '0'));
        $this->assertSame('han', Str::before('han0nah', 0));
        $this->assertSame('han', Str::before('han2nah', 2));
    }

    public function testBeforeLast()
    {
        $this->assertSame('yve', Str::beforeLast('yvette', 'tte'));
        $this->assertSame('yvet', Str::beforeLast('yvette', 't'));
        $this->assertSame('ééé ', Str::beforeLast('ééé yvette', 'yve'));
        $this->assertSame('', Str::beforeLast('yvette', 'yve'));
        $this->assertSame('yvette', Str::beforeLast('yvette', 'xxxx'));
        $this->assertSame('yvette', Str::beforeLast('yvette', ''));
        $this->assertSame('yv0et', Str::beforeLast('yv0et0te', '0'));
        $this->assertSame('yv0et', Str::beforeLast('yv0et0te', 0));
        $this->assertSame('yv2et', Str::beforeLast('yv2et2te', 2));
    }

    public function testBetween()
    {
        $this->assertSame('abc', Str::between('abc', '', 'c'));
        $this->assertSame('abc', Str::between('abc', 'a', ''));
        $this->assertSame('abc', Str::between('abc', '', ''));
        $this->assertSame('b', Str::between('abc', 'a', 'c'));
        $this->assertSame('b', Str::between('dddabc', 'a', 'c'));
        $this->assertSame('b', Str::between('abcddd', 'a', 'c'));
        $this->assertSame('b', Str::between('dddabcddd', 'a', 'c'));
        $this->assertSame('nn', Str::between('hannah', 'ha', 'ah'));
        $this->assertSame('a]ab[b', Str::between('[a]ab[b]', '[', ']'));
        $this->assertSame('foo', Str::between('foofoobar', 'foo', 'bar'));
        $this->assertSame('bar', Str::between('foobarbar', 'foo', 'bar'));
    }

    public function testCamel()
    {
        $this->assertSame('laravelPHPFramework', Str::camel('Laravel_p_h_p_framework'));
        $this->assertSame('laravelPhpFramework', Str::camel('Laravel_php_framework'));
        $this->assertSame('laravelPhPFramework', Str::camel('Laravel-phP-framework'));
        $this->assertSame('laravelPhpFramework', Str::camel('Laravel  -_-  php   -_-   framework   '));

        $this->assertSame('fooBar', Str::camel('FooBar'));
        $this->assertSame('fooBar', Str::camel('foo_bar'));
        $this->assertSame('fooBar', Str::camel('foo_bar')); // test cache
        $this->assertSame('fooBarBaz', Str::camel('Foo-barBaz'));
        $this->assertSame('fooBarBaz', Str::camel('foo-bar_baz'));
    }

    public function testContains()
    {
        $this->assertTrue(Str::contains('taylor', 'ylo'));
        $this->assertTrue(Str::contains('taylor', 'taylor'));
        $this->assertTrue(Str::contains('taylor', ['ylo']));
        $this->assertTrue(Str::contains('taylor', ['xxx', 'ylo']));
        $this->assertFalse(Str::contains('taylor', 'xxx'));
        $this->assertFalse(Str::contains('taylor', ['xxx']));
        $this->assertFalse(Str::contains('taylor', ''));
    }

    public function testEndsWith()
    {
        $this->assertTrue(Str::endsWith('jason', 'on'));
        $this->assertTrue(Str::endsWith('jason', 'jason'));
        $this->assertTrue(Str::endsWith('jason', ['on']));
        $this->assertTrue(Str::endsWith('jason', ['no', 'on']));
        $this->assertFalse(Str::endsWith('jason', 'no'));
        $this->assertFalse(Str::endsWith('jason', ['no']));
        $this->assertFalse(Str::endsWith('jason', ''));
        $this->assertFalse(Str::endsWith('jason', [null]));
        $this->assertFalse(Str::endsWith('jason', null));
        $this->assertFalse(Str::endsWith('jason', 'N'));
        $this->assertFalse(Str::endsWith('7', ' 7'));
        $this->assertTrue(Str::endsWith('a7', '7'));
        $this->assertTrue(Str::endsWith('a7', 7));
        $this->assertTrue(Str::endsWith('a7.12', 7.12));
        $this->assertFalse(Str::endsWith('a7.12', 7.13));
        $this->assertTrue(Str::endsWith(0.27, '7'));
        $this->assertTrue(Str::endsWith(0.27, '0.27'));
        $this->assertFalse(Str::endsWith(0.27, '8'));
        $this->assertTrue(Str::endsWith('Jönköping', 'öping'));
        $this->assertTrue(Str::endsWith('Malmö', 'mö'));
        $this->assertFalse(Str::endsWith('Jönköping', 'oping'));
        $this->assertFalse(Str::endsWith('Malmö', 'mo'));
        $this->assertTrue(Str::endsWith('你好', '好'));
        $this->assertFalse(Str::endsWith('你好', '你'));
        $this->assertFalse(Str::endsWith('你好', 'a'));
    }

    public function testFinish()
    {
        $this->assertSame('abbc', Str::finish('ab', 'bc'));
        $this->assertSame('abbc', Str::finish('abbcbc', 'bc'));
        $this->assertSame('abcbbc', Str::finish('abcbbcbc', 'bc'));
    }

    public function testIs()
    {
        $this->assertTrue(Str::is('/', '/'));
        $this->assertFalse(Str::is('/', ' /'));
        $this->assertFalse(Str::is('/', '/a'));
        $this->assertTrue(Str::is('foo/*', 'foo/bar/baz'));

        $this->assertTrue(Str::is('*@*', 'App\Class@method'));
        $this->assertTrue(Str::is('*@*', 'app\Class@'));
        $this->assertTrue(Str::is('*@*', '@method'));

        // is case sensitive
        $this->assertFalse(Str::is('*BAZ*', 'foo/bar/baz'));
        $this->assertFalse(Str::is('*FOO*', 'foo/bar/baz'));
        $this->assertFalse(Str::is('A', 'a'));

        $this->assertTrue(Str::is('*/foo', 'blah/baz/foo'));

        // empty patterns
        $this->assertFalse(Str::is(null, 'test'));
    }

    public function testKebab()
    {
        $this->assertSame('laravel-php-framework', Str::kebab('LaravelPhpFramework'));
    }

    public function testLower()
    {
        $this->assertSame('foo bar baz', Str::lower('FOO BAR BAZ'));
        $this->assertSame('foo bar baz', Str::lower('fOo Bar bAz'));
    }

    public function testStart()
    {
        $this->assertSame('/test/string', Str::start('test/string', '/'));
        $this->assertSame('/test/string', Str::start('/test/string', '/'));
        $this->assertSame('/test/string', Str::start('//test/string', '/'));
    }

    public function testUpper()
    {
        $this->assertSame('FOO BAR BAZ', Str::upper('foo bar baz'));
        $this->assertSame('FOO BAR BAZ', Str::upper('foO bAr BaZ'));
    }

    public function testSnake()
    {
        $this->assertSame('laravel_p_h_p_framework', Str::snake('LaravelPHPFramework'));
        $this->assertSame('laravel_php_framework', Str::snake('LaravelPhpFramework'));
        $this->assertSame('laravel php framework', Str::snake('LaravelPhpFramework', ' '));
        $this->assertSame('laravel_php_framework', Str::snake('Laravel Php Framework'));
        $this->assertSame('laravel_php_framework', Str::snake('Laravel    Php      Framework   '));
        $this->assertSame('laravel__php__framework', Str::snake('LaravelPhpFramework', '__'));
        $this->assertSame('laravel_php_framework_', Str::snake('LaravelPhpFramework_', '_'));
        $this->assertSame('laravel_php_framework', Str::snake('laravel php Framework'));
        $this->assertSame('laravel_php_frame_work', Str::snake('laravel php FrameWork'));
        $this->assertSame('foo-bar', Str::snake('foo-bar'));
        $this->assertSame('foo-_bar', Str::snake('Foo-Bar'));
        $this->assertSame('foo__bar', Str::snake('Foo_Bar'));
        $this->assertSame('żółtałódka', Str::snake('ŻółtaŁódka'));
    }

    public function testStartsWith()
    {
        $this->assertTrue(Str::startsWith('jason', 'jas'));
        $this->assertTrue(Str::startsWith('jason', 'jason'));
        $this->assertTrue(Str::startsWith('jason', ['jas']));
        $this->assertTrue(Str::startsWith('jason', ['day', 'jas']));
        $this->assertFalse(Str::startsWith('jason', 'day'));
        $this->assertFalse(Str::startsWith('jason', ['day']));
        $this->assertFalse(Str::startsWith('jason', null));
        $this->assertFalse(Str::startsWith('jason', [null]));
        $this->assertFalse(Str::startsWith('0123', [null]));
        $this->assertTrue(Str::startsWith('0123', 0));
        $this->assertFalse(Str::startsWith('jason', 'J'));
        $this->assertFalse(Str::startsWith('jason', ''));
        $this->assertFalse(Str::startsWith('7', ' 7'));
        $this->assertTrue(Str::startsWith('7a', '7'));
        $this->assertTrue(Str::startsWith('7a', 7));
        $this->assertTrue(Str::startsWith('7.12a', 7.12));
        $this->assertFalse(Str::startsWith('7.12a', 7.13));
        $this->assertTrue(Str::startsWith(7.123, '7'));
        $this->assertTrue(Str::startsWith(7.123, '7.12'));
        $this->assertFalse(Str::startsWith(7.123, '7.13'));
        // Test for multibyte string support
        $this->assertTrue(Str::startsWith('Jönköping', 'Jö'));
        $this->assertTrue(Str::startsWith('Malmö', 'Malmö'));
        $this->assertFalse(Str::startsWith('Jönköping', 'Jonko'));
        $this->assertFalse(Str::startsWith('Malmö', 'Malmo'));
        $this->assertTrue(Str::startsWith('你好', '你'));
        $this->assertFalse(Str::startsWith('你好', '好'));
        $this->assertFalse(Str::startsWith('你好', 'a'));
    }

    public function testStudly()
    {
        $this->assertSame('LaravelPHPFramework', Str::studly('laravel_p_h_p_framework'));
        $this->assertSame('LaravelPhpFramework', Str::studly('laravel_php_framework'));
        $this->assertSame('LaravelPhPFramework', Str::studly('laravel-phP-framework'));
        $this->assertSame('LaravelPhpFramework', Str::studly('laravel  -_-  php   -_-   framework   '));

        $this->assertSame('FooBar', Str::studly('fooBar'));
        $this->assertSame('FooBar', Str::studly('foo_bar'));
        $this->assertSame('FooBar', Str::studly('foo_bar')); // test cache
        $this->assertSame('FooBarBaz', Str::studly('foo-barBaz'));
        $this->assertSame('FooBarBaz', Str::studly('foo-bar_baz'));
    }

    public function testSubstr()
    {
        $this->assertSame('Ё', Str::substr('БГДЖИЛЁ', -1));
        $this->assertSame('ЛЁ', Str::substr('БГДЖИЛЁ', -2));
        $this->assertSame('И', Str::substr('БГДЖИЛЁ', -3, 1));
        $this->assertSame('ДЖИЛ', Str::substr('БГДЖИЛЁ', 2, -1));
        $this->assertEmpty(Str::substr('БГДЖИЛЁ', 4, -4));
        $this->assertSame('ИЛ', Str::substr('БГДЖИЛЁ', -3, -1));
        $this->assertSame('ГДЖИЛЁ', Str::substr('БГДЖИЛЁ', 1));
        $this->assertSame('ГДЖ', Str::substr('БГДЖИЛЁ', 1, 3));
        $this->assertSame('БГДЖ', Str::substr('БГДЖИЛЁ', 0, 4));
        $this->assertSame('Ё', Str::substr('БГДЖИЛЁ', -1, 1));
        $this->assertEmpty(Str::substr('Б', 2));
    }
}
