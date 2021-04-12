<?php











namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => 'dev-master',
    'version' => 'dev-master',
    'aliases' => 
    array (
    ),
    'reference' => '5ddd69c04aa1ad5abd0d0da7a8359aec46d649fd',
    'name' => '__root__',
  ),
  'versions' => 
  array (
    '__root__' => 
    array (
      'pretty_version' => 'dev-master',
      'version' => 'dev-master',
      'aliases' => 
      array (
      ),
      'reference' => '5ddd69c04aa1ad5abd0d0da7a8359aec46d649fd',
    ),
    'asm89/stack-cors' => 
    array (
      'pretty_version' => 'v2.0.3',
      'version' => '2.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '9cb795bf30988e8c96dd3c40623c48a877bc6714',
    ),
    'barryvdh/laravel-cors' => 
    array (
      'pretty_version' => 'v2.0.3',
      'version' => '2.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '01de0fe5f71c70d1930ee9a80385f9cc28e0f63a',
    ),
    'doctrine/inflector' => 
    array (
      'pretty_version' => '2.0.3',
      'version' => '2.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '9cf661f4eb38f7c881cac67c75ea9b00bf97b210',
    ),
    'illuminate/collections' => 
    array (
      'pretty_version' => 'v8.36.2',
      'version' => '8.36.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '591e31015a8b0731708c54411cb52d50a00b2bc3',
    ),
    'illuminate/contracts' => 
    array (
      'pretty_version' => 'v8.36.2',
      'version' => '8.36.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '5764f703ea8f74ced163125d810951cd5ef2b7e1',
    ),
    'illuminate/macroable' => 
    array (
      'pretty_version' => 'v8.36.2',
      'version' => '8.36.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '300aa13c086f25116b5f3cde3ca54ff5c822fb05',
    ),
    'illuminate/support' => 
    array (
      'pretty_version' => 'v8.36.2',
      'version' => '8.36.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '26aa01648f348df7b7988ee911cdf98bcaae8ea1',
    ),
    'nesbot/carbon' => 
    array (
      'pretty_version' => '2.46.0',
      'version' => '2.46.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '2fd2c4a77d58a4e95234c8a61c5df1f157a91bf4',
    ),
    'psr/container' => 
    array (
      'pretty_version' => '1.1.1',
      'version' => '1.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '8622567409010282b7aeebe4bb841fe98b58dcaf',
    ),
    'psr/event-dispatcher' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'dbefd12671e8a14ec7f180cab83036ed26714bb0',
    ),
    'psr/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/log' => 
    array (
      'pretty_version' => '1.1.3',
      'version' => '1.1.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '0f73288fd15629204f9d42b7055f72dacbe811fc',
    ),
    'psr/log-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/simple-cache' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
    ),
    'symfony/deprecation-contracts' => 
    array (
      'pretty_version' => 'v2.2.0',
      'version' => '2.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '5fa56b4074d1ae755beb55617ddafe6f5d78f665',
    ),
    'symfony/error-handler' => 
    array (
      'pretty_version' => 'v5.2.6',
      'version' => '5.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'bdb7fb4188da7f4211e4b88350ba0dfdad002b03',
    ),
    'symfony/event-dispatcher' => 
    array (
      'pretty_version' => 'v5.2.4',
      'version' => '5.2.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd08d6ec121a425897951900ab692b612a61d6240',
    ),
    'symfony/event-dispatcher-contracts' => 
    array (
      'pretty_version' => 'v2.2.0',
      'version' => '2.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '0ba7d54483095a198fa51781bc608d17e84dffa2',
    ),
    'symfony/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '2.0',
      ),
    ),
    'symfony/http-client-contracts' => 
    array (
      'pretty_version' => 'v2.3.1',
      'version' => '2.3.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '41db680a15018f9c1d4b23516059633ce280ca33',
    ),
    'symfony/http-foundation' => 
    array (
      'pretty_version' => 'v5.2.4',
      'version' => '5.2.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '54499baea7f7418bce7b5ec92770fd0799e8e9bf',
    ),
    'symfony/http-kernel' => 
    array (
      'pretty_version' => 'v5.2.6',
      'version' => '5.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f34de4c61ca46df73857f7f36b9a3805bdd7e3b2',
    ),
    'symfony/polyfill-ctype' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c6c942b1ac76c82448322025e084cadc56048b4e',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '5232de97ee3b75b0360528dae24e73db49566ab1',
    ),
    'symfony/polyfill-php73' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a678b42e92f86eca04b7fa4c0f6f19d097fb69e2',
    ),
    'symfony/polyfill-php80' => 
    array (
      'pretty_version' => 'v1.22.1',
      'version' => '1.22.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'dc3063ba22c2a1fd2f45ed856374d79114998f91',
    ),
    'symfony/translation' => 
    array (
      'pretty_version' => 'v5.2.6',
      'version' => '5.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '2cc7f45d96db9adfcf89adf4401d9dfed509f4e1',
    ),
    'symfony/translation-contracts' => 
    array (
      'pretty_version' => 'v2.3.0',
      'version' => '2.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e2eaa60b558f26a4b0354e1bbb25636efaaad105',
    ),
    'symfony/translation-implementation' => 
    array (
      'provided' => 
      array (
        0 => '2.3',
      ),
    ),
    'symfony/var-dumper' => 
    array (
      'pretty_version' => 'v5.2.6',
      'version' => '5.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '89412a68ea2e675b4e44f260a5666729f77f668e',
    ),
    'voku/portable-ascii' => 
    array (
      'pretty_version' => '1.5.6',
      'version' => '1.5.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '80953678b19901e5165c56752d087fc11526017c',
    ),
  ),
);
private static $canGetVendors;
private static $installedByVendor = array();







public static function getInstalledPackages()
{
$packages = array();
foreach (self::getInstalled() as $installed) {
$packages[] = array_keys($installed['versions']);
}


if (1 === \count($packages)) {
return $packages[0];
}

return array_keys(array_flip(\call_user_func_array('array_merge', $packages)));
}









public static function isInstalled($packageName)
{
foreach (self::getInstalled() as $installed) {
if (isset($installed['versions'][$packageName])) {
return true;
}
}

return false;
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

$ranges = array();
if (isset($installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = $installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['version'])) {
return null;
}

return $installed['versions'][$packageName]['version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getPrettyVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return $installed['versions'][$packageName]['pretty_version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getReference($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['reference'])) {
return null;
}

return $installed['versions'][$packageName]['reference'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getRootPackage()
{
$installed = self::getInstalled();

return $installed[0]['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
self::$installedByVendor = array();
}




private static function getInstalled()
{
if (null === self::$canGetVendors) {
self::$canGetVendors = method_exists('Composer\Autoload\ClassLoader', 'getRegisteredLoaders');
}

$installed = array();

if (self::$canGetVendors) {
foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
if (isset(self::$installedByVendor[$vendorDir])) {
$installed[] = self::$installedByVendor[$vendorDir];
} elseif (is_file($vendorDir.'/composer/installed.php')) {
$installed[] = self::$installedByVendor[$vendorDir] = require $vendorDir.'/composer/installed.php';
}
}
}

$installed[] = self::$installed;

return $installed;
}
}
