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
            error_log("Wampoon Dashboard: Document root does not exist: " . $this->htdocs_path);
            return AlertHelper::render('danger', 'Configuration Error', 'Document root does not exist.');
        }

        if (!is_dir($this->htdocs_path)) {
            error_log("Wampoon Dashboard: Document root is not a directory: " . $this->htdocs_path);
            return AlertHelper::render('danger', 'Configuration Error', 'Document root is not a directory.');
        }

        if (!is_readable($this->htdocs_path)) {
            error_log("Wampoon Dashboard: Document root is not readable: " . $this->htdocs_path);
            return AlertHelper::render('danger', 'Configuration Error', 'Document root is not readable.');
        }

        // Resolve real path for security validation
        $realHtdocsPath = realpath($this->htdocs_path);
        if ($realHtdocsPath === false) {
            error_log("Wampoon Dashboard: Failed to resolve document root path: " . $this->htdocs_path);
            return AlertHelper::render('danger', 'Configuration Error', 'Invalid document root path.');
        }

        $items = scandir($this->htdocs_path);
        if ($items === false) {
            error_log("Wampoon Dashboard: Failed to read directory contents: " . $this->htdocs_path);
            return AlertHelper::render('danger', 'Configuration Error', 'Failed to read directory contents.');
        }
        
        $items = array_filter($items, function($item) use ($realHtdocsPath) {
            if ($item === '.' || $item === '..') {
                return false;
            }
            $item_path = $realHtdocsPath . DIRECTORY_SEPARATOR . $item;
            $realItemPath = realpath($item_path);
            // Validate path stays within htdocs (prevent traversal)
            if ($realItemPath === false || strpos($realItemPath, $realHtdocsPath) !== 0) {
                return false;
            }
            // Only include directories and .php files
            return is_dir($realItemPath) || pathinfo($item, PATHINFO_EXTENSION) === 'php';
        });

        if (count($items) === 0) {
            return AlertHelper::render('warning', 'No Projects Found', 'Document root is empty. Add folders or PHP files to see them here.');
        }

        foreach ($items as $item) {
            $item_path = $realHtdocsPath . DIRECTORY_SEPARATOR . $item;
            $realItemPath = realpath($item_path);
            // Skip items that fail path validation
            if ($realItemPath === false || strpos($realItemPath, $realHtdocsPath) !== 0) {
                continue;
            }
            $is_dir = is_dir($realItemPath);
            $href = $this->server_hostname . '/' . urlencode($item);
            $color_class = $this->getColorClassForItem($item, $is_dir);
            
            // Generate SVG icon based on item type.
            $svg_icon = $this->getSvgIcon($is_dir);
            
            $btn_class = $is_dir ? 'btn btn-folder' : 'btn btn-file';
            
            $quick_links .= sprintf(
                '<a href="%s" class="%s" target="_blank" rel="noopener noreferrer">%s%s<span class="visually-hidden"> (opens in new tab)</span></a>',
                hsc($href),
                $btn_class,
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
            return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" style="margin-right: 8px; vertical-align: middle; opacity: 0.9;"><path d="M10 4H4c-1.11 0-2 .89-2 2v12c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2h-8l-2-2z"/></svg>';
        } else {
            // Code brackets icon for PHP files.
            return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="margin-right: 8px; vertical-align: middle;"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>';
        }
    }
} 