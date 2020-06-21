<?php

namespace Arrilot\Widgets;

abstract class AbstractWidget
{
    /**
     * The number of seconds before each reload.
     * False means no reload at all.
     *
     * @var int|float|bool
     */
    public $reloadTimeout = false;

    /**
     * The number of minutes before cache expires.
     * False means no caching at all.
     *
     * @var int|float|bool
     */
    public $cacheTime = false;

    /**
     * Cache tags allow you to tag related items in the cache and then flush all cached values that assigned a given tag.
     *
     * @var array
     */
    public $cacheTags = [];

    /**
     * Should widget params be encrypted before sending them to /arrilot/load-widget?
     * Turning encryption off can help with making custom reloads from javascript, but makes widget params publicly accessible.
     *
     * @var bool
     */
    public $encryptParams = true;

    /**
     * The configuration array.
     *
     * @var array
     */
    public $config = [];

     /**
     * The widget title.
     */
    public $title = "";

    /**
     * The widget title class.
     */
    public $titleClass = "";

    /**
     * The widget description.
     */
    public $description = "";

    /**
     * Hide the widget title on output
     */
    public $hideTitle = false;

    /**
     * Set the widget title element. Default = h2
     */
    public $titleElement = null;

    /**
     * Set the widget wrapper element. Default = div
     */
    public $wrapper = null;

    /**
     * Add attributes to the widget wrapper
     */
    public $attributes = [
        //
    ];

    /**
     * Constructor.
     *
     * @param array $config
     * @param array $attributes
     */
    public function __construct(array $config = [], array $attributes = [])
    {
        foreach ($config as $key => $value) {
            if(is_array($value)) {
                $value = array_merge($this->config[$key], $value);
            }
            $this->config[$key] = $value;
        }
        
        foreach ($attributes as $key => $value) {
            if(is_array($value)) {
                $value = array_merge($this->attributes[$key], $value);
            }
            $this->attributes[$key] = $value;
        }
    }

    /**
     * Placeholder for async widget.
     * You can customize it by overwriting this method.
     *
     * @return string
     */
    public function placeholder()
    {
        return '';
    }

    /**
     * Async and reloadable widgets are wrapped in container.
     * You can customize it by overriding this method.
     *
     * @return array
     */
    public function container()
    {
        return [
            'element'       => 'div',
            'attributes'    => 'style="display:inline" class="arrilot-widget-container"',
        ];
    }

    /**
     * Cache key that is used if caching is enabled.
     *
     * @param $params
     *
     * @return string
     */
    public function cacheKey(array $params = [])
    {
        return 'arrilot.widgets.'.serialize($params);
    }

    /**
     * Cache tags to help flush all cache with the same tag(s).
     *
     * @return array
     */
    public function cacheTags()
    {
        return array_unique(array_merge(['widgets'], $this->cacheTags));
    }

    /**
     * Add defaults to configuration array.
     *
     * @param array $defaults
     */
    protected function addConfigDefaults(array $defaults)
    {   
        $this->config = array_merge($this->config, $defaults);
    }

    /**
     * Add defaults to attributes array.
     *
     * @param array $defaults
     */
    protected function addAttributesDefaults(array $defaults)
    {
        $this->attributes = array_merge($this->attributes, $defaults);
    }
}