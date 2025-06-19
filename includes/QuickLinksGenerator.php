<?php

class QuickLinksGenerator 
{
    private $colors;
    private $htdocsPath;
    private $rootHostname;

    public function __construct($htdocsPath = '../../htdocs', $rootHostname = 'http://localhost/') 
    {
        $this->htdocsPath = $htdocsPath;
        $this->rootHostname = $rootHostname;
        
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
        $html = '';
        
        if (!is_dir($this->htdocsPath)) {
            return '<p style="color: #dc3545;">Unable to access document root</p>';
        }

        $items = scandir($this->htdocsPath);
        $items = array_filter($items, function($item) {
            return $item !== '.' && $item !== '..';
        });

        if (count($items) === 0) {
            return '<p style="color: #6c757d;">Document root is empty</p>';
        }

        foreach ($items as $item) {
            $itemPath = $this->htdocsPath . '/' . $item;
            $isDir = is_dir($itemPath);
            $iconClass = $isDir ? 'icon-folder' : 'icon-file';
            $href = $this->rootHostname . urlencode($item);
            $randomColor = $this->getRandomColor();
            
            $html .= sprintf(
                '<a href="%s" class="btn btn-primary %s" target="_blank" style="background-color: %s;">%s</a>',
                htmlspecialchars($href),
                $iconClass,
                $randomColor,
                htmlspecialchars($item)
            );
        }

        return $html;
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