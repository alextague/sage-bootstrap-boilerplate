<?php

namespace App\Fields\Traits;

/**
 * Module Documentation Trait
 *
 * Provides helper methods for adding standardised documentation
 * help tabs to ACF field partials (content summary + detailed help tab).
 *
 * Usage:
 *
 *   use App\Fields\Traits\ModuleDocumentation;
 *
 *   class YourModule extends Partial
 *   {
 *       use ModuleDocumentation;
 *
 *       public function fields()
 *       {
 *           $fields = new FieldsBuilder('your_module');
 *
 *           $fields
 *               ->addTab('content')
 *                   ->addFields($this->addModuleHelp(
 *                       'Module Name',
 *                       'Brief description.',
 *                       'When to use this module.',
 *                       'How to configure it.'
 *                   ))
 *                   // ... rest of content fields
 *               ->addTab('settings')
 *                   // ... settings fields
 *               ->addFields($this->addHelpTab(
 *                   'your-module',           // slug for screenshot file name
 *                   $usageGuide,             // formatted HTML string
 *                   $bestPractices           // formatted HTML string
 *               ));
 *       }
 *   }
 */
trait ModuleDocumentation
{
    /**
     * Add a brief "About This Module" message to the content tab.
     *
     * @param string $moduleName  Display name of the module.
     * @param string $description Brief description of what it does.
     * @param string $whenToUse   When to use this module.
     * @param string $howToUse    How to configure it.
     * @return \StoutLogic\AcfBuilder\FieldsBuilder
     */
    protected function addModuleHelp($moduleName, $description, $whenToUse, $howToUse)
    {
        $help = new \StoutLogic\AcfBuilder\FieldsBuilder('module_help_wrapper');

        $help->addMessage('module_help', 'message', [
            'label'    => '📖 About This Module',
            'message'  => "
                <div class=\"acf-module-help\">
                    <strong>{$moduleName}</strong><br>
                    {$description}<br><br>
                    <strong>When to use:</strong> {$whenToUse}<br><br>
                    <strong>How to use:</strong> {$howToUse}
                </div>
            ",
            'esc_html' => 0,
        ]);

        return $help;
    }

    /**
     * Add a comprehensive help tab with a design reference screenshot,
     * usage guide, and best practices.
     *
     * @param string $moduleSlug    Slug matching the screenshot filename (e.g. 'video-section').
     * @param string $usageGuide   HTML formatted usage guide.
     * @param string $bestPractices HTML formatted best-practices list.
     * @return \StoutLogic\AcfBuilder\FieldsBuilder
     */
    protected function addHelpTab($moduleSlug, $usageGuide = '', $bestPractices = '')
    {
        $help = new \StoutLogic\AcfBuilder\FieldsBuilder('help_tab_wrapper');

        $help->addTab('help', [
            'placement' => 'left',
        ]);

        // Prefer PNG, fall back to SVG
        $screenshotPath = get_template_directory_uri() . "/resources/images/admin/module-screenshots/{$moduleSlug}.svg";
        $pngPath        = get_template_directory() . "/resources/images/admin/module-screenshots/{$moduleSlug}.png";
        if (file_exists($pngPath)) {
            $screenshotPath = get_template_directory_uri() . "/resources/images/admin/module-screenshots/{$moduleSlug}.png";
        }

        $help->addMessage('design_reference', 'message', [
            'label'    => '🎨 Design Reference',
            'message'  => "
                <div class=\"acf-module-help-detail\">
                    <p><strong>Visual Example:</strong></p>
                    <img src=\"{$screenshotPath}?v=" . time() . "\" alt=\"Module design\" style=\"max-width:100%; height:auto; border:1px solid #ddd; border-radius:4px; margin-top:10px;\">
                </div>
            ",
            'esc_html' => 0,
        ]);

        if (! empty($usageGuide)) {
            $help->addMessage('usage_guide', 'message', [
                'label'    => '📋 Detailed Usage Guide',
                'message'  => "<div class=\"acf-module-help-detail\">{$usageGuide}</div>",
                'esc_html' => 0,
            ]);
        }

        if (! empty($bestPractices)) {
            $help->addMessage('best_practices', 'message', [
                'label'    => '💡 Best Practices',
                'message'  => "<div class=\"acf-module-help-detail\">{$bestPractices}</div>",
                'esc_html' => 0,
            ]);
        }

        return $help;
    }

    /**
     * Format a best-practices list with optional warnings.
     *
     * @param array $items    Positive practice items.
     * @param array $warnings Warning items (optional).
     * @return string HTML formatted list.
     */
    protected function formatBestPracticesList($items, $warnings = [])
    {
        $html = '<ul>';
        foreach ($items as $item) {
            $html .= "<li>✅ {$item}</li>";
        }
        foreach ($warnings as $warning) {
            $html .= "<li>⚠️ {$warning}</li>";
        }
        $html .= '</ul>';

        return $html;
    }

    /**
     * Format a usage guide with section headings.
     *
     * @param array $sections Array of ['Heading' => 'content'|['item1','item2']] pairs.
     * @return string HTML formatted guide.
     */
    protected function formatUsageGuide($sections)
    {
        $html = '';
        foreach ($sections as $heading => $content) {
            $html .= "<h4>{$heading}:</h4>";
            if (is_array($content)) {
                $html .= '<ul>';
                foreach ($content as $item) {
                    $html .= "<li>{$item}</li>";
                }
                $html .= '</ul>';
            } else {
                $html .= "<p>{$content}</p>";
            }
        }

        return $html;
    }

    /**
     * Return standard spacing utility class instructions for the custom_classes field.
     *
     * @return string
     */
    protected function getSpacingInstructions()
    {
        return 'Control spacing around this module. Format: sage-[property]-[size]' . "\n"
            . 'Properties: m = margin, p = padding | t = top, b = bottom | x = left+right, y = top+bottom' . "\n"
            . 'Examples: sage-mb-50 (50px bottom margin), sage-py-80 (80px top+bottom padding).' . "\n"
            . 'Size: integers 0–220 (actual pixels).';
    }
}
