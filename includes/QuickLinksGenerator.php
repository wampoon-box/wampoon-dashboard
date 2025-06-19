<?php
declare(strict_types=1);

/**
 * Generates quick links for the dashboard.
 * The content of the htdocs directory is parsed and a link is generated for each item.
 */
class QuickLinksGenerator 
{
    private $colors;
    private $htdocs_path;
    private $server_hostname;

    public function __construct(array $config) 
    {
        $this->htdocs_path = $config['htdocs_path'];
        $this->server_hostname = $config['server_hostname'];
        if ($config['apache_port_number'] !== '80') {
            $this->server_hostname = $config['server_hostname'] . ':' . $config['apache_port_number'];
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
            '#f1c40f', // Yellow
            '#e91e63', // Pink
            '#ff5722', // Deep Orange
            '#795548', // Brown
            '#607d8b', // Blue Grey
            '#ff9800', // Amber
            '#4caf50', // Light Green
            '#673ab7'  // Deep Purple
        ];
    }

    /**
     * Get a random color from the colors array.
     */
    private function getRandomColor(): string
    {
        return $this->colors[array_rand($this->colors)];
    }

    /**
     * Generate HTML for quick links.
     */
    public function generateQuickLinks(): string
    {
        $quick_links = '';
        
        // Check if htdocs_path exists and is accessible.
        if (!file_exists($this->htdocs_path)) {
            return '<p style="color: #dc3545; font-weight: bold;">❌ Document root does not exist: ' . hsc($this->htdocs_path) . '</p>';
        }
        
        if (!is_dir($this->htdocs_path)) {
            return '<p style="color: #dc3545; font-weight: bold;">❌ Document root is not a directory: ' . hsc($this->htdocs_path) . '</p>';
        }
        
        if (!is_readable($this->htdocs_path)) {
            return '<p style="color: #dc3545; font-weight: bold;">❌ Document root is not readable: ' . hsc($this->htdocs_path) . '</p>';
        }

        $items = scandir($this->htdocs_path);
        if ($items === false) {
            return '<p style="color: #dc3545; font-weight: bold;">❌ Failed to read directory contents: ' . hsc($this->htdocs_path) . '</p>';
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
            $href = $this->server_hostname . '/' . urlencode($item);
            $random_color = $this->getRandomColor();
            
            // Generate SVG icon based on item type
            $svg_icon = $this->getSvgIcon($is_dir);
            
            $quick_links .= sprintf(
                '<a href="%s" class="btn btn-primary" target="_blank" style="background-color: %s;">%s%s</a>',
                hsc($href),
                 $random_color,                
                $svg_icon,
                hsc($item)
            );
        }

                return $quick_links;
    }

    /**
     * Set custom colors array.
     */
    public function setColors(array $colors): void
    {
        $this->colors = $colors;
    }

    /**
     * Add a new color to the colors array.
     */
    public function addColor(string $color): void
    {
        $this->colors[] = $color;
    }

    /**
     * Get current colors array.        
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * Generate SVG icon based on item type.
     */
    private function getSvgIcon(bool $is_dir): string   
    {
        if ($is_dir) {
            // Folder SVG icon.
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; vertical-align: middle;"><path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/></svg>';
        } else {
            // File SVG icon.
            return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; vertical-align: middle;"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14,2 14,8 20,8"/></svg>';
        }
    }
} 