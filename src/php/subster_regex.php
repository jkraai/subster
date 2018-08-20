<?php

require('subster.php');

/**
 * subster_regex
 *
 * curried subster for regexes
 *
 */
function subster_regex($str, $replacements, $flags='') {
    return array(
        'regex' => subster(
                $str,
                $replacements,
                $delim = array('{{', '}}')
            ),
        'flags' => $flags,
    );
}


