<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-21 10:37:06
 */

namespace CodeSinging\AdminView\Foundation;

abstract class Buildable
{
    /**
     * Build content as a string of the object.
     * @return string
     */
    abstract public function build();

    /**
     * Get the content as a string of the object.
     * @return string
     */
    public function __toString()
    {
        return $this->build();
    }
}