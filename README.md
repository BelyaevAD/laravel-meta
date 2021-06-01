# Laravel Meta

[![Latest Version on Packagist](https://img.shields.io/packagist/v/belyaevad/laravel-meta.svg?style=flat-square)](https://packagist.org/packages/belyaevad/laravel-meta)
[![Total Downloads](https://img.shields.io/packagist/dt/belyaevad/laravel-meta.svg?style=flat-square)](https://packagist.org/packages/belyaevad/laravel-meta)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/belyaevad/laravel-meta/master.svg?style=flat-square)](https://travis-ci.org/belyaevad/laravel-meta)

Metadata for your Eloquent model (WordPress analogy).

The idea of creating a package was borrowed from the WordPress CMS, where each entry in the `wp_posts` table can have as many additional fields as you want.

The mechanism for storing and receiving data is implemented on the `morphTo` relation. All meta data is stored in a separate table and connected to your model via a trait.
By default, the metadata is not loaded with the model, but this can be fixed by adding `meta` to the auto-loading relationship:
```php
protected $ with = [
    // ...
    // other relationships
    'meta',
];
```
or load in collection
```php
$postList = Post::where('active', true)->with('meta')->get();
```

Any reading of the meta-data performs a single load of all meta-fields associated with your model, which saves you from many sql queries

If you need reload meta-data – use `$post->metaReLoad()` method.

## Installation

You can install the package via composer:

```bash
composer require belyaevad/laravel-meta
```

### Publish, migrate

By running `php artisan vendor:publish --provider="BelyaevAD\Meta\MetaServiceProvider"` in your project all files for this package will be published. For this package, it's only a migration. Run `php artisan migrate` to migrate the table. There will now be a table named `metas` in your database.

## Usage

You can easily add Meta to an Eloquent model. Just add this to your model:

```php
use BelyaevAD\Meta\Metable;

class Post extends Model
{
    use Metable;
}
```

Then you can get, add, update and delete meta to the you model.

```php
$post = Post::find(1);

$post->addMeta('someKey', 'someValue');

$post->getMeta('someKey');

$post->getMetaValue('someKey');

$post->hasMeta('someKey');

$post->updateMeta('someKey', 'anotherValue');

$post->addOrUpdateMeta('someKey', 'someValue');

$post->deleteMeta('someKey');

$post->getAllMeta();

$post->deleteAllMeta();

$post->metaReLoad();
```

## Testing

```bash
$ composer test
```

## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/belyaevad/laravel-meta/graphs/contributors) :)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
