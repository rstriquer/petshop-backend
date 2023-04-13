<?php

return [
    'preset' => 'laravel',

    'ide' => 'phpstorm',

    'exclude' => [
        '_ide_helper.php',
        'vendor/*',
    ],

    'add' => [],

    'remove' => [
        // Code
        \SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff::class,          // Declare strict types
        \SlevomatCodingStandard\Sniffs\Classes\ForbiddenPublicPropertySniff::class,       // Forbidden public property
        \PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer::class,                   // Visibility required
        \SlevomatCodingStandard\Sniffs\Classes\ClassConstantVisibilitySniff::class,       // Class constant visibility
        \SlevomatCodingStandard\Sniffs\ControlStructures\DisallowEmptySniff::class,       // Disallow empty
        \PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer::class,                             // No empty comment
        \SlevomatCodingStandard\Sniffs\Commenting\UselessFunctionDocCommentSniff::class,  // Useless function doc comment

        // Architecture
        \NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses::class,            //Normal classes are forbidden

        // Style
        \PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterCastSniff::class,  // Space after cast
        \PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterNotSniff::class,   // Space after not
        \SlevomatCodingStandard\Sniffs\Namespaces\AlphabeticallySortedUsesSniff::class,   // Alphabetically sorted uses
        \SlevomatCodingStandard\Sniffs\Commenting\DocCommentSpacingSniff::class,          // Doc comment spacing
        \PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer::class,                 // Ordered class elements
        \PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer::class,                         // Single quote
    ],

    'config' => [
        \NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh::class => [
            'maxComplexity' => 8,
        ],
        \PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff::class => [
            'lineLimit' => 120,
            'absoluteLineLimit' => 120,
            'ignoreComments' => false,
        ],
        \PhpCsFixer\Fixer\Import\OrderedImportsFixer::class => [
            'imports_order' => ['class', 'const', 'function'],
            'sort_algorithm' => 'length',
        ]
    ],

    'requirements' => [
        'min-quality' => 85,
        'min-complexity' => 85,
        'min-architecture' => 85,
        'min-style' => 85,
        'disable-security-check' => false,
    ],
];