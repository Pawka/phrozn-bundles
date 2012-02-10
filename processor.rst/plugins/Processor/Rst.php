<?php
namespace PhroznPlugin\Processor;
use Phrozn\Autoloader as Loader;

class Rst
    extends \Phrozn\Processor\Base
    implements \Phrozn\Processor
{

    
    public function __construct($options = array())
    {
    }

    public function render($tpl, $vars = array())
    {
        return $this->parseRst($tpl);
    }

    // This code is based upon that of
    // - http://www.mediawiki.org/wiki/Extension:RstToHtml
    // - http://goldenspud.com/rest-wordpress/rest.php-1.1.txt
    private function parseRst($tpl)
    {
        $processor = trim(shell_exec('which rst2html'));
        if(empty($processor)) {
            return 'Cannot find rst2html please install docutils to meet this dependency.';
        }
        $pipes_map = array(
            0 => array('pipe', 'r'),
            1 => array('pipe', 'w'),
        );
        $arguments = array(
            '--no-toc-backlinks',
            '--no-doc-title',
            '--no-generator',
            '--no-source-link',
            '--no-footnote-backlinks',
            '--initial-header-level=2',
            '--no-raw',
            '--no-file-insertion',
            '--stylesheet-path=""',
        );
        $exec_string = $processor . ' ' . implode(' ', $arguments);
        $proc_res = proc_open($exec_string, $pipes_map, $pipes);
        if(!is_resource($proc_res)) {
            return 'Could not process the file with rst2html.';
        }
        fwrite($pipes[0], $tpl);
        fclose($pipes[0]);
        $html = stream_get_contents($pipes[1]);
        $html = preg_replace('/.*<body>\n(.*)<\/body>.*/s', '${1}', $html);
        return $html;
    }
}
