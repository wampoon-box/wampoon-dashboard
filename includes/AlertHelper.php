<?php
declare(strict_types=1);

/**
 * Helper class for generating styled alert components.
 */
class AlertHelper
{
    /**
     * Render a styled alert HTML.
     *
     * @param string $type Alert type: 'danger' or 'warning'
     * @param string $title Alert title
     * @param string $message Alert message
     */
    public static function render(string $type, string $title, string $message): string
    {
        $icon = $type === 'danger' ? self::getDangerIcon() : self::getWarningIcon();

        return sprintf(
            '<div class="alert alert-%s">%s<div class="alert-content"><div class="alert-title">%s</div><div class="alert-message">%s</div></div></div>',
            hsc($type),
            $icon,
            hsc($title),
            hsc($message)
        );
    }

    /**
     * Get danger/error icon SVG.
     */
    private static function getDangerIcon(): string
    {
        return '<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';
    }

    /**
     * Get warning icon SVG.
     */
    private static function getWarningIcon(): string
    {
        return '<svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';
    }
}
