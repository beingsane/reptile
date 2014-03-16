Reptile
=======

Reptile is a package to add a nice, uniform and simple way to create APIs with Laravel. Includes API credential
authorisation, token based user authentication, easy access to pertinent request data, customisable functionality
and awesome responses.

Installation
-------

To install, you'll need a Laravel installation and composer.

    "require": {
        "ollieread/reptile": "dev"
    }

Now you'll need to add the provider to the list of providers in `app/config/app.php`.

    "Ollieread\Reptile\ReptileServerProvider"

Then you'll want to add the Facade to the list of Facades.

    "Reptile"   => "Ollieread\Reptile\Facades\Reptile"

If you've manually downloaded this package, you'll want to run the following command in the root directory of your
laravel installation.

    php artisan config:publish ollieread/reptile

Configuration
------

There are two configuration files for this package, `response` and `auth`.

### Response

This configuration file basically maps nice little handy names to exception codes and HTTP status code. This allows implementations
to react differently to each type of error.

### Auth

For now, this config has one option, the `model` option. This is the model to be used when authorising the credentials
and grabbing the application. This class must implement `Ollieread\Reptile\ApplicationProviderInterface`. Any other options
are simply placeholders for future functionality.

Usage
------

This package is very simple to use but requires some alterations to the way you'll be familiar with working, when it comes to
Laravel.

### Authorisation

Authorisation is not automatic, but you can attach the authorisation process to your routes using the filter class
`Ollieread\Reptile\Filters\Authorisation`. This will throw an exception if authorisation fails, or continue routing
with populated application data.

To get the currently authorised application use.

    $application = Reptile::auth()->application();

To check whether or not an application is currently authorised, use.

    Reptile::auth()->check();

The authorisation process also includes signature matching, which is an SHA1 HMAC, created from the available data.

### Signature

To specify how the signature is built, you can use the `Reptile::signature()` method in your `app/start/global.php`.

Here is an example.

    Reptile::signature(function($components) {

        return $components['verb'] . "\n" . $components['url'] . "\n" . $components['query'] . "\n" . $components['body'];

    });

The closure will have an array containing, the HTTP verb, the URL, the query string and the json encoded body of the current request.
As you can see from this example, we utilise all of them, and separate them with a newline. You can also pull in your own
data here but this method suffices for now.

### Arguments & Queries

You'll be familiar with use the `Input::get()` and its sibling methods to obtain data submitted during the request. With
Reptile, we replace this piece of functionality and use `Reptile::request()->argument('username')` or
`Reptile::request()->query('page')`. The reason we do this, is we're being strict on how data is passed to our API. The argument
method allows us to only use the JSON encoded body of a request, and the query method makes sure we're pulling directly
from a query parameter.

To return a selection of these, simply pass an array of keys into either of these methods. Each of these methods also has a second
parameter allowing you to specify whether or not the argument is required. `Reptile::request()->argument('username', true)` will throw
an exceptions if the username argument was submitted as part of the JSON body, and will return an error response, halting execution.

If you wish to get all supplied arguments, you can use `Reptile::request()->arguments()`, and if you wish to get all query
parameters, you can just use `Reptile::request()->query()`.

### Includes

If you wish to provide chaining functionality to your users, you can use the includes query parameter. This is a comma
delimited list of items to include. You can grab these by using `Reptile::request()->includes()`.

If you wish to check that a certain inclusion has been requested, you can use `Reptile::request()->shouldInclude('include')`.

### Responses

Implementation
------

Known Bugs
------

Todo
------

 - Complete documenation.
