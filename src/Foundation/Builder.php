<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-21 11:22:59
 */

namespace CodeSinging\AdminView\Foundation;

use Closure;

class Builder extends Buildable
{
    /**
     * @var string The builder tag.
     */
    protected $tag = '';

    /**
     * @var Attribute The builder's Attribute instance.
     */
    protected $attribute;

    /**
     * @var Content The builder's Content instance.
     */
    protected $content;

    /**
     * @var bool If the builder has a closing tag.
     */
    protected $closing = true;

    /**
     * @var bool If the builder has linebreak between the opening tag, content and the closing tag.
     */
    protected $linebreak = false;

    /**
     * @var int The builder's index.
     */
    protected static $buildIndex = 0;

    /**
     * Builder constructor.
     *
     * @param string                 $tag
     * @param string|Builder|Closure $content
     * @param array                  $attributes
     * @param bool                   $closing
     * @param bool                   $linebreak
     */
    public function __construct(string $tag = 'div', $content = null, array $attributes = [], bool $closing = true, bool $linebreak = false)
    {
        $this->tag($tag);
        $this->content = new Content($content);
        $this->attribute = new Attribute($attributes);
        $this->closing($closing);
        $this->linebreak($linebreak);

        self::$buildIndex++;
    }

    /**
     * Set builder tag.
     *
     * @param string $tag
     *
     * @return $this
     */
    public function tag(string $tag)
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * Set builder attributes.
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
     * Set builder's closing attribute.
     *
     * @param bool $closing
     *
     * @return $this
     */
    public function closing(bool $closing = true)
    {
        $this->closing = $closing;
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
        $this->linebreak = $linebreak;
        return $this;
    }

    /**
     * Get the builder's build index.
     *
     * @return int
     */
    public function buildIndex()
    {
        return self::$buildIndex;
    }

    /**
     * Get the buildId with prefix or suffix.
     *
     * @param string|null $prefix
     * @param string|null $suffix
     *
     * @return string
     */
    public function buildId(string $prefix = null, string $suffix = null)
    {
        $buildId = (string)self::$buildIndex;
        is_null($prefix) or $buildId = $prefix . '_' . $buildId;
        is_null($suffix) or $buildId = $buildId . '_' . $suffix;

        return $buildId;
    }

    /**
     * @inheritDoc
     */
    public function build()
    {
        return sprintf(
            '<%s%s%s>%s%s%s%s',
            $this->tag,
            $this->attribute->isEmpty() ? '' : ' ' . $this->attribute->build(),
            $this->closing ? '' : ' /',
            $this->linebreak && !$this->content->isEmpty() ? PHP_EOL : '',
            $this->content->build(),
            $this->linebreak && $this->closing ? PHP_EOL : '',
            $this->closing ? '</' . $this->tag . '>' : ''
        );
    }
}