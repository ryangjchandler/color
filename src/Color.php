<?php

namespace RyanChandler\Color;

/**
 * A simple Color object for PHP packages and applications.
 * 
 * @category RyanChandler\Color
 * @package  Color
 * @author   Ryan Chandler <support@ryangjchandler.co.uk>
 * @license  MIT <https://mit-license.org>
 * @link     https://github.com/ryangjchandler/color
 */
class Color
{
    /**
     * Colors red value.
     * 
     * @var int Integer between 0 and 255.
     */
    public int $red;

    /**
     * Colors green value.
     * 
     * @var int Integer between 0 and 255.
     */
    public int $green;

    /**
     * Colors blue value.
     * 
     * @var int Integer between 0 and 255.
     */
    public int $blue;

    /**
     * Colors alpha value.
     * 
     * @var float Float between 0.0 and 1.0.
     */
    public float $alpha;

    /**
     * Class constructor.
     *
     * @param int $red   Integer between 0 and 255.
     * @param int $green Integer between 0 and 255.
     * @param int $blue  Integer between 0 and 255.
     */
    public function __construct(int $red = 0, int $green = 0, int $blue = 0, float $alpha = 1.0)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    /**
     * Set color via Hex value.
     *
     * @param string $hex Hex value.
     *
     * @return Color
     */
    public function setHex(string $hex): Color
    {
        if ($hex[0] === '#') {  
            $hex = substr($hex, 1);
        }

        if (strlen($hex) > 6) {
            $hex = substr($hex, 0, 6);
        }

        if (strlen($hex) === 3) {
            [$r, $g, $b] = array_map(fn ($char) => str_pad($char, 2, $char), str_split($hex));
        } else {
            [$r, $g, $b] = str_split($hex, 2);
        }

        $this->red   = hexdec($r);
        $this->green = hexdec($g);
        $this->blue  = hexdec($b);

        return $this;
    }

    /**
     * Get a random color.
     *
     * @return Color
     */
    public static function random(bool $alpha = false): Color
    {
        return new static(
            rand(0, 255), rand(0, 255), rand(0, 255), $alpha ? mt_rand() / mt_getrandmax() : 1.0
        );
    }

    /**
     * Create a new color via Hex value.
     *
     * @param string $hex Hex value.
     * 
     * @return Color
     */
    public static function hex(string $hex): Color
    {
        return (new static)->setHex($hex);
    }

    /**
     * Create a new color via RGB value.
     *
     * @param int $red   Integer between 0 and 255.
     * @param int $green Integer between 0 and 255.
     * @param int $blue  Integer between 0 and 255.
     * 
     * @return Color
     */
    public static function new(int $red = 0, int $green = 0, int $blue = 0, int $alpha = 1.0): Color
    {
        return new static($red, $green, $blue, $alpha);
    }

    /**
     * Get distance between self and another color.
     *
     * @param Color $end Color to end at.
     * 
     * @return int
     */
    public function distanceTo(Color $end): int
    {
        return static::distanceBetween($this, $end);
    }

    /**
     * Get distance between two colors.
     *
     * @param Color $start Color to start at.
     * @param Color $end   Color to end at.
     * 
     * @return int
     */
    public static function distanceBetween(Color $start, Color $end): int
    {
        return pow($start->red - $end->red, 2) +
            pow($start->green - $end->green, 2) + 
            pow($start->blue - $end->blue, 2);
    }

    /**
     * Get array representation of color.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [$this->red, $this->green, $this->blue];
    }

    /**
     * Get string representation of color.
     *
     * @param boolean $hex Get as Hex value (optional).
     * 
     * @return string
     */
    public function toString(bool $hex = false): string
    {
        if ($hex) {
            return $this->toHex();
        }
        
        return (string) $this;
    }

    /**
     * Get string representation of color as Hex value.
     *
     * @return string
     */
    public function toHex(): string
    {
        return '#'.dechex($this->red).dechex($this->green).dechex($this->blue);
    }

    /**
     * Get string representation of color.
     *
     * @return string
     */
    public function __toString()
    {
        return "({$this->red}, {$this->green}, {$this->blue})";
    }
}