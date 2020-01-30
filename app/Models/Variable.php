<?php

namespace App\Models;

/**
 * Class Variable
 * @package App\Models
 *
 * @property string $name
 * @property mixed $content
 * @property string|callable|null $getter
 * @property string|callable|null $setter
 */
class Variable extends Model
{
    /**
     * @param $content
     * @return mixed
     */
    public function getContentAttribute($content)
    {
        if ($this->getter) {
            $method = $this->getter;
            return $method($content);
        }

        return $content;
    }

    /**
     * @param $content
     */
    public function setContentAttribute($content)
    {
        if ($this->setter) {
            $method = $this->setter;
            $content = $method($content);
        }

        $this->attributes['content'] = $content;
    }
}
