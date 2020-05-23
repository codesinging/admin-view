<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-23 11:22:08
 */

namespace CodeSinging\AdminView\Tests\Foundation;

use CodeSinging\AdminView\Foundation\Content;
use CodeSinging\AdminView\Foundation\Element;
use PHPUnit\Framework\TestCase;

class ElementTest extends TestCase
{
    public function testConstruct()
    {
        self::assertEquals('<div></div>', (new Element('div'))->build());
        self::assertEquals('<div>hello</div>', new Element('div', 'hello'));
    }

    public function testInit()
    {
        self::assertEquals('<div></div>', Element::init());
        self::assertEquals('<div>hello</div>', Element::init('div', 'hello'));
    }

    public function testTag()
    {
        self::assertEquals('<span></span>', Element::init()->tag('span'));
    }

    public function testSet()
    {
        self::assertEquals('<div id="app"></div>', Element::init()->set('id', 'app'));
    }

    public function testContent()
    {
        self::assertEquals('<div>hello</div>', Element::init()->content('hello'));
        self::assertEquals('<div>hello world</div>', Element::init()->content('hello', ' ', 'world'));
    }

    public function testPrependContent()
    {
        self::assertEquals('<div>ab</div>', Element::init()->content('b')->prependContent('a'));
        self::assertEquals('<div>abc</div>', Element::init()->content('c')->prependContent('a', 'b'));
    }

    public function testInterpolationContent()
    {
        self::assertEquals('<div>{{ title }}</div>', Element::init()->interpolationContent('title'));
        self::assertEquals('<div>hello {{ name }}</div>', Element::init()->content('hello ')->interpolationContent('name')->build());
    }

    public function testSlotContentWithString()
    {
        self::assertEquals('<div><template slot="header">title</template></div>', Element::init()->slotContent('header', 'title'));
    }

    public function testSlotContentWithElement()
    {
        self::assertEquals('<div><span slot="header">title</span></div>', Element::init()->slotContent('header', new Element('span', 'title'))->build());
    }

    public function testSlotContentWithClosure()
    {
        $element = Element::init()->slotContent('header', function () {
            return 'title';
        });
        self::assertEquals('<div><template slot="header">title</template></div>', $element->build());

        $element = Element::init()->slotContent('header', function (Content $content) {
            return $content->add('title');
        });
        self::assertEquals('<div><template slot="header">title</template></div>', $element->build());

        $element = Element::init()->slotContent('header', function (Content $content) {
            $content->add('title');
        });
        self::assertEquals('<div><template slot="header">title</template></div>', $element->build());
    }

    public function testClosing()
    {
        self::assertEquals('<div></div>', Element::init());
        self::assertEquals('<input />', Element::init('input')->closing(false));
    }

    public function testLinebreak()
    {
        self::assertEquals('<div>' . PHP_EOL . '</div>', Element::init()->linebreak(true));
        self::assertEquals('<div>' . PHP_EOL . 'title' . PHP_EOL . '</div>', Element::init()->content('title')->linebreak(true));
    }

    public function testCss()
    {
        self::assertEquals('<div class="margin"></div>', Element::init()->css('margin'));
        self::assertEquals('<div class="margin padding"></div>', Element::init()->css('margin')->css('padding'));
    }

    public function testPrependCss()
    {
        self::assertEquals('<div class="margin padding"></div>', Element::init()->css('padding')->prependCss('margin'));
    }

    public function testStyle()
    {
        self::assertEquals('<div style="width:1px;"></div>', Element::init()->style('width:1px'));
        self::assertEquals('<div style="width:1px; height:1px;"></div>', Element::init()->style('width:1px', ['height' => '1px']));
    }

    public function testPrependStyle()
    {
        self::assertEquals('<div style="width:1px; height:1px;"></div>', Element::init()->style(['height' => '1px'])->prependStyle('width:1px'));
    }

    public function testIsEmpty()
    {
        self::assertTrue(Element::init()->isEmpty());
        self::assertTrue(Element::init()->content(null)->isEmpty());
        self::assertFalse(Element::init()->content('')->isEmpty());
        self::assertFalse(Element::init()->content('hello')->isEmpty());
    }

    public function testParent()
    {
        self::assertEquals('<div><span>title</span></div>', Element::init('span', 'title')->parent('div')->build());
    }

    public function testAttributes()
    {
        self::assertEquals('<div :disabled="true"></div>', new AttributeElement());
    }

    public function testInitializeMethod()
    {
        self::assertEquals('<span></span>', new InitializeElement());
    }

    public function testBuildMethod()
    {
        self::assertEquals('<div>HelloWorld</div>', new BuildElement('div', 'World'));
    }
}

class AttributeElement extends Element
{
    protected $attributes = [
        'disabled' => true
    ];
}

class InitializeElement extends Element
{
    protected function __init()
    {
        $this->builder->tag('span');
    }
}

class BuildElement extends Element
{
    protected function __build()
    {
        $this->content->prepend('Hello');
    }
}