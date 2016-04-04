NzoUrlEncryptorBundle
=====================

[![Build Status](https://travis-ci.org/NAYZO/NzoUrlEncryptorBundle.svg?branch=master)](https://travis-ci.org/NAYZO/NzoUrlEncryptorBundle)
[![Total Downloads](https://poser.pugx.org/nzo/url-encryptor-bundle/downloads)](https://packagist.org/packages/nzo/url-encryptor-bundle)
[![Latest Stable Version](https://poser.pugx.org/nzo/url-encryptor-bundle/v/stable)](https://packagist.org/packages/nzo/url-encryptor-bundle)

The **NzoUrlEncryptorBundle** is a Symfony2 Bundle used to Encrypt and Decrypt data and variables in the Web application or passed through the ``URL`` to provide more security to the project.
Also it prevent users from reading and modifying sensitive data sent through the ``URL``.


Features include:

- Url Data & parameters Encryption
- Url Data & parameters Decryption
- Data Encryption & Decryption
- Access from Twig by ease
- Flexible configuration


Installation
------------

### Through Composer:

Add the following lines in your `composer.json` file:

``` js
"require": {
    "nzo/url-encryptor-bundle": "~1.0"
}
```
Install the bundle:

```
$ composer update
```

### Register the bundle in app/AppKernel.php:

``` php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        // ...
        new Nzo\UrlEncryptorBundle\NzoUrlEncryptorBundle(),
    );
}
```

### Configure your application's config.yml:

Configure your secret encryption key:

``` yml
# app/config/config.yml

nzo_url_encryptor:
    secret: YourSecretEncryptionKey      # max length of 24 characters
```

Usage
-----

#### In the twig template:
 
Use the filter to ``encrypt`` or ``decrypt`` variables passed in the url:

``` html

 <a href="{{path('my-path-in-the-routing', {'id': MyId | urlencrypt } )}}"> My link </a>

 # if it needed you can use the twig decryption filter:

 <a href="{{path('my-path-in-the-routing', {'id': MyId | urldecrypt } )}}"> My link </a>

```

Also you can ``encrypt`` and ``decrypt`` any data using the ``Twig filter``:

``` html
# Encrypt data:

    {{MyVar | urlencrypt }}

# Decrypt data:

    {{MyVar | urldecrypt }}
```

#### In the routing.yml:

``` yml
# routing.yml

my-path-in-the-routing:
    path: /my-url/{id}
    defaults: {_controller: MyBundle:MyController:MyFunction}

```

#### In the controller with annotation service:

Use the annotation service to ``decrypt`` automatically any parameter you want, by using the ``ParamDecryptor`` annotation service and specifying in it all the parameters to be decrypted:

```php
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;
//...

    /**
     * @ParamDecryptor(params="id, toto, bar")
     */
     public function indexAction(User $id, $toto) 
    {
        // no need to use the decryption service here as the parameters are already decrypted by the annotation service.
        //....

    }
```

#### In the controller without annotation service:

Use the ``decrypt`` function of the service to decrypt your data:

```php
     public function indexAction($id) 
    {
        $MyId = $this->get('nzo_url_encryptor')->decrypt($id);

        //....

    }
```

You can also use the ``encrypt`` function of the service to encrypt your data:

```php
     public function indexAction() 
    {   
        //....
        
        $Encrypted = $this->get('nzo_url_encryptor')->encrypt($data);

        //....

    }
```

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

See [Resources/doc/LICENSE](https://github.com/NAYZO/NzoUrlEncryptorBundle/tree/master/Resources/doc/LICENSE)