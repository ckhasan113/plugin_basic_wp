<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteeae3e9cbb1fc3cad5650d11f3351b1e
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Inc\\' => 4,
        ),
        'A' => 
        array (
            'Admin\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
        'Admin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/templates',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteeae3e9cbb1fc3cad5650d11f3351b1e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteeae3e9cbb1fc3cad5650d11f3351b1e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticIniteeae3e9cbb1fc3cad5650d11f3351b1e::$classMap;

        }, null, ClassLoader::class);
    }
}
