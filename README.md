An basic, thinly object-oriented wrapper for deviantARTs oAuth2 API
===================================================================

This library can be used to access []deviantARTs official oAuth2 API](https://www.deviantart.com/developers/),
abstracting away authorization, request building and response parsing. Well, a little bit, anyway...

Requirements
------------

 * PHP 7.0+
 * [seinopsys/oauth2-deviantart](https://packagist.org/packages/seinopsys/oauth2-deviantart) 1.0+

Installation
------------

The Library can be included in the usual way with composer:

```sh
    composer require benkle/deviantart
```

Usage
-----

First you need to create an instance of Seinopsys' oAuth provider for the library to use:
```php
use \SeinopSys\OAuth2\Client\Provider\DeviantArtProvider;

$provider = new DeviantArtProvider(
    [
        'clientId'     => 'YOUR ID',
        'clientSecret' => 'YOUR SECRET',
        'redirectUri'  => 'YOUR REDIRECT URL',
    ]
);
```

Next, you need to procure a stored token.
```php
// Must return an instance of \League\OAuth2\Client\Token\AccessToken or null
$accessToken = PROCURE_ACCESS_TOKEN();
```

Now you can wrap the `Api` class around them.
```php
use \Benkle\Deviantart\Api;

$api = new Api($provider, $accessToken);
```

And finally, Authorization!
```php
use \Benkle\Deviantart\Exceptions\UnauthorizedException;

try {
    $scopes = [Api::SCOPE_BROWSE];
    $api->authorize($scopes);
    // authorize() will refresh the token, if necessary, so you might want to write it back to storage.
    // You can access it via $api->getAccessToken()
} catch (UnauthorizedException $e) {
    // Here you can handle the initial user input for authorization.
    // The exception message has been replaced with the URL you need to call, so you can get it easily like this:
    $url = "$e";
}
```

In case you are in the handler called by initial authorization, you can hand the auth code as a second parameter to `authorize`:

```php
    $api->authorize($scopes, $authCode);
```

Once you've done all that, you can use the API, e.g. like this:
```php
try {
    /** @var \stdClass $result */
    $result = $api->browse()->getNewest();
} catch (ApiException $e) {
    // Handle API exception
}
```
The endpoints are grouped into sub-object in accordance with the
documentation and will return instances of `\stdClass`.

The only exception of this rule is the sta.sh submit, which returns the `ApiRequest` used so adding parts is easier:
```php
use \Benkle\Deviantart\ApiRequestPart;

try {
    /** @var \stdClass $result */
        $result = $api
            ->stash()
            ->submit('Test', 'A sta.sh test', null, null,true)
            ->addPart(ApiRequestPart::from('test', fopen('/home/bizzl/test.txt', 'r'), 'test.txt'))
            ->send();
} catch (ApiException $e) {
    // Handle API exception
}
```

FAQ
---

 * **Where are the _curated_ endpoints?** They are deprecated and you should not use them.
 * **Why do so many endpoints have an `$includeMature` parameter?** They are in the Docs.
   I know that they seem senseless and probably won't work, but they also don't really hurt.
 * **All but one endpoint return `\stdClass`. Why?** It's easier to type hint, and I don't need hydrators and entities.
   The library is after all basic and only thinly object-oriented.
   Maybe I'll write a more OOP library around this some day.
