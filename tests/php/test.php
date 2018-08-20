<?php

class test extends PHPUnit_Framework_TestCase {

    public function test_subster() {
        $this->assertTrue( subster() == true );

        // happy path testing examples ...

        // try it out with default delimeter
        $string = 'zero {:key0} one {:key1} two {:key2} three';

        $map = array(
            'key0' => 'val0',    // straight substitution
            'key1' => '{:key2}', // exercise that do...while loop
            'key2' => 'val2',
        );

        $string = subster(
            $string,
            $map
        );

        $expect = "zero val0 one val2 two val2 three";
        if ($string != $expect) {
            echo 'problems in // try it out w/ different delimeter' . PHP_EOL;
            echo 'expected::' . $expect . '::' . PHP_EOL;
            echo '  actual::' . $actual . '::' . PHP_EOL;
        }


        // try it out w/ different delimeter
        $string = 'zero <:key0> one <:key1> two <:key2> three';

        $map = array(
            'key0' => 'val0',
            'key1' => '<:key2>',
            'key2' => 'val2',
        );
        $delim = array('<:', '>');

        $string = subster(
            $string,
            $map,
            $delim
        );
        if ($string != $expect) {
            echo 'problems in // try it out w/ different delimeter' . PHP_EOL;
            echo 'expected::' . $expect . '::' . PHP_EOL;
            echo '  actual::' . $actual . '::' . PHP_EOL;
        }


        // try it out w/ stoopid delimeters
        $string = 'zero <<<key0}}} one <<<key1}}} two <<<key2}}} three';

        $map = array(
            'key0' => 'val0',
            'key1' => '<<<key2}}}',
            'key2' => 'val2',
        );
        $delim = array('<<<', '}}}');

        $string = subster(
            $string,
            $map,
            $delim
        );
        if ($string != $expect) {
            echo 'problems in // try it out w/ different delimeter' . PHP_EOL;
            echo 'expected::' . $expect . '::' . PHP_EOL;
            echo '  actual::' . $actual . '::' . PHP_EOL;
        }


    } // function test_subster

    public function test_subster_regex() {
        $this->assertTrue( subster_regex() == true );

        // happy path testing examples ...

        // try it out
        $string = '/{{number}}{3} {{letter}}{3} {{hexagiblet}}/';

        $map = array(
            'number' => '\d',                           // straight substitution
            'hexagiblet' => '[{{number}}A-F]',          // exercise that do...while loop
            'letter' => '[{{letter_uc}}{{letter_lc}}]', // exercise that do...while loop
            'letter_lc' => 'a-z',
            'letter_uc' => 'A-Z',
        );

        $actual = subster_regex(
            $string,
            $map
        );

        $expect = '/\d{3} [A-Za-z]{3} [\dA-F]/';
        if ($actual['regex'] != $expect) {
            echo 'problems in // try it out w/ different delimeter' . PHP_EOL;
            echo 'expected::' . $expect . '::' . PHP_EOL;
            echo '  actual::' . $actual['regex'] . '::' . PHP_EOL;
        }

        // try it out, leaving a param for later
        $string = '/{{number}}{3} {{decimal}} {{letter}}{3} {{hexagiblet}}/';

        $map = array(
            'number' => '\d',                           // straight substitution
            'hexagiblet' => '[{{number}}A-F]',          // exercise that do...while loop
            'letter' => '[{{letter_uc}}{{letter_lc}}]', // exercise that do...while loop
            'letter_lc' => 'a-z',
            'letter_uc' => 'A-Z',
        );

        $actual = subster_regex(
            $string,
            $map
        );

        $expect = '/\d{3} {{decimal}} [A-Za-z]{3} [\dA-F]/';
        if ($actual['regex'] != $expect) {
            echo 'problems in // try it out w/ different delimeter' . PHP_EOL;
            echo 'expected::' . $expect . '::' . PHP_EOL;
            echo '  actual::' . $actual['regex'] . '::' . PHP_EOL;
        }
    } // function test_subster_regex

    public function test_subster_sql_simple() {
        $this->assertTrue( subster_sql_simple() == true );

        $sql = <<<EOSQL
            SELECT {{:columns}}
    FROM   {{:table_name}}
    WHERE  {{:id_col}} = {:id}
    ORDER BY {{:columns}}
EOSQL;

        $map = array(
            'table_name' => 'people',
            'id_col'     => 'ID',
            'columns'    => 'lname, fname',
            'id'         => 1726354,
        );

        $actual = subster_sql_simple(
            $sql,
            $map
        );

        $expect = array('params' => 1726354);
        $expect['sql'] = <<<EO_SQL_EXP
    SELECT lname, fname
    FROM   people
    WHERE  ID = ?
    ORDER BY lname, fname
EO_SQL_EXP;

        if (
            $actual['sql'] != $expect['sql'] || 
            $actual['params'] != $expect['params']
        ) {
            echo 'problems with subster_sql_simple()' . PHP_EOL;
            echo 'expected::' . json_encode($expect) . '::' . PHP_EOL;
            echo '  actual::' . json_encode($actual) . '::' . PHP_EOL;
        }

    } // function test_subster_sql_simple

    public function test_subster_sql() {
        $this->assertTrue( subster_sql() == true );
    } // function test_subster_sql

    public function test_subster_html_template() {
        $this->assertTrue( subster_html_template() == true );
        
        $doc = '{{basedoc}}';

        $html4_template =<<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
{{head}}
{{body}}
</html>
EOT;

        $head ='<head>\n\t{{head_content}}\n';
        $body ='<body>\n\t{{body_content}}\n</body>\n';



        $doc = subster_html_template(
            $doc,
            array(
                'basedoc' => $basedoc,
                'head' => $head,
                'head_content' => $head_content,
                'body' => $body,
                'body_content' => $body_content,
            )
        );


    } // function test_subster_html_template

}

