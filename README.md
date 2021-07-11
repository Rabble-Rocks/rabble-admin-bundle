# Rabble Admin Bundle
The Rabble admin bundle is the main bundle you need to include for working with the Rabble system.
It includes some basic admin features other bundles can hook into, such as searching, a system tray and base Twig templates.

# Installation
Install the bundle by running
```sh
composer require rabble/admin-bundle
```

Add the following class to your `config/bundles.php` file:
```php
return [
    ...
    Rabble\AdminBundle\RabbleAdminBundle::class => ['all' => true],
]
```

Add the `config/packages/rabble_admin.yaml` file to your project:
```yaml
rabble_admin:
  enabled_locales:
    - en
    - fr # These locales will be accessed by other bundles.
```