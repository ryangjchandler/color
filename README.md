# Color

A simple Color object for PHP packages and applications. 🎨

## Installation

This package can be installed via Composer:

```bash
composer require ryangjchandler/color
```

## Usage

This package provides a single `RyanChandler\Color\Color` object.

### Creating a color

To create a color, instantiate a new `RyanChandler\Color\Color` object:

```php
use RyanChandler\Color\Color;

$color = new Color(255, 255, 255);
```

The constructor accepts three _optional_ arguments. The red, green and blue decimal representations of your color.

If you prefer using static constructors you can use the `Color::new()` method, à la Rust.

```php
$color = Color::new(255, 255, 255);
```

### Creating a color from a hex

If you wish to create a color using the hex representation, you can use the `Color::hex()` method.

```php
$color = Color::hex('#ffffff');
```

This will convert your hex representation into the RGB equivalent.

The `#` is not compulsory. It will only be removed _if_ the string provided starts with it.

> It's worth noting that any alpha values specified on the hex value will be stripped since the string is clamped to a length of 6. This is something that might be supported in a future version.

### Generating a random color

You can generate a random color using the `Color::random()` method.

```php
$random = Color::random();
```

### Accessing the red, green and blue values

Each color value can be accessed using a public property on the `Color` object.

```php
$color = Color::new(255, 255, 255);

$color->red; // 255
$color->green; // 255
$color->blue; // 255
```

### Getting the hex representation

If you wish to get the hex equivalent of your color, you can use the `Color::toHex()` method.

```php
Color::new(255, 255, 255)->toHex(); // #ffffff
```

### Getting the string representation

By default, the `Color::toString()` method returns a tuple-like string.

```php
Color::new(255, 255, 255)->toString(); // "(255, 255, 255)"
```

You can also use the `Color::toString()` method to retrieve the hex representation.

```php
Color::new(255, 255, 255)->toString(); // #ffffff
```

Or use PHP's typecasting to get a string instead.

```php
(string) Color::new(255, 255, 255); // "(255, 255, 255)"
```

### Getting an array

You can use the `Color::toArray()` method to get all three color values in an ordered list.

```php
Color::new(255, 255, 255)->toArray(); // [255, 255, 255]
```

The array does not use string-keys, so you can unpack the array into separate variables too.

```php
[$r, $g, $b] = Color::new(255, 255, 255)->toArray();
```

### Finding the distance between 2 colors

If you need to calculate the distance between 2 colors, you can use the `Color::distanceBetween()` method.

```php
$one = Color::new(0, 0, 220);
$two = Color::new(255, 0, 220);

Color::distanceBetween($one, $two); // 65_025
```

The return value is the distance between the 2 colors, squared. Generally speaking, this number will be more
readable and recognisable than the radical (result of the square root).

#### Using an existing `Color`

If you already have a `Color` object, you can use the `Color::distanceTo()` method as well.

```php
$one = Color::new(0, 0, 220);
$two = Color::new(255, 0, 220);

$one->distanceTo($two); // 65_025
```

> It is worth noting that the distance calculations and `Color` objects **do not** support alpha-based colors. This is potentially something that will be added in the future.