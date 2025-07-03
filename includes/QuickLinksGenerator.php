<?php
declare(strict_types=1);

/**
 * Generates quick links for the dashboard.
 * The content of the htdocs directory is parsed and a link is generated for each item.
 */
class QuickLinksGenerator 
{
    private $folder_color_scheme;
    private $file_color_scheme;
    private $htdocs_path;
    private $server_hostname;
    private $used_color_indices;

    public function __construct(array $config) 
    {
        $this->htdocs_path = $config['htdocs_path'];
        $this->server_hostname = $config['server_hostname'];
        if ($config['apache_port_number'] !== '80') {
            $this->server_hostname = $config['server_hostname'] . ':' . $config['apache_port_number'];
        }
        
        // Initialize color tracking
        $this->used_color_indices = [];
        
        // Color scheme - using progressive border colors for visual distinction
        $this->folder_color_scheme = [
            'blue' => ['500', '600', '700'],
            'green' => ['500', '600', '700'],
            'amber' => ['500', '600', '700'],
        ];
        
        // File color scheme - using different color families for files
        $this->file_color_scheme = [
            'red' => ['500', '600', '700'],
            'gray' => ['500', '600', '700'],
        ];
    }

    /**
     * Get a deterministic CSS class based on item name and type.
     */
    private function getColorClassForItem(string $item_name, bool $is_dir): string
    {
        $color_scheme = $is_dir ? $this->folder_color_scheme : $this->file_color_scheme;
        $color_families = array_keys($color_scheme);
        
        // Create a hash of the item name for consistent color assignment
        $hash = crc32($item_name);
        $family_index = abs($hash) % count($color_families);
        $color_family = $color_families[$family_index];
        
        // Get a progressive shade within the family
        $shades = $color_scheme[$color_family];
        $shade_index = count($this->used_color_indices) % count($shades);
        $shade = $shades[$shade_index];
        
        // Track this color index as used
        $color_key = $color_family . '-' . $shade;
        $this->used_color_indices[] = $color_key;
        
        return "link-border-{$color_family}-{$shade}";
    }

    /**
     * Generate HTML for quick links.
     */
    public function generateQuickLinks(): string
    {
        $quick_links = '';
        
        // Reset used color indices for each generation.
        $this->used_color_indices = [];
        
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
            $color_class = $this->getColorClassForItem($item, $is_dir);
            
            // Generate SVG icon based on item type.
            $svg_icon = $this->getSvgIcon($is_dir);
            
            $quick_links .= sprintf(
                '<a href="%s" class="btn btn-primary %s" target="_blank">%s%s</a>',
                hsc($href),
                $color_class,              
                $svg_icon,
                hsc($item)
            );
        }

        return $quick_links;
    }

    /**
     * Set custom folder color scheme.
     */
    public function setFolderColorScheme(array $color_scheme): void
    {
        $this->folder_color_scheme = $color_scheme;
    }

    /**
     * Set custom file color scheme.
     */
    public function setFileColorScheme(array $color_scheme): void
    {
        $this->file_color_scheme = $color_scheme;
    }

    /**
     * Add a new color family to the folder color scheme.
     */
    public function addFolderColorFamily(string $family, array $shades): void
    {
        $this->folder_color_scheme[$family] = $shades;
    }

    /**
     * Add a new color family to the file color scheme.
     */
    public function addFileColorFamily(string $family, array $shades): void
    {
        $this->file_color_scheme[$family] = $shades;
    }

    /**
     * Get current folder color scheme.        
     */
    public function getFolderColorScheme(): array
    {
        return $this->folder_color_scheme;
    }

    /**
     * Get current file color scheme.        
     */
    public function getFileColorScheme(): array
    {
        return $this->file_color_scheme;
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