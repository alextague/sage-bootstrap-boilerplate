<?php

namespace App\Fields\Partials;

use App\Fields\Traits\ModuleDocumentation;
use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Text extends Partial
{
    use ModuleDocumentation;

    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $text = new FieldsBuilder('text');

        $text
            ->addTab('content')
                ->addFields($this->addModuleHelp(
                    'Text',
                    'Flexible text content module with three layout variations: centered, left-aligned with optional eyebrow, or two-column side-by-side.',
                    'One of the most commonly used modules for body content, introductions, section text, and any text-heavy sections. Use centered for statements, left-aligned for informational content, or two-column for side-by-side layouts.',
                    'Add title and copy, choose title size (regular or larger), then select column layout in Settings. The eyebrow field appears only when "1 Column Left Aligned" is selected.'
                ))
                ->addText('title')
                ->addSelect('title_size', [
                    'choices' => [
                        'regular' => 'Regular',
                        'larger' => 'Larger',
                    ],
                    'default_value' => 'regular',
                ])
                ->addWysiwyg('copy', [
                    'media_upload' => 0,
                    'toolbar' => 'basic',
                ])
            ->addTab('settings')
                ->addSelect('columns', [
                    'choices' => [
                        '1_column_centered' => '1 Column Centered',
                        '1_column_left_aligned' => '1 Column Left Aligned',
                        '2_columns' => '2 Columns',
                    ],
                    'default_value' => '1_column_centered',
                ])
                ->addText('eyebrow')
                    ->conditional('columns', '==', '1_column_left_aligned')
                ->addText('ID')
                ->addText('custom_classes', [
                    'instructions' => $this->getSpacingInstructions(),
                ])
                ->addText('custom_styles')
                ->addFields($this->addHelpTab(
                    'text',
                    $this->formatUsageGuide([
                        'Layout Variations' => 'Choose from three layouts: **1 Column Centered** (title and copy centered, narrow width) for impactful statements, **1 Column Left Aligned** (with optional eyebrow label) for informational content, or **2 Columns** (title on left, copy on right) for side-by-side presentations.',
                        'Title Sizing' => 'Choose **Regular** for standard h2 styling (48px) or **Larger** for h1 styling (64px). Use larger sparingly (1-2 per page max) for hero sections or primary focus areas. Both use h3 HTML tags for proper SEO hierarchy.',
                        'Eyebrow Text' => 'Only available for "1 Column Left Aligned" layout. Add 1-3 word category labels or descriptive headers that appear above the title in uppercase mid-blue text.',
                        'WYSIWYG Copy' => 'Full rich text editor with basic formatting: bold, italic, headings, lists, links, blockquotes, and alignment. Media upload is disabled - use other modules for images.',
                        'Column Widths' => 'Centered and left-aligned layouts use single wide columns. Two-column layout splits content: title takes 7/24 columns, copy takes 10/24 columns on desktop. All layouts stack to full width on mobile.',
                        'When to Use Each Layout' => '**Centered**: Introductions, statements, formal messaging. **Left Aligned**: Longer text, casual tone, labeled sections. **Two Columns**: Comparisons, Q&A format, breaking up single-column monotony.',
                    ]),
                    $this->formatBestPracticesList(
                        [
                            'Keep titles concise (3-10 words)',
                            'Use larger title size sparingly (1-2 per page maximum)',
                            'Eyebrow text should be 1-3 words (category/label)',
                            'Centered layout works best for short, impactful statements',
                            'Left-aligned layout works best for longer copy',
                            'Two-column layout adds visual variety to pages',
                            'Break up very long copy with multiple text modules',
                            'Use WYSIWYG formatting for emphasis and structure',
                        ],
                        [
                            'Don\'t use larger title size for every text module',
                            'Avoid very long titles (breaks layout)',
                            'Don\'t mix layout styles inconsistently on same page',
                        ]
                    )
                ));

        return $text;
    }
}
