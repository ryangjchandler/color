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
     * Converts an RGB color value to HSL. Conversion formula
     * adapted from http://en.wikipedia.org/wiki/HSL_color_space.
     * Assumes r, g, and b are contained in the set [0, 255] and
     * returns h, s, and l in the set [0, 1].
     *
     * @param   Number  r       The red color value
     * @param   Number  g       The green color value
     * @param   Number  b       The blue color value
     * @return  Array           The HSL representation
     */
    // function rgbToHsl(r, g, b){
    //     r /= 255, g /= 255, b /= 255;
    //     var max = Math.max(r, g, b), min = Math.min(r, g, b);
    //     var h, s, l = (max + min) / 2;

    //     if(max == min){
    //         h = s = 0; // achromatic
    //     }else{
    //         var d = max - min;
    //         s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
    //         switch(max){
    //             case r: h = (g - b) / d + (g < b ? 6 : 0); break;
    //             case g: h = (b - r) / d + 2; break;
    //             case b: h = (r - g) / d + 4; break;
    //         }
    //         h /= 6;
    //     }

    //     return [h, s, l];
    // }

    /**
     * Converts an HSL color value to RGB. Conversion formula
     * adapted from http://en.wikipedia.org/wiki/HSL_color_space.
     * Assumes h, s, and l are contained in the set [0, 1] and
     * returns r, g, and b in the set [0, 255].
     *
     * @param   Number  h       The hue
     * @param   Number  s       The saturation
     * @param   Number  l       The lightness
     * @return  Array           The RGB representation
     */
    
    /**
     * Set color via HSL value.
     *
     * Reference for Colorspace Conversion Algorithm
     * https://www.niwa.nu/2013/05/math-behind-colorspace-conversions-rgb-hsl/
     *
     * @param string $hex Hex value.
     *
     * @return Color
     */
    public function setHsl(int $h, int $s, int $l, float $alpha = 1.0): Color
    {
        $h = $h/360;
        $s = $s/100;
        $l = $l/100;

        // Check for monochrome
        if($s == 0){
            $r = $g = $b = $l * 255;
        }else{
            $a = $l < 0.5 ? $l * (1 + $s) : $l + $s - ($l * $s);
            $b = (2 * $l) - $a;
            
            $r = $this->hueToRgbValue($h + 1/3, $a, $b) * 255;
            $g = $this->hueToRgbValue($h, $a, $b) * 255;
            $b = $this->hueToRgbValue($h - 1/3, $a, $b) * 255;
        }

        $this->red   = round($r);
        $this->green = round($g);
        $this->blue  = round($b);
        $this->alpha = $alpha;

        return $this;
    }

    protected function hueToRgbValue($h, $a, $b)
    {
        // Ensure $h is between 0 and 1
        if($h < 0){
            $h += 1;
        }else if($h > 1){
            $h -= 1;
        }

        // Test for correct formula
        if(($h * 6) < 1){
            return $b + ($a - $b) * 6 * $h;
        }
        if(($h * 2) < 1){
            return $a;
        }
        if(($h * 3) < 2){
            return $b + ($a - $b) * (2/3 - $h) * 6;
        }

        return $b;
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
     * Create a new color via Hsl value.
     *
     * @param int $h Hue value.
     * @param int $s Saturation value.
     * @param int $l Luminance value.
     * 
     * @return Color
     */
    public static function hsl(int $h, int $s, int $l, float $alpha = 1.0): Color
    {
        return (new static)->setHsl($h, $s, $l, $alpha);
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
        
        return (object) ['ratio' => $ratio, 'score' => $score];
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
