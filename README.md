# Convenient immutability for (some) PHP objects

**Warning: I didn't use this library "in the wild" - please let me know if it works in your situation**

[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-coveralls]][link-coveralls]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)

## Installation

Just run:

    composer require matthiasnoback/convenient-immutability

## Introduction

I've often encountered the following situation (in particular when working with [command objects](http://php-and-symfony.matthiasnoback.nl/2015/01/a-wave-of-command-buses/)).

1. I start with a simple object (in fact, a DTO), with just some public properties.
2. The Symfony Form component copies some values into the object's properties.
3. I copy some extra data into the object (like a generated UUID).
4. I then use that object as a command or query message, handing it over to some inner layer of my application.

In other words, I have a class that looks like this:

```php
class OrderSeats
{
    public $id;
    public $userId;
    public $seatNumbers = [];
}
```

And use it like this:

```php
$form = $this->factory->create(OrderSeatsFormType::class);
$form->submit($request);
$command = $form->getData();
$command->id = Uuid::uuid4();

$commandBus->handle($command);
```

Then **I want it to be impossible to change any field on the (command) object**, making it effectively *immutable*.

The `ConvenientImmutability\Immutable` trait solves this problem. When your class uses this trait, it:

- Allows form components and the likes to put anything in your object in any particular order they like.
- Allows you to get the data from it by simply accessing its (public) variables.
- Doesn't allow anyone to overwrite previously set data.

## Why would you do this?

- To feel less insecure about using public properties for your desirably immutable objects.
- To prevent accidental writes to objects you assumed were immutable.

## What's the problem with this approach?

- Your objects may be immutable...
- but they can still exist in an inconsistent state.

Is this bad? I don't think so. As long as you validate the objects (e.g. using the Symfony Validator) and then throw them into your domain layer, which contains the actual safeguards against inconsistent state.

(You can also just use public properties and treat them as "set once, never again" in other parts of your application.)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/matthiasnoback/convenient-immutability.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-coveralls]: https://img.shields.io/coveralls/matthiasnoback/convenient-immutability.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/matthiasnoback/convenient-immutability.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/matthiasnoback/convenient-immutability.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/matthiasnoback/convenient-immutability
[link-coveralls]: https://coveralls.io/github/matthiasnoback/convenient-immutability
[link-travis]: https://travis-ci.org/matthiasnoback/convenient-immutability
[link-downloads]: https://packagist.org/packages/matthiasnoback/convenient-immutability
[link-author]: https://github.com/matthiasnoback
[link-contributors]: ../../contributors
