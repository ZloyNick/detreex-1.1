<?php

declare(strict_types=1);

namespace GameBase\holders\statically;

use ArrayAccess;
use Exception;
use Countable;

use function unserialize;
use function json_decode;
use function yaml_parse;
use function preg_replace;
use function count;
use function strtolower;
use function explode;
use function is_array;
use function file_get_contents;

class Config implements ArrayAccess, Countable
{

    const YAML = 0;
    const JSON = 1;
    const DAT = 2;

    private static
        $data = [],
        $file = '',
        $type = 0,
        $canChangeEnum = false;


    /**
     * From /your/path/to/config.json
     * IMPORTANT! Yaml is slower, than Json
     * Other providers not recommended
     *
     * @param array $data
     * @return Config
     */
    public static function init(array $data): Config
    {
        $originalData = &static::$data;
        foreach ($data as $lang => $dat) {
            foreach ($dat as $key => $value) {
                if (is_array($value)) {
                    $originalData[$key] = Nested::push($value);
                } else {
                    $originalData[$key] = $value;
                }
            }
        }
        return new static;
    }

    public function offsetExists($offset)
    {
        return isset(static::$data[$offset]);
    }

    public function offsetGet($offset)
    {
        return
            $this->offsetExists($offset) ? static::$data[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (!static::$canChangeEnum) {
            if ($this->offsetExists($offset)) {
                if ($this->offsetGet($offset) instanceof Nested) {
                    if (is_array($value)) {
                        return (static::$data[$offset] = Nested::push($value));
                    } else {
                        return false;
                    }
                } else {
                    if (is_array($value)) {
                        return false;
                    } else {
                        return (static::$data[$offset] = $value);
                    }
                }
            } else {
                return (static::$data[$offset] = $value);
            }
        } else {
            return (static::$data[$offset] = $value);
        }
    }

    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset))
            unset(static::$data[$offset]);
    }

    /**
     * Makes Nested type changeable
     * If false, you can't change array type to other
     * else
     * you can change all types to others
     *
     * @param bool $value
     */
    public function setTypeChangeable(bool $value = true): void
    {
        static::$canChangeEnum = $value;
    }

    public function compareData(): array
    {
        $data = [];
        foreach (static::$data as $k => $v)
        {
            if($v instanceof Nested)
                $data[$k] = $v->compareData();
            else
                $data[$k] = $v;
        }
        return $data;
    }

    /**
     * @param string $file
     * @return Config
     * @throws Exception
     */
    public static function up(string $file) : Config
    {
        //TODO: Other providers?
        $parts = explode('.', $file);
        static::$file = $file;

        $provider
            = strtolower(
                $parts[count($parts) - 1]
            );

        $content = file_get_contents($file);
        switch ($provider)
        {
            case "yaml":
            case "yml":
                static::$type = 0;
                $data = yaml_parse(
                    preg_replace(
                        "#^([ ]*)([a-zA-Z_]{1}[ ]*)\\:$#m", "$1\"$2\":",
                        $content
                    )
                );
                break;

            case "json":
            case "jsn":
            case "j":
                $data = json_decode(
                    $content,
                    true,
                    JSON_BIGINT_AS_STRING
                    |
                    JSON_INVALID_UTF8_IGNORE
                    |
                    JSON_UNESCAPED_UNICODE
                );
                break;

            case "dat":
            case "u":
            case "hash":
            case "ser":
            case "serialized":
                $data = unserialize($content);
                break;
            default:
                throw new Exception();
                break;
        }
        return static::init($data);
    }

    public function __destruct()
    {
        // TODO: Make save
    }

    public function count()
    {
        return count(static::$data);
    }

    public function countAll() : int
    {
        $c = 0;
        foreach (static::$data as $k => $v)
        {
            $c++;
            if($v instanceof Nested)
            {
                $c += $v->countAll();
            }
        }
        return $c;
    }
}