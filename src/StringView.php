<?php
namespace JDT\LaravelEmailTemplates;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use JDT\LaravelEmailTemplates\Helpers\Bindings;

/**
 * Class StringView
 * @package JDT\LaravelEmailTemplates
 */
class StringView implements Htmlable, View
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $data;

    /**
     * StringView constructor.
     * @param string $content
     * @param array $data
     */
    public function __construct($content, array $data = [])
    {
        $this->content = $content;
        $this->data = $data;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml() : string
    {
        return $this->render();
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render() : string
    {
        $treated = Bindings::normaliseKeys($this->data);

        return str_replace(
            array_keys($treated),
            array_values($treated),
            $this->content
        );
    }

    /**
     * Get the name of the view.
     *
     * @return string
     */
    public function name() : string
    {
        return 'laravel-email-templates';
    }

    /**
     * @param array|string $key
     * @param null $value
     * @return StringView
     */
    public function with($key, $value = null) : StringView
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }
}
