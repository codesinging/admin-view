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
     * @var string The builder's attribute.
     */
    protected $attributes;

    /**
     * @var string The builder's content.
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
     * @param string $tag
     * @param string $content
     * @param string $attributes
     * @param bool   $closing
     * @param bool   $linebreak
     */
    public function __construct(string $tag = 'div', string $content = '', string $attributes = '', bool $closing = true, bool $linebreak = false)
    {
        $this->tag($tag);
        $this->content($content);
        $this->attribute($attributes);
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
     * Set builder's content.
     *
     * @param string|null $content
     *
     * @return $this
     */
    public function content(string $content = null)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Set builder attributes.
     *
     * @param string|null $attributes
     *
     * @return $this
     */
    public function attribute(string $attributes = null)
    {
        $this->attributes = $attributes;
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
            empty($this->attributes) ? '' : ' ' . $this->attributes,
            $this->closing ? '' : ' /',
            $this->linebreak && !empty($this->content) ? PHP_EOL : '',
            $this->content,
            $this->linebreak && $this->closing ? PHP_EOL : '',
            $this->closing ? '</' . $this->tag . '>' : ''
        );
    }
}