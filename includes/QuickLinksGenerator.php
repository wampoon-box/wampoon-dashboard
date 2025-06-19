<?php

class QuickLinksGenerator 
{
    private $colors;
    private $htdocs_path;
    private $root_hostname;

    public function __construct($htdocs_path = '../../htdocs', $root_hostname = 'http://localhost') 
    {
        $this->htdocs_path = $htdocs_path;
        $this->root_hostname = $root_hostname;
        if (APACHE_PORT_NUMBER !== '80') {
            $this->root_hostname = $root_hostname . ':' . APACHE_PORT_NUMBER;
        }
        
        // Array of attractive colors for buttons.
        $this->colors = [
            '#3498db', // Blue
            '#e74c3c', // Red
            '#2ecc71', // Green
            '#f39c12', // Orange
            '#9b59b6', // Purple
            '#1abc9c', // Turquoise
            '#e67e22', // Dark Orange
            '#34495e', // Dark Blue
            '#16a085', // Dark Green
            '#8e44ad', // Dark Purple
            '#27ae60', // Emerald
            '#d35400', // Pumpkin
            '#c0392b', // Dark Red
            '#2980b9', // Dark Blue
            '#f1c40f'  // Yellow
        ];
    }

    /**
     * Get a random color from the colors array.
     */
    private function getRandomColor() 
    {
        return $this->colors[array_rand($this->colors)];
    }

    /**
     * Generate HTML for quick links.
     */
    public function generateQuickLinks() 
    {
        $quick_links = '';
        
        // Check if htdocs_path exists and is accessible.
        if (!file_exists($this->htdocs_path)) {
            return '<p style="color: #dc3545; font-weight: bold;">❌ Document root does not exist: ' . htmlspecialchars($this->htdocs_path) . '</p>';
        }
        
        if (!is_dir($this->htdocs_path)) {
            return '<p style="color: #dc3545; font-weight: bold;">❌ Document root is not a directory: ' . htmlspecialchars($this->htdocs_path) . '</p>';
        }
        
        if (!is_readable($this->htdocs_path)) {
            return '<p style="color: #dc3545; font-weight: bold;">❌ Document root is not readable: ' . htmlspecialchars($this->htdocs_path) . '</p>';
        }

        $items = scandir($this->htdocs_path);
        if ($items === false) {
            return '<p style="color: #dc3545; font-weight: bold;">❌ Failed to read directory contents: ' . htmlspecialchars($this->htdocs_path) . '</p>';
        }
        
        $items = array_filter($items, function($item) {
            return $item !== '.' && $item !== '..';
        });

        if (count($items) === 0) {
            return '<p style="color: #6c757d;">Document root is empty</p>';
        }

        foreach ($items as $item) {
            $item_path = $this->htdocs_path . '/' . $item;
            $is_dir = is_dir($item_path);
            $icon_class = $is_dir ? 'icon-folder' : 'icon-file';
            $href = $this->root_hostname . '/' . urlencode($item);
            $random_color = $this->getRandomColor();
            
            $quick_links .= sprintf(
                '<a href="%s" class="btn btn-primary %s" target="_blank" style="background-color: %s;">%s</a>',
                htmlspecialchars($href),
                $icon_class,
                $random_color,
                htmlspecialchars($item)
            );
        }

        return $quick_links;
    }

    /**
     * Set custom colors array.
     */
    public function setColors(array $colors) 
    {
        $this->colors = $colors;
    }

    /**
     * Add a new color to the colors array.
     */
    public function addColor($color) 
    {
        $this->colors[] = $color;
    }

    /**
     * Get current colors array.        
     */
    public function getColors() 
    {
        return $this->colors;
    }
} 