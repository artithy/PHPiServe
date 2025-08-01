<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbb012c768f0ec9622949ebd7c583a5cf
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbb012c768f0ec9622949ebd7c583a5cf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbb012c768f0ec9622949ebd7c583a5cf::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbb012c768f0ec9622949ebd7c583a5cf::$classMap;

        }, null, ClassLoader::class);
    }
}
