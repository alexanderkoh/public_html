<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit336da0bcddd4ccdae2c2a1c36710a5fb
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit336da0bcddd4ccdae2c2a1c36710a5fb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit336da0bcddd4ccdae2c2a1c36710a5fb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit336da0bcddd4ccdae2c2a1c36710a5fb::$classMap;

        }, null, ClassLoader::class);
    }
}
