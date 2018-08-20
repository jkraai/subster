<?php

require('subster.php');

/**
 * subster_html_template
 *
 * curried subster for html templating
 *
 * phase 1: triple curly braced things
 *   assumed to be filespecs, and are included in place
 *   delimiters example {{{:foo}}}
 * phase 2: pretty much exactly subster stuff for structural things
 *   such as table and column names
 *   delimiters example {{:bar}}
 * ? phase 3: inversion for native code execution
 *
 */
function subster_html_template($doc, $map, $options=0) {

    $out = $doc;

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

    // phase 3: inversion for native code execution
    // $parts = explode($explody_marker, $out);
    // $parts_count = count($parts);
    // for ($i=0; $i<$parts_count; Ri++) {
    //   if ($i%2) {
    //      // code part
    //   }
    //   else {
    //     // markup part
    //   }
    // }
    // etc.

    return $doc;
}


