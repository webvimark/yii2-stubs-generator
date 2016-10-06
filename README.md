Yii::$app stubs generator for Yii 2
===================================

Fork from awesome bazilio91/yii2-stubs-generator. All credits to bazilio91.

This extension provides no-more-butthurt components autocomplete generator command for Yii 2.

![in action](https://monosnap.com/file/oHUjBSw7oIJHYAEpQKs4mVVJLfMLrM.png)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require webvimark/yii2-stubs-generator --dev
```

or add

```json
"webvimark/yii2-stubs-generator": "^1"
```

to the `require-dev` section of your `composer.json`.


Usage
-----

To use this extension, simply add the following code in your application configuration (console.php):

```php
'controllerMap' => [
    'stubs' => [
        'class' => 'webvimark\stubsgenerator\StubsController',

        // This configs will be always will be used in stub generation. It can be empty
        
//            'configs' => [
//                'console/config/main.php',
//                'common/config/main.php',
//                'frontend/config/main.php',
//            ],
    ],
],
```

```
# generate stubs with default configs
php yii stubs

# generate stubs for console application (plus default configs)
php yii stubs console/config/main.php

# to generate stubs for several apps
php yii stubs console/config/main.php common/config/main.php frontend/config/main.php (plus default configs)
```

File with stubs by default located in vendor directory.

Usage with PhpStorm
-------------------

1. Install `File Watchers` JetBrains plugin
2. Open `File Watchers` plugin config and import [watcher.xml](watcher.xml)
3. Edit imported watcher for your needs
4. Add scope to limit trigger to config files: ![](https://monosnap.com/file/9UdEAsZUxO6XcOxINgm1sucWxuuYu4.png)

#### PhpStorm "multiple definitions exist for class"
To hide this message:
1. Find a duplicate class file (not created by this generator), for example: `vendor/yiisoft/yii/YiiBase.php`
2. Mark it as a plain text in file context menu.
