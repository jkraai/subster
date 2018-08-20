<?php

require('subster.php');

/**
 * subster_sql_simple
 *
 * curried subster for simple sql
 *
 * phase 1: triple curly braced things
 *   assumed to be filespecs, and are included in place
 *   delimiters example {{{:foo}}}
 * phase 2: pretty much exactly subster stuff for structural things
 *   such as table and column names
 *   delimiters example {{:bar}}
 * phase 3: positional parameter replacement, tracking order and placement of '?'
 *   delimiters example {{:baz}}
 *
 */
function subster_sql_simple($sql, $map, $options=false) {

    $out = $sql;
    $placeholders = array();

    // phase 1:  file include
    do {
        $subs = false;
        // just like subster, but
    } while ($subs);

    // phase 2: subster
    $out = subster(
        $out,
        $map,
        array('{{:', '}}')
    );

    // phase 3: positional parameter replacement
    // same $pattern construction as in subster()
    $pattern = '/{:(?<={:)(.+?)(?=})}/';
    do {
        $subs = false;
        // like subster, but
        // - tracking '?' in order
        $matches = preg_match_all($pattern, $out, $matches);
        foreach ($matches[1] as $match) {
            $val = @$map[$match];
            // quietly ignore this $match if not in $map
            if (! $val) { continue; }
            // do the replacement in $out
            $out_p = str_replace($delim[0] . $key . $delim[1], '?', $out);
            if ($out_p != $out) {
                $out = $out_p;
                // add a '?' to $replacements
                $placeholders[] = $val;
                // flag for another pass
                $subs = true;
            }
        }
    } while ($subs);

    return array(
        'sql' => subster(
                $out,
                $map,
                $delim
            ),
        'params' => $placeholders
    );
}

