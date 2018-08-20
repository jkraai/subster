<?php

require('subster.php');

/**
 * subster_regex
 *
 * curried subster for regexes
 *
 * also see http://lea.verou.me/2011/03/create-complex-regexps-more-easily/
 * for an earlier take on the same problem
 *
 * @param $str           what we're doing substitution on
 * @param $replacements  assoc array mapping keys to values
 * @param $flags         optional array with regex flags
 *
 * @return array with array('regex' => with replacements, 'flags' => passed flags)
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


