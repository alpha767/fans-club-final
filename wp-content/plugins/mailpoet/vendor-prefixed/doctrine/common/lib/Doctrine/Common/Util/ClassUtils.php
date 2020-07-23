<?php
 namespace MailPoetVendor\Doctrine\Common\Util; if (!defined('ABSPATH')) exit; use MailPoetVendor\Doctrine\Common\Persistence\Proxy; class ClassUtils { public static function getRealClass($class) { if (\false === ($pos = \strrpos($class, '\\' . \MailPoetVendor\Doctrine\Common\Persistence\Proxy::MARKER . '\\'))) { return $class; } return \substr($class, $pos + \MailPoetVendor\Doctrine\Common\Persistence\Proxy::MARKER_LENGTH + 2); } public static function getClass($object) { return self::getRealClass(\get_class($object)); } public static function getParentClass($className) { return \get_parent_class(self::getRealClass($className)); } public static function newReflectionClass($class) { return new \ReflectionClass(self::getRealClass($class)); } public static function newReflectionObject($object) { return self::newReflectionClass(self::getClass($object)); } public static function generateProxyClassName($className, $proxyNamespace) { return \rtrim($proxyNamespace, '\\') . '\\' . \MailPoetVendor\Doctrine\Common\Persistence\Proxy::MARKER . '\\' . \ltrim($className, '\\'); } } 