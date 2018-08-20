<?php

/*
 * subster
 *
 * generic complex string builder, conceptual basis for db_helper ebind_sql()
 *
 * see similar regex builder at http://lea.verou.me/2011/03/create-complex-regexps-more-easily/
 *
 * a choice has to be made, either loop over the map or loop over key pattern matches
 *
 * by looping over key pattern matches
 * - the map doesn't have to be completely tidy, so it can be reused for multiple 
 *   purposes with minimal changes
 * - a choice has to be made of how to deal with keys not in the map, throw an error or not
 *   - by quietly soldiering on, we can have more general $string where there's no penalty
 *     for not using a clause, think SQL statements without an ORDER BY clause
 *
 * @param $string   what we're doing substitution on
 * @param $map      assoc array mapping keys to values
 * @param $delim    optional array with opening and closing strings
 *
 * @return string with replacements
 *
 */
function subster($string, $map, $delim = array('{:', '}')) {

    // construct the regex
    // $pattern = '/' . $delim[0] . '(?<=' . $delim[0] . ')(.+?)(?=' . $delim[1] . ')' . $delim[1] . '/';
    // php regexp expanded mode for readability
    $pattern = '/(?x)                           # start expanded mode
        ' . $delim[0] . '(?<=' . $delim[0] . ') # starts with $delim[0], but dont capture it
        (.+?)                                   # capture the name string
        (?=' . $delim[1] . ')' . $delim[1] . '  # ends with $delim[1], but dont capture it
      /';

    // loop, if $map values contain keys, get those, too
    // sanity checking since we're in a possibly endless loop
    $loop_limit = 100;
    $loop_count = 0;
    do {
        if ($loop_count++ > $loop_limit) {
            throw new Exception('Exceeded loop limit, got tired');
        }
        // count substitutions
        $subs = false;
        $preg = preg_match_all($pattern, $string . ' ', $matches);
        if ($preg !== 0 and $preg !== false) {
            // loop over matches
            foreach ($matches[1] as $key) {
                $val = @$map[$key];
                // quietly skip this match if not found in $map
                if ($val === NULL) { continue; }
                // simple string replace
                $string_p = str_replace($delim[0] . $key . $delim[1], $val, $string);
                if ($string_p != $string) {
                    $string = $string_p;
                    // flag for another pass
                    $subs = true;
                }
            }
        }
        // we're done if no substitutions were made
    } while ($subs);
    return $string;
}

