<?php

/**
 * 解压含有文件名为UTF-8编码的zip包，到当前目录
 *
 * Mac OS X 系统自带的压缩程序对 zip 文件名用 UTF-8 编码
 * 但 zip 文件头中没有声明 PKZIP 高版本增加的 Unicode 位。
 * Windows 会认为文件名是 ANSI 编码，结果显示乱码。
 *
 * @uses unzip.php file.zip
 *
 */

if (!extension_loaded('zip')) {
    printf("php zip extension is needed. See http://www.php.net/manual/en/zip.installation.php\n", $argv[0]);
    die;
}

if (!isset($argv[1])) {
    printf("Usage: php %s filename\n\n", $argv[0]);
    die;
}
$root_dir = basename($argv[1], ".zip") . 'zip';
!is_dir($root_dir) && mkdir($root_dir);
$out_charset = getOSCharset();
$f = zip_open($argv[1]);
while ($e = zip_read($f)) {
    $filesize = zip_entry_filesize($e);
    // 检测字符的编码
    $encode = mb_detect_encoding(zip_entry_name($e), ["ASCII", "UTF-8", "GB2312", "GBK", "BIG5"]);
    $filename = iconv($encode, $out_charset, zip_entry_name($e));
    $filename = $root_dir . DIRECTORY_SEPARATOR . $filename;
    if (!$filesize) {
        mkdir($filename);
        continue;
    } elseif (!zip_entry_open($f, $e)) {
        continue;
    }
    file_put_contents($filename, zip_entry_read($e, $filesize));
    echo "$filesize\t$filename\n";
    zip_entry_close($e);
}

zip_close($f);

function  getOSCharset()
{
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        return 'GBK';
    } else {
        return 'UTF-8';
    }
}
