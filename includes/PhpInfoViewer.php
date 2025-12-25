<?php
declare(strict_types=1);
/**
 * PHP Information Viewer Class.
 * Handles PHP information display with navigation and content generation.
 */
class PhpInfoViewer
{
    private $options;
    private $display;
    private $phpinfo_content;
    
    public function __construct()
    {
        $this->options = array(
            'GENERAL',
            'PHP CONFIGURATION',
            'SYSTEM ENV. VARS',
            'APACHE VARIABLES', 
            'MODULES',
            'XDEBUG',
            'EXTENSIONS',
            'PHP VARIABLES',
            'CREDITS',
            'LICENSE',
            'ALL'
        );
        
        $this->display = $this->getDisplayOption();
    }
    
    /**
     * Get the display option from GET parameter.
     */
    private function getDisplayOption()
    {
        $display = isset($_GET['display']) ? strtoupper($_GET['display']) : 'ALL';
        return in_array($display, $this->options) ? $display : 'ALL';
    }
    
    /**
     * Get available options.
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * Get current display option.
     */
    public function getCurrentDisplay()
    {
        return $this->display;
    }
    
    /**
     * Generate navigation buttons HTML.
     */
    public function generateNavigation()
    {
        $html = '<div class="phpinfo-navigation">';
        $html .= '<div class="phpinfo-nav-header">';
        $html .= '<div class="phpinfo-nav-icon">';
        $html .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">';
        $html .= '<circle cx="12" cy="12" r="3"></circle>';
        $html .= '<path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>';
        $html .= '</svg>';
        $html .= '</div>';
        $html .= '<div>';
        $html .= '<h3>Information Sections</h3>';
        $html .= '<p class="phpinfo-nav-subtitle">Select a category to explore</p>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="nav-buttons">';

        foreach ($this->options as $option) {
            $isActive = ($option == $this->display);
            $activeClass = $isActive ? 'active' : '';
            $ariaCurrent = $isActive ? ' aria-current="page"' : '';
            $url = 'phpinfo.php?display=' . $option;
            $html .= '<a href="' . htmlspecialchars($url) . '" class="nav-button ' . $activeClass . '"' . $ariaCurrent . '>';
            $html .= '<span class="nav-button-text">' . htmlspecialchars($option) . '</span>';
            $html .= '</a>';
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }
    
    /**
     * Generate PHP info content based on display option.
     */
    public function generateContent()
    {
        ob_start();
        
        switch ($this->display) {
            case 'PHP CONFIGURATION':
                phpinfo(INFO_CONFIGURATION);
                break;
            case 'SYSTEM ENV. VARS':
                phpinfo(INFO_ENVIRONMENT);
                break;
            case 'APACHE VARIABLES':
                $this->generateApacheInfo();
                break;
            case 'MODULES':
                phpinfo(INFO_MODULES);
                break;
            case 'XDEBUG':
                $this->generateXdebugInfo();
                break;
            case 'PHP VARIABLES':
                phpinfo(INFO_VARIABLES);
                break;
            case 'GENERAL':
                phpinfo(INFO_GENERAL);
                break;
            case 'EXTENSIONS':
                $this->generateExtensionsInfo();
                break;
            case 'CREDITS':
                phpinfo(INFO_CREDITS);
                break;
            case 'LICENSE':
                phpinfo(INFO_LICENSE);
                break;
            case 'ALL':
            default:
                phpinfo();
                break;
        }
        
        $this->phpinfo_content = ob_get_clean();
        
        // Process extensions special case
        if ($this->display == 'EXTENSIONS') {
            $this->processExtensionsContent();
        }
        
        return $this->extractBodyContent();
    }
    
    /**
     * Generate Apache server information.
     */
    private function generateApacheInfo()
    {
        echo '<div class="center">';
        echo '<h2>Apache Server Environment</h2>';
        echo '<table cellpadding="3">';
        echo '<tr class="h"><th>Variable</th><th>Value</th></tr>';
        
        $apache_vars = array(
            // HTTP Headers
            'HTTP_HOST',
            'HTTP_CONNECTION',
            'HTTP_SEC_CH_UA',
            'HTTP_SEC_CH_UA_MOBILE',
            'HTTP_SEC_CH_UA_PLATFORM',
            'HTTP_DNT',
            'HTTP_UPGRADE_INSECURE_REQUESTS',
            'HTTP_USER_AGENT',
            'HTTP_ACCEPT',
            'HTTP_SEC_FETCH_SITE',
            'HTTP_SEC_FETCH_MODE',
            'HTTP_SEC_FETCH_USER',
            'HTTP_SEC_FETCH_DEST',
            'HTTP_REFERER',
            'HTTP_ACCEPT_ENCODING',
            'HTTP_ACCEPT_LANGUAGE',
            'HTTP_COOKIE',
            
            // System Environment
            'PATH',
            'SystemRoot',
            'COMSPEC',
            'PATHEXT',
            'WINDIR',
            
            // Server Information
            'SERVER_SIGNATURE',
            'SERVER_SOFTWARE',
            'SERVER_NAME',
            'SERVER_ADDR',
            'SERVER_PORT',
            'REMOTE_ADDR',
            'DOCUMENT_ROOT',
            'REQUEST_SCHEME',
            'CONTEXT_PREFIX',
            'CONTEXT_DOCUMENT_ROOT',
            'SERVER_ADMIN',
            'SCRIPT_FILENAME',
            'REMOTE_PORT',
            'GATEWAY_INTERFACE',
            'SERVER_PROTOCOL',
            'REQUEST_METHOD',
            'QUERY_STRING',
            'REQUEST_URI',
            'SCRIPT_NAME'
        );
        
        foreach ($apache_vars as $var) {
            $rawValue = isset($_SERVER[$var]) && $_SERVER[$var] !== '' ? $_SERVER[$var] : '';
            $value = $rawValue !== '' ? htmlspecialchars($rawValue, ENT_QUOTES, 'UTF-8') : '<em>no value</em>';
            echo '<tr><td class="e">' . htmlspecialchars($var) . '</td>';
            echo '<td class="v">' . $value . '</td></tr>';
        }
        
        echo '</table>';
        echo '</div>';
    }

    /**
     * Generate Xdebug information.
     */
    private function generateXdebugInfo()
    {
        if (function_exists('xdebug_info')) {
            xdebug_info();
        } else {
            echo '<div class="center">';
            echo '<h2>Xdebug Information</h2>';
            echo '<p>Xdebug is not installed or not enabled.</p>';
            echo '</div>';
        }
    }
    
    /**
     * Generate initial extensions info (will be processed further).
     */
    private function generateExtensionsInfo()
    {
        phpinfo(INFO_CREDITS);
    }
    
    /**
     * Process extensions content to show detailed extension info.
     */
    private function processExtensionsContent()
    {
        $str = '<body><div class="center">';
        $this->phpinfo_content = substr($this->phpinfo_content, 0, strpos($this->phpinfo_content . $str, $str) + strlen($str));
        
        ob_start();
        
        echo '<h2>Enabled PHP Extensions</h2>' . PHP_EOL;
        echo '<table cellpadding="3">' . PHP_EOL;
        echo '<tr><td class="v">' . PHP_EOL;
        
        $extensions = get_loaded_extensions();
        echo implode(', ', $extensions) . PHP_EOL;
        
        echo '</td></tr></table>' . PHP_EOL;
        echo '<h2>Function List by Extension</h2>' . PHP_EOL;
        echo '<table cellpadding="3">' . PHP_EOL;
        echo '<tr class="h"><th>Extension</th><th>Functions</th></tr>' . PHP_EOL;
        
        foreach ($extensions as $ext) {
            echo '<tr><td class="e">' . htmlspecialchars($ext) . '</td><td class="v">';
            $functions = get_extension_funcs($ext);
            if (is_array($functions)) {
                echo implode(', ', array_map('htmlspecialchars', $functions)) . PHP_EOL;
            } else {
                echo 'No functions available' . PHP_EOL;
            }
            echo '</td></tr>' . PHP_EOL;
        }
        
        echo '</table>' . PHP_EOL;
        echo '</div>' . PHP_EOL;
        echo '</body>' . PHP_EOL . '</html>' . PHP_EOL;
        
        $this->phpinfo_content .= ob_get_contents();
        ob_end_clean();
    }
    
    /**
     * Extract body content from phpinfo output.
     */
    private function extractBodyContent()
    {
        $pattern = '/<body[^>]*>(.*?)<\/body>/is';
        if (preg_match($pattern, $this->phpinfo_content, $matches)) {
            return $matches[1];
        }
        
        return $this->phpinfo_content;
    }
}