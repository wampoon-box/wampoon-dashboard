/**
 * WAMPoon Dashboard - Theme Management
 * Shared theme switching functionality for all pages
 */

class ThemeManager {
    constructor() {
        this.themeToggle = null;
        this.html = document.documentElement;
        this.init();
    }

    init() {
        // Wait for DOM to be ready.
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setup());
        } else {
            this.setup();
        }
    }

    setup() {
        this.themeToggle = document.getElementById('themeToggle');
        
        if (!this.themeToggle) {
            console.warn('Theme toggle button not found');
            return;
        }

        // Apply saved theme or default to light mode.
        this.applySavedTheme();
        
        // Setup event listeners.
        this.setupEventListeners();
        
        // Update button state.
        this.updateThemeToggle();
    }

    applySavedTheme() {
        const savedTheme = localStorage.getItem('theme') || 'dark';
        this.html.setAttribute('data-theme', savedTheme);
    }

    setupEventListeners() {
        this.themeToggle.addEventListener('click', () => this.toggleTheme());
        
        // Listen for theme changes from other tabs/windows.
        window.addEventListener('storage', (e) => {
            if (e.key === 'theme') {
                this.html.setAttribute('data-theme', e.newValue || 'dark');
                this.updateThemeToggle();
            }
        });
    }

    toggleTheme() {
        const currentTheme = this.html.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        this.html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        this.updateThemeToggle();
        
        // Remove focus from the button after toggling.
        this.themeToggle.blur();
        
        // Dispatch custom event for other components that might need to know.
        window.dispatchEvent(new CustomEvent('themeChanged', { 
            detail: { theme: newTheme } 
        }));
    }

    updateThemeToggle() {
        if (!this.themeToggle) return;
        
        const currentTheme = this.html.getAttribute('data-theme');
        const sunIcon = this.themeToggle.querySelector('.sun-icon');
        const moonIcon = this.themeToggle.querySelector('.moon-icon');
        
        if (!sunIcon || !moonIcon) {
            console.warn('Theme toggle icons not found');
            return;
        }
        
        if (currentTheme === 'dark') {
            sunIcon.style.display = 'block';
            moonIcon.style.display = 'none';
            this.themeToggle.setAttribute('aria-label', 'Switch to light theme');
        } else {
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'block';
            this.themeToggle.setAttribute('aria-label', 'Switch to dark theme');
        }
    }

    getCurrentTheme() {
        return this.html.getAttribute('data-theme') || 'dark';
    }

    setTheme(theme) {
        if (theme !== 'light' && theme !== 'dark') {
            console.error('Invalid theme:', theme);
            return;
        }
        
        this.html.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        this.updateThemeToggle();
        
        window.dispatchEvent(new CustomEvent('themeChanged', { 
            detail: { theme: theme } 
        }));
    }
}

// Initialize theme manager.
const themeManager = new ThemeManager();

// Export for potential use by other scripts.
window.themeManager = themeManager;