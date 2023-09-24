<?php

namespace Core\View;

use Core\Exceptions\ForbiddenException;
use Core\Exceptions\LayoutNotFoundException;
use Core\Support\Arr;
use Exception;

class View
{
    /**
     * Path to errors directory.
     */
    const  errorsDirectory = 'errors/';

    /**
     * Render a view by combining the base layout and the view content.
     *
     * @param string $path The path to the view file.
     * @param string|null $layout The path to the base layout file (optional).
     * @param array $params An associative array of parameters to pass to the view (optional).
     */
    public static function make($path, $layout = null, $params = [])
    {

        $baseContent = self::getBaseContent($layout);
        $viewContent = self::getViewContent($path, $params);

        // If no layout specified return only view content.
        if (!$layout)
        {
            $content = $viewContent;
        }
        else
        {

            // Replace the content placeholder in the base layout with the view content.
            $content = str_replace('{{content}}', $viewContent, $baseContent);
        }
        echo $content;
    }

    /**
     * Get the content of the base layout.
     *
     * @param string|null $layout The name of the layout file (optional).
     * @return string|null The content of the base layout, or null if no layout is specified.
     * @throws Exception If the layout file is not found.
     */
    protected static function getBaseContent($layout)
    {
        // Check if no layout specified/
        if (!$layout)
        {

            return null;
        }

        // The path to the base layout
        $path = view_path("layouts/{$layout}.php");

        // Check if the layout file is exists.
        if (!file_exists($path))
        {

            throw new Exception("No layout file found with name {{$layout}}.", 404);
        }

        // Start output buffer.
        ob_start();

        // Include the layout file.
        include $path;

        // Get the buffered content and clear the buffer.
        return ob_get_clean();
    }


    /**
     * Get the content of the view.
     *
     * @param string|null $path The name of the view file (optional).
     * @return string|null The content of the view .
     * @throws Exception If the view file is not found.
     */
    protected static function getViewContent($path, $params = [])
    {
        $path = view_path(str_replace('.', '/', $path));
        $path = $path . '.php';

        if (!is_file($path))
        {
            throw new Exception("No view file found with name {{$path}}. ", 404);
        }

        // Inject (create) variables from params array to view.
        foreach ($params as $param => $value)
        {
            $$param = $value;
        }

        // Start output buffering.
        ob_start();

        // Include the view file.
        include $path;

        // Get the buffered content and clear the buffer.
        return ob_get_clean();
    }

    /**
     * Render an error view by retrieving its content and outputting it.
     *
     * @param string $path The path to the error view file.
     */
    public static function makeError($path)
    {
        $path = self::errorsDirectory . $path;

        $content = self::getViewContent($path);

        echo $content;
    }

    /**
     * Render an exception by retrieving its code and message and outputting them as HTML.
     *
     * @param Exception $exception The exception to render.
     */
    public static function makeException($exception)
    {

        $content = "<h3>{$exception->getCode()} - {$exception->getMessage()}</h3>";

        echo $content;
    }
}
