<?php

namespace BladeBuilder;

use BladeBuilder\Contracts\ThemeContract;
use BladeBuilder\Modules\GrapesJS\Block\BaseController;
use BladeBuilder\Modules\GrapesJS\Block\BaseModel;
use BladeBuilder\Modules\GrapesJS\PageRenderer;

class ThemeBlock
{
    /**
     * @var $config
     */
    protected $config;

    /**
     * @var ThemeContract $theme
     */
    protected $theme;

    /**
     * @var string $blockSlug
     */
    protected $blockSlug;

    /**
     * Theme constructor.
     *
     * @param ThemeContract $theme         the theme this block belongs to
     * @param string $blockSlug
     */
    public function __construct(ThemeContract $theme, string $blockSlug)
    {
        $this->theme = $theme;
        $this->blockSlug = $blockSlug;

        $this->config = [];
        if (file_exists($this->getFolder() . '/config.php')) {
            $this->config = require $this->getFolder() . '/config.php';
        }

        PageRenderer::setCanBeCached(
            boolval($this->config['cache'] ?? true),
            $this->config['cache_lifetime'] ?? null
        );
    }

    /**
     * Return the absolute folder path of this theme block.
     *
     * @return string
     */
    public function getFolder()
    {
        return $this->theme->getFolder() . '/blocks/' . basename($this->blockSlug);
    }

    /**
     * Return the namespace to the folder of this theme block.
     *
     * @return string
     */
    protected function getNamespace()
    {
        // Return Namespace from Config file if exists;
        if( phpb_config('theme.namespace') )
            return phpb_config('theme.namespace');

        // Get namespace from directory structure if not provided:

        $themesPath = phpb_config('theme.folder');
        $themesFolderName = basename($themesPath);
        $blockFolder = $this->getFolder();
        $namespacePath = $themesFolderName . str_replace($themesPath, '', $blockFolder);

        // convert each character after a - to uppercase
        $namespace = implode('-', array_map('ucfirst', explode('-', $namespacePath)));
        // convert each character after a _ to uppercase
        $namespace = implode('_', array_map('ucfirst', explode('-', $namespace)));
        // convert each character after a / to uppercase
        $namespace = implode('/', array_map('ucfirst', explode('/', $namespace)));
        // remove all dashes
        $namespace = str_replace('-', '', $namespace);
        // remove all underscores
        $namespace = str_replace('_', '', $namespace);
        // replace / by \
        $namespace = str_replace('/', '\\', $namespace);

        return $namespace;
    }

    /**
     * Return the controller class of this theme block.
     *
     * @return string
     */
    public function getControllerClass()
    {
        if (file_exists($this->getFolder() . '/controller.php')) {
            return $this->getNamespace() . '\\Controller';
        }
        return BaseController::class;
    }

    /**
     * Return the controller file of this theme block.
     *
     * @return string|null
     */
    public function getControllerFile()
    {
        if (file_exists($this->getFolder() . '/controller.php')) {
            return $this->getFolder() . '/controller.php';
        }
        return null;
    }

    /**
     * Return the model class of this theme block.
     *
     * @return string
     */
    public function getModelClass()
    {
        if (file_exists($this->getFolder() . '/model.php')) {
            return $this->getNamespace() . '\\Model';
        }
        return BaseModel::class;
    }

    /**
     * Return the model file of this theme block.
     *
     * @return string|null
     */
    public function getModelFile()
    {
        if (file_exists($this->getFolder() . '/model.php')) {
            return $this->getFolder() . '/model.php';
        }
        return null;
    }

    /**
     * Return the view file of this theme block.
     *
     * @return string
     */
    public function getViewFile()
    {
        if ($this->isPhpBlock()) {
            $renderer = new (phpb_config('block.renderer'));

            return $renderer->getViewFile($this->getFolder());
        }
        return $this->getFolder() . '/view.html';
    }

    /**
     * Return the pagebuilder script file of this theme block.
     * This script can be used to assist correct rendering of the block in the pagebuilder.
     *
     * @return string|null
     */
    public function getBuilderScriptFile()
    {
        if (file_exists($this->getFolder() . '/builder-script.php')) {
            return $this->getFolder() . '/builder-script.php';
        } elseif (file_exists($this->getFolder() . '/builder-script.html')) {
            return $this->getFolder() . '/builder-script.html';
        } elseif (file_exists($this->getFolder() . '/builder-script.js')) {
            return $this->getFolder() . '/builder-script.js';
        }
        return $this->getScriptFile();
    }

    /**
     * Return the script file of this theme block.
     * This script can be used to assist correct rendering of the block when used on a publicly accessed web page.
     *
     * @return string|null
     */
    public function getScriptFile()
    {
        if (file_exists($this->getFolder() . '/script.php')) {
            return $this->getFolder() . '/script.php';
        } elseif (file_exists($this->getFolder() . '/script.html')) {
            return $this->getFolder() . '/script.html';
        } elseif (file_exists($this->getFolder() . '/script.js')) {
            return $this->getFolder() . '/script.js';
        }
        return null;
    }

    /**
     * Return the file path of the thumbnail of this block.
     *
     * @return string
     */
    public function getThumbPath()
    {
        $blockThumbsFolder = $this->theme->getFolder() . '/public/block-thumbs/';
        return $blockThumbsFolder . md5($this->blockSlug) . '/' . md5(file_get_contents($this->getViewFile())) . '.jpg';
    }

    public function getThumbUrl()
    {
        return phpb_theme_asset('block-thumbs/' . md5($this->blockSlug) . '/' . md5(file_get_contents($this->getViewFile())) . '.jpg');
    }

    /**
     * Return the slug identifying this type of block.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->blockSlug;
    }

    /**
     * Return whether this block is a block containing/allowing PHP code.
     *
     * @return bool
     */
    public function isPhpBlock()
    {
        $renderer = new (phpb_config('block.renderer'));

        return $renderer->isDynamicBlock($this->getFolder());
    }

    /**
     * Return whether this block is a plain html block that does not contain/allow PHP code.
     *
     * @return bool
     */
    public function isHtmlBlock()
    {
        return (! $this->isPhpBlock());
    }

    /**
     * Return configuration with the given key (as dot-separated multidimensional array selector).
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        // if no dot notation is used, return first dimension value or empty string
        if (strpos($key, '.') === false) {
            return $this->config[$key] ?? null;
        }

        // if dot notation is used, traverse config string
        $segments = explode('.', $key);
        $subArray = $this->config;
        foreach ($segments as $segment) {
            if (isset($subArray[$segment])) {
                $subArray = &$subArray[$segment];
            } else {
                return null;
            }
        }

        return $subArray;
    }
}
