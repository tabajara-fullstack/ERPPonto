<?php
namespace Helpers;

class Minify {
    public static function css(array $files): string {
        $out = "";
        foreach ($files as $file) { $out .= "/* $file */\n"; }
        return $out;
    }
}
