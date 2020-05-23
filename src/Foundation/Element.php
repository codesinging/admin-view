<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-23 07:41:11
 */

namespace CodeSinging\AdminView\Foundation;

use Closure;
use CodeSinging\AdminView\Support\Repository;
use function Sodium\add;

class Element extends Buildable
{
    /**
     * @var Builder The element's Builder instance.
     */
    public $builder;

    /**
     * @var Attribute The element's Attribute instance.
     */
    public $attribute;

    /**
     * @var array The element's initial attributes.
     */
    protected $attributes = [];

    /**
     * @var Css The element's Css instance.
     */
    public $css;

    /**
     * @var Style The element's Style instance.
     */
    public $style;

    /**
     * @var Content The element's Content instance.
     */
    public $content;

    /**
     * @var Element The element's parent element.
     */
    protected $parent;

    /**
     * @var Repository The element's configuration.
     */
    protected $config;

    /**
     * Element constructor.
     *
     * @param string                              $tag
     * @param null|string|array|Content|Buildable $content
     * @param array|null                          $attributes
     * @param bool                                $closing
     * @param bool                                $linebreak
     */
    public function __construct(string $tag = 'div', $content = null, array $attributes = null, bool $closing = true, bool $linebreak = false)
    {
        $this->builder = new Builder($tag);
        $this->content = new Content($content);
        $this->attribute = new Attribute($this->attributes, $attributes);
        $this->builder->closing($closing);
        $this->builder->linebreak($linebreak);

        $this->css = new Css();
        $this->style = new Style();
        $this->config = new Repository();

        $this->__init();
    }

    /**
     * Initialize the element.
     *
     * @param string     $tag
     * @param null       $content
     * @param array|null $attributes
     * @param bool       $closing
     * @param bool       $linebreak
     *
     * @return $this
     */
    public static function init(string $tag = 'div', $content = null, array $attributes = null, bool $closing = true, bool $linebreak = false)
    {
        return new static($tag, $content, $attributes, $closing, $linebreak);
    }

    /**
     * Set element's tag.
     *
     * @param string $tag
     *
     * @return $this
     */
    public function tag(string $tag)
    {
        $this->builder->tag($tag);
        return $this;
    }

    /**
     * Set element's attributes.
     *
     * @param string|array $name
     * @param mixed        $value
     * @param mixed        $default
     *
     * @return $this
     */
    public function set($name, $value = null, $default = null)
    {
        $this->attribute->set($name, $value, $default);
        return $this;
    }

    /**
     * Add contents to the element's content flow.
     *
     * @param string|array|Buildable|Closure ...$contents
     *
     * @return $this
     */
    public function content(...$contents)
    {
        $this->content->add(...$contents);
        return $this;
    }

    /**
     * Prepend contents to the beginning of the element's content flow.
     *
     * @param string|array|Buildable|Closure ...$contents
     *
     * @return $this
     */
    public function prependContent(...$contents)
    {
        $this->content->prepend(...$contents);
        return $this;
    }

    /**
     * Add a interpolation content to the element's content flow.
     *
     * @param string $content
     *
     * @return $this
     */
    public function interpolationContent(string $content)
    {
        $this->content(sprintf('{{ %s }}', $content));
        return $this;
    }

    /**
     * Add a named slot content to the element's content flow.
     *
     * @param string                       $name
     * @param string|array|Element|Closure $content
     *
     * @return $this
     */
    public function slotContent(string $name, $content)
    {
        if (is_string($content)) {
            $content = new self('template', $content, ['slot' => $name]);
        } elseif ($content instanceof self) {
            $content->set('slot', $name);
        } elseif ($content instanceof Closure) {
            $instance = new Content();
            $content = call_user_func($content, $instance) ?? $instance;
            $content = new self('template', $content, ['slot' => $name]);
        }
        $this->content($content);

        return $this;
    }

    /**
     * Set builder's closing attribute.
     *
     * @param bool $closing
     *
     * @return $this
     */
    public function closing(bool $closing = true)
    {
        $this->builder->closing($closing);
        return $this;
    }

    /**
     * Set builder's linebreak attribute.
     *
     * @param bool $linebreak
     *
     * @return $this
     */
    public function linebreak(bool $linebreak = true)
    {
        $this->builder->linebreak($linebreak);
        return $this;
    }

    /**
     * Set element's css classes.
     *
     * @param string|array|Css|Closure ...$classes
     *
     * @return $this
     */
    public function css(...$classes)
    {
        $this->css->add(...$classes);
        return $this;
    }

    /**
     * Prepend css to the beginning of the css items.
     *
     * @param string|array|Css|Closure ...$classes
     *
     * @return $this
     */
    public function prependCss(...$classes)
    {
        $this->css->prepend(...$classes);
        return $this;
    }

    /**
     * Add element's styles.
     *
     * @param string|array|Style|Closure ...$styles
     *
     * @return $this
     */
    public function style(...$styles)
    {
        $this->style->add(...$styles);
        return $this;
    }

    /**
     * Prepend styles to the beginning of the style items.
     *
     * @param string|array|Style|Closure ...$styles
     *
     * @return $this
     */
    public function prependStyle(...$styles)
    {
        $this->style->prepend(...$styles);
        return $this;
    }

    /**
     * Determine if the element content is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->content->isEmpty();
    }

    /**
     * Set the element's parent element.
     *
     * @param string $tag
     * @param array  $attributes
     * @param bool   $linebreak
     *
     * @return $this
     */
    public function parent($tag = 'div', array $attributes = [], bool $linebreak = false)
    {
        if ($tag instanceof Closure) {
            $parent = new self();
            $this->parent = call_user_func($tag, $parent) ?? $parent;
        } elseif ($tag instanceof self) {
            $this->parent = $tag;
        } elseif (is_string($tag)) {
            $this->parent = new self($tag, null, $attributes, true, $linebreak);
        }
        return $this;
    }

    /**
     * Do something after the element's initialization.
     */
    protected function __init()
    {
        // Rewrite the method to do something after the constructor.
    }

    /**
     * Do something after the element's building.
     */
    protected function __build()
    {
        // Rewrite the method to do something before the building.
    }

    /**
     * @inheritDoc
     */
    public function build()
    {
        $this->__build();

        $this->css->isEmpty() or $this->attribute->set('class', $this->css->build());
        $this->style->isEmpty() or $this->attribute->set('style', $this->style->build());

        $this->builder->content($this->content->build());
        $this->builder->attribute($this->attribute->build());
        $element = $this->builder->build();

        if ($this->parent instanceof self) {
            return $this->parent->content($element)->build();
        }

        return $element;
    }
}