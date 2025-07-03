<?php
declare(strict_types=1);

/**
 * Generates quick links for the dashboard.
 * The content of the htdocs directory is parsed and a link is generated for each item.
 */
class QuickLinksGenerator 
{
    private $folder_colors;
    private $file_colors;
    private $htdocs_path;
    private $server_hostname;
    private $used_colors;

    public function __construct(array $config) 
    {
        $this->htdocs_path = $config['htdocs_path'];
        $this->server_hostname = $config['server_hostname'];
        if ($config['apache_port_number'] !== '80') {
            $this->server_hostname = $config['server_hostname'] . ':' . $config['apache_port_number'];
        }
        
        // Initialize color tracking
        $this->used_colors = [];
        
        // Folder colors - warmer, more vibrant tones
        $this->folder_colors = [
            '#3498db', // Blue
            '#2ecc71', // Green
            '#9b59b6', // Purple
            '#1abc9c', // Turquoise
            '#27ae60', // Emerald
            '#2980b9', // Dark Blue
            '#4caf50', // Light Green
            '#673ab7', // Deep Purple
            '#16a085', // Dark Green
            '#8e44ad', // Dark Purple
            '#607d8b', // Blue Grey
        ];
        
        // File colors - cooler, more professional tones
        $this->file_colors = [
            '#e74c3c', // Red
            '#f39c12', // Orange
            '#e67e22', // Dark Orange
            '#34495e', // Dark Blue
            '#d35400', // Pumpkin
            '#c0392b', // Dark Red
            '#f1c40f', // Yellow
            '#e91e63', // Pink
            '#ff5722', // Deep Orange
            '#795548', // Brown
            '#ff9800', // Amber
        ];
    }

    /**
     * Get a deterministic color based on item name and type.
     */
    private function getColorForItem(string $item_name, bool $is_dir): string
    {
        $colors = $is_dir ? $this->folder_colors : $this->file_colors;
        
        // Create a hash of the item name for consistent color assignment.
        $hash = crc32($item_name);
        $color_index = abs($hash) % count($colors);
        $color = $colors[$color_index];
        
        // If color is already used, try to find an unused one.
        $attempt = 0;
        while (in_array($color, $this->used_colors) && $attempt < count($colors)) {
            $color_index = ($color_index + 1) % count($colors);
            $color = $colors[$color_index];
            $attempt++;
        }
        
        // Track this color as used.
        $this->used_colors[] = $color;
        
        return $color;
    }

    /**
     * Generate HTML for quick links.
     */
    public function generateQuickLinks(): string
    {
        $quick_links = '';
        
        // Reset used colors for each generation.
        $this->used_colors = [];
        
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
            $item_color = $this->getColorForItem($item, $is_dir);
            
            // Generate SVG icon based on item type.
            $svg_icon = $this->getSvgIcon($is_dir);
            
            $quick_links .= sprintf(
                '<a href="%s" class="btn btn-primary" target="_blank" style="background-color: %s;">%s%s</a>',
                hsc($href),
                $item_color,                
                $svg_icon,
                hsc($item)
            );
        }

        return $quick_links;
    }

    /**
     * Set custom folder colors array.
     */
    public function setFolderColors(array $colors): void
    {
        $this->folder_colors = $colors;
    }

    /**
     * Set custom file colors array.
     */
    public function setFileColors(array $colors): void
    {
        $this->file_colors = $colors;
    }

    /**
     * Add a new color to the folder colors array.
     */
    public function addFolderColor(string $color): void
    {
        $this->folder_colors[] = $color;
    }

    /**
     * Add a new color to the file colors array.
     */
    public function addFileColor(string $color): void
    {
        $this->file_colors[] = $color;
    }

    /**
     * Get current folder colors array.        
     */
    public function getFolderColors(): array
    {
        return $this->folder_colors;
    }

    /**
     * Get current file colors array.        
     */
    public function getFileColors(): array
    {
        return $this->file_colors;
    }

    /**
     * Generate SVG icon based on item type.
     */
    private function getSvgIcon(bool $is_dir): string   
    {
        if ($is_dir) {
            // Modern folder SVG icon with fill.
            return '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px; vertical-align: middle; opacity: 0.9;"><path d="M10 4H4c-1.11 0-2 .89-2 2v12c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2h-8l-2-2z"/></svg>';
        } else {
            // Modern document SVG icon with fill.
            return '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 8px; vertical-align: middle; opacity: 0.9;"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/></svg>';
        }
    }
} 