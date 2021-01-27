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
    /**
     * Class constructor.
     *
     * @param int   $red   Integer between 0 and 255.
     * @param int   $green Integer between 0 and 255.
     * @param int   $blue  Integer between 0 and 255.
     * @param float $alpha Float between 0 and 1.0.
     */
    public function __construct(int $red = 0, int $green = 0, int $blue = 0, float $alpha = 1.0)
    {
        $this->red = max(0, min(255, $red));
        $this->green = max(0, min(255, $green));
        $this->blue = max(0, min(255, $blue));
        $this->alpha = max(0, min(1.0, $alpha));
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

        if (strlen($hex) === 8) {
            $alpha = substr($hex, -2);

            if ($alpha) {
                $this->alpha = round(hexdec($alpha) / 255, 2);
            }

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
     * @param int   $red   Integer between 0 and 255.
     * @param int   $green Integer between 0 and 255.
     * @param int   $blue  Integer between 0 and 255.
     * @param float $alpha Float between 0 and 1.0.
     * 
     * @return Color
     */
    public static function new(int $red = 0, int $green = 0, int $blue = 0, float $alpha = 1.0): Color
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
        return pow($start->alpha - $end->alpha, 2) +
            pow($start->red - $end->red, 2) +
            pow($start->green - $end->green, 2) + 
            pow($start->blue - $end->blue, 2);
    }

    /**
     * Determine whether this color is identical to another.
     *
     * @param Color $color
     * @return bool
     */
    public function equals(Color $color): bool
    {
        return $this->red === $color->red
            && $this->green === $color->green
            && $this->blue === $color->blue
            && $this->alpha === $color->alpha;
    }

    /**
     * Determine whether two colors are identical.
     *
     * @param Color $first
     * @param Color $second
     * @return bool
     */
    public static function bothEqual(Color $first, Color $second): bool
    {
        return $first->equals($second);
    }

    /**
     * Calculate the relative luminance of the color
     *
     * Using the formulas found in the WCAG Def:
     * https://www.w3.org/TR/2008/REC-WCAG20-20081211/#relativeluminancedef
     *
     * Updated sRGB threshold as per:
     * https://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color/17343790#comment99921012_17343790
     * 
     * @return float
     */
    public function relativeLuminance(): float
    {
        $values = array_combine(['r', 'b', 'g'], $this->toArray());

        foreach ($values as $key => $value) {
            $value = $value / 255;
            
            if($value <= 0.04045){
                $values[$key] = $value / 12.92;
                
                continue;
            }

            $values[$key] = pow(($value + 0.055) / 1.055, 2.4);
        }
        
        return 0.2126 * $values['r'] + 
            0.7152 * $values['b'] + 
            0.0722 * $values['g'];
    }

    /**
     * Determine the contrast ratio score for the two colors.
     *
     * @param Color $first
     * @param Color $second
     * 
     * @return object
     */
    public static function contrastScore(Color $first, Color $second): object
    {
        $luma1 = $first->relativeLuminance() + 0.05;
        $luma2 = $second->relativeLuminance() + 0.05;
        
        $ratio = round(max($luma1, $luma2) / min($luma1, $luma2), 2);

        if ($ratio < 2.9) {
            $score = 'Fail';
        } elseif ($ratio < 4.5) {
            $score = 'AA Large';
        } elseif ($ratio < 7) {
            $score = 'AA';
        } else {
            $score = 'AAA';
        }
        
        return (object) compact('ratio', 'score');
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
        $hex = '#'.dechex($this->red).dechex($this->green).dechex($this->blue);

        if ($this->alpha !== 1.0) {
            return $hex . dechex(round($this->alpha * 255));
        }

        return $hex;
    }

    /**
     * Get string representation of color.
     *
     * @return string
     */
    public function __toString()
    {
        if ($this->alpha !== 1.0) {
            return "({$this->red}, {$this->green}, {$this->blue}, {$this->alpha})";
        }

        return "({$this->red}, {$this->green}, {$this->blue})";
    }
}