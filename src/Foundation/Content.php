<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-21 11:29:47
 */

namespace CodeSinging\AdminView\Foundation;

use Closure;

class Content extends Buildable
{
    /**
     * @var array All of the content items.
     */
    protected $items = [];

    /**
     * @var string The glue to implode the content items.
     */
    protected $glue = '';

    /**
     * Content constructor.
     *
     * @param string|Buildable|Closure ...$contents
     */
    public function __construct(...$contents)
    {
        $this->add(...$contents);
    }

    /**
     * Parse the content to a string.
     *
     * @param string|Buildable|Closure $content
     *
     * @return string
     */
    protected function parse($content)
    {
        if (is_null($content)) {
            return null;
        }

        if (empty($content)) {
            return '';
        }

        if ($content instanceof Closure) {
            $self = new self();
            $content = call_user_func($content, $self) ?? $self;
        }

        return (string)$content;
    }

    /**
     * Add contents to the content flow.
     *
     * @param string|Buildable|Closure ...$contents
     *
     * @return $this
     */
    public function add(...$contents)
    {
        $this->items = array_merge($this->items, $contents);
        return $this;
    }

    /**
     * Prepend contents to the beginning of the content flow.
     *
     * @param string|Buildable|Closure ...$contents
     *
     * @return $this
     */
    public function prepend(...$contents)
    {
        $this->items = array_merge($contents, $this->items);
        return $this;
    }

    /**
     * Add a content item which is a text interpolation.
     *
     * @param string $content
     *
     * @return $this
     */
    public function interpolation(string $content)
    {
        $this->add(sprintf('{{ %s }}', $content));
        return $this;
    }

    /**
     * Add a blank content item.
     *
     * @return $this
     */
    public function addBlank()
    {
        $this->add('');
        return $this;
    }

    /**
     * Remove all content items.
     *
     * @return $this
     */
    public function clear()
    {
        $this->items = [];
        return $this;
    }

    /**
     * Determine if the content is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Set glue of the content items.
     *
     * @param string|int $glue
     *
     * @return $this
     */
    public function glue($glue = PHP_EOL)
    {
        if (is_int($glue)) {
            $glue = str_repeat(PHP_EOL, $glue);
        }
        $this->glue = $glue;
        return $this;
    }

    /**
     * Get all the content items.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function build()
    {
        $array = [];
        foreach ($this->items as $item) {
            $item = $this->parse($item);
            is_null($item) or $array[] = $item;
        }
        return implode($this->glue, $array);
    }
}