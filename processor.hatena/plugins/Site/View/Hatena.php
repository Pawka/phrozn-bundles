<?php
namespace PhroznPlugin\Site\View;
use PhroznPlugin\Processor,
    Phrozn\Site\View\OutputPath\Entry as OutputFile;

class Hatena
    extends \Phrozn\Site\View\Base
    implements \Phrozn\Site\View
{
    /**
     * Initialize view
     *
     * @param string $inputFile Path to view source file
     * @param string $outputDir File destination path
     *
     * @return \Phrozn\Site\View
     */
    public function __construct($inputFile = null, $outputDir = null)
    {
        parent::__construct($inputFile, $outputDir);

        $this->addProcessor(new Processor\Hatena());
    }

    /**
     * Render view. Markdown views are rendered within layout.
     *
     * @param array $vars List of variables passed to text processors
     *
     * @return string
     */
    public function render($vars = array())
    {
        $view = parent::render($vars);
        if ($this->hasLayout()) {
            // inject global site and front matter options into template
            $vars = array_merge($vars, $this->getParams());
            $view = $this->applyLayout($view, $vars);
        }
        return $view;
    }

    /**
     * Get output file path
     *
     * @return string
     */
    public function getOutputFile()
    {
        $path = new OutputFile($this);
        return $path->get();
    }
}

