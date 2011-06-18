<?php
namespace PhroznPlugin\Processor;
use Phrozn\Autoloader as Loader;

class Hatena
    extends \Phrozn\Processor\Base
    implements \Phrozn\Processor
{

    
    public function __construct($options = array())
    {
        require_once 'HatenaSyntax.php';
        //$path = Loader::getInstance()->getPath('library');
    }

    public function render($tpl, $vars = array())
    {
        return \HatenaSyntax::render($tpl);
    }
}

