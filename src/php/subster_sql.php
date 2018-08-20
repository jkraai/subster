<?php

require('subster.php');

/**
 * subster_sql
 *
 * like subster for sql
 *
 * phase 1: triple curly braced things
 *   assumed to be filespecs, and are included in place
 *   delimiters example {{{:foo}}}
 * phase 2: pretty much exactly subster stuff for structural things
 *   such as table and column names
 *   map values that are numerically indexed arrays are 
 *   - treated as lists and imploded
 *   - handy for reusable lists of column names
 *   delimiters example {{:bar}}
 * phase 3: positional parameter replacement, tracking order and placement of '?'
 *   map values that are numerically indexed arrays are treated as lists and imploded
 *   map values that are associative arrays are 
 *   - treated as key-value pairs
 *   - handy for INSERT AND UPDATE statements, for example
 *   delimiters example {{:baz}}
 *
 */
function subster_sql($sql, $map, $options) {

    $out = $sql;

    // phase 1:  file include
    do {
        $subs = false;
        // just like subster, but
    } while ($subs);

    // phase 2: subster
    $pattern = '/'.'{{:'.'(?<='.'{{:'.')(.+?)(?='.'}}'.')'.'}}/';
    $placeholders = array();
    do {
        $subs = false;
        // like subster, but
        // - tracking '?' in order
        $matches = preg_match_all($pattern, $out, $matches);
        foreach ($matches[1] as $match) {
            $val = @$map[$match];
            // quietly ignore this $match if not in $map
            if (! $val) { continue; }
            if (is_array($val)) {
                if (! is_array_assoc($val)) {
                    // handle as key-value pairs, imploded with ','
                }
            }
            else {
                // do the replacement in $out
            }
        }
    } while ($subs);

    // phase 3: positional parameter replacement
    $pattern = '/'.'{:'.'(?<='.'{:'.')(.+?)(?='.'}'.')'.'}/';
    $placeholders = array();
    do {
        $subs = false;
        // like subster, but
        // - tracking '?' in order
        $matches = preg_match_all($pattern, $out, $matches);
        foreach ($matches[1] as $match) {
            $val = @$map[$match];
            // quietly ignore this $match if not in $map
            if (! $val) { continue; }
            if (is_array($val)) {
                if (is_array_assoc($val)) {
                    // assoc array
                    // handle as list of things, imploded with ','
                }
                else {
                    // numeric array
                    // handle as key-value pairs, imploded with ','
                    // add correct number of '?' to $replacements
                }
            }
            else {
                // do the replacement in $out
                // add a '?' to $replacements
            }
        }
    } while ($subs);

    return array(
        'regex' => subster(
                $string,
                $map,
                $delim
            ),
        'flags' => $flags,
    );
}

function is_array_assoc($arr) {
    return array_keys($arr) !== range(0, count($arr) - 1);
}


