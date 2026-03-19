<?php

namespace App\Fields\Partials;

use App\Fields\Traits\ModuleDocumentation;
use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class FreeformContent extends Partial
{
    use ModuleDocumentation;

    /**
     * The partial field group.
     */
    public function fields()
    {
        $freeformContent = new FieldsBuilder('freeform_content');

        $freeformContent
            ->addTab('content')
                ->addFields($this->addModuleHelp(
                    'Freeform Content',
                    'A flexible WYSIWYG content area with full editor capabilities and media upload for maximum editorial freedom.',
                    'Use when you need complete control over content formatting, want to insert images directly into text, or have complex content with mixed media. Perfect for importing content or when structured modules are too restrictive.',
                    'Add your content in the WYSIWYG editor with full formatting options. Insert images and media as needed. Choose text size (Regular or Small) in Settings. All images automatically receive dropshadow styling.'
                ))
                ->addWysiwyg('content', [
                    'label' => 'Content',
                    'media_upload' => 1,
                    'toolbar' => 'full',
                ])
            ->addTab('settings')
                ->addSelect('text_size', [
                    'label' => 'Text Size',
                    'choices' => [
                        'regular' => 'Regular',
                        'small' => 'Small',
                    ],
                    'default_value' => 'regular',
                ])
                ->addText('ID')
                ->addText('custom_classes', [
                    'instructions' => $this->getSpacingInstructions(),
                ])
                ->addText('custom_styles')
                ->addFields($this->addHelpTab(
                    'freeform-content',
                    $this->formatUsageGuide([
                        'What This Module Does' => 'Freeform Content provides a single WYSIWYG editor with full toolbar and media upload capabilities. Content displays in a centered container (18/24 columns on desktop). Unlike structured modules, you have complete control over formatting and layout.',
                        'Text Size Options' => 'Choose **Regular** (20px, default paragraph size) for standard content, or **Small** (16px) for more compact text. Regular is more readable - use Small sparingly for dense content or secondary information.',
                        'WYSIWYG Editor Features' => 'Full WordPress editor with all formatting options: headings, bold, italic, lists, links, alignment, blockquotes, tables, and more. Media upload enabled - insert images, videos, and files directly using the "Add Media" button.',
                        'Layout & Responsive Behavior' => 'Content is centered in an 18-column container on large screens with 3-column offsets on each side. Stacks to full width on mobile and tablet for optimal readability.',
                        'When to Use This vs Text Module' => '**Use Freeform Content** when you need images within text, complex formatting, or maximum flexibility. **Use Text Module** for simple title + body copy with predefined layouts (centered, left-aligned, 2-column).',
                    ]),
                    $this->formatBestPracticesList(
                        [
                            'Use when you need complete editorial control without layout restrictions',
                            'Ideal for complex content with mixed media, tables, or custom formatting',
                            'Optimize images before uploading through the editor',
                            'Keep content manageable - split very long content into multiple modules',
                            'Use Regular text size for better readability',
                            'Test media embeds (videos, iframes) to ensure they\'re responsive',
                            'Consider structured modules (Text, Image & Text 50/50) for simpler content',
                            'Use HTML ID field for anchor links to specific content sections',
                        ],
                        [
                            'Don\'t upload extremely large images without optimization',
                            'Avoid using Small text size for primary content (harder to read)',
                            'Don\'t override the centered layout unless necessary',
                        ]
                    )
                ));

        return $freeformContent;
    }
}
