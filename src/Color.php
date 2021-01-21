<?php

namespace RyanChandler\Color;

class Color
{
    public int $red;

    public int $green;

    public int $blue;

    public function __construct(int $red = 0, int $green = 0, int $blue = 0)
    {
        $this->red = $red;
        $this->green = $green;
        $this->blue = $blue;
    }

    public function setHex(string $hex): Color
    {
        if ($hex[0] === '#') {  
            $hex = substr($hex, 1);
        }

        if (strlen($hex) > 6) {
            $hex = substr($hex, 0, 6);
        }

        [$r, $g, $b] = str_split($hex, 2);

        $this->red   = hexdec($r);
        $this->green = hexdec($g);
        $this->blue  = hexdec($b);

        return $this;
    }

    public static function random(): Color
    {
        return new static(
            rand(0, 255), rand(0, 255), rand(0, 255)
        );
    }

    public static function hex(string $hex): Color
    {
        return (new static)->setHex($hex);
    }

    public static function new(int $red = 0, int $green = 0, int $blue = 0)
    {
        return new static($red, $green, $blue);
    }

    public static function distanceBetween(Color $start, Color $end)
    {
        return pow($start->red - $end->red, 2) +
            pow($start->green - $end->green, 2) + 
            pow($start->blue - $end->blue, 2);
    }

    public function toArray()
    {
        return [$this->red, $this->green, $this->blue];
    }

    public function toString(bool $hex = false)
    {
        if ($hex) {
            return $this->toHex();
        }
        
        return (string) $this;
    }

    public function toHex(): string
    {
        return '#'.dechex($this->red).dechex($this->green).dechex($this->blue);
    }

    public function __toString()
    {
        return "({$this->red}, {$this->green}, {$this->blue})";
    }
}