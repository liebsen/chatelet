<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit64365b3744da443a4e82e1f6854c1fbc
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Ctype\\' => 23,
        ),
        'J' => 
        array (
            'Joomla\\Uri\\' => 11,
            'Joomla\\Http\\' => 12,
        ),
        'D' => 
        array (
            'Dotenv\\' => 7,
        ),
        'C' => 
        array (
            'Composer\\CaBundle\\' => 18,
        ),
        'A' => 
        array (
            'AlejoASotelo\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Joomla\\Uri\\' => 
        array (
            0 => __DIR__ . '/..' . '/joomla/uri/src',
        ),
        'Joomla\\Http\\' => 
        array (
            0 => __DIR__ . '/..' . '/joomla/http/src',
        ),
        'Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
        ),
        'Composer\\CaBundle\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/ca-bundle/src',
        ),
        'AlejoASotelo\\' => 
        array (
            0 => __DIR__ . '/..' . '/alejoasotelo/andreani/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'A' => 
        array (
            'Andreani' => 
            array (
                0 => __DIR__ . '/..' . '/andreani/sdk-php/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit64365b3744da443a4e82e1f6854c1fbc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit64365b3744da443a4e82e1f6854c1fbc::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit64365b3744da443a4e82e1f6854c1fbc::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit64365b3744da443a4e82e1f6854c1fbc::$classMap;

        }, null, ClassLoader::class);
    }
}