<?php

declare(strict_types=1);

use SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff;
use SlevomatCodingStandard\Sniffs\Classes\ForbiddenPublicPropertySniff;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use SlevomatCodingStandard\Sniffs\Classes\ClassConstantVisibilitySniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowEmptySniff;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use SlevomatCodingStandard\Sniffs\Commenting\UselessFunctionDocCommentSniff;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterCastSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterNotSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\AlphabeticallySortedUsesSniff;
use SlevomatCodingStandard\Sniffs\Commenting\DocCommentSpacingSniff;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;

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
        DeclareStrictTypesSniff::class,          // Declare strict types
        ForbiddenPublicPropertySniff::class,       // Forbidden public property
        VisibilityRequiredFixer::class,                   // Visibility required
        ClassConstantVisibilitySniff::class,       // Class constant visibility
        DisallowEmptySniff::class,       // Disallow empty
        NoEmptyCommentFixer::class,                             // No empty comment
        UselessFunctionDocCommentSniff::class,  // Useless function doc comment

        // Architecture
        ForbiddenNormalClasses::class,            //Normal classes are forbidden

        // Style
        SpaceAfterCastSniff::class,  // Space after cast
        SpaceAfterNotSniff::class,   // Space after not
        AlphabeticallySortedUsesSniff::class,   // Alphabetically sorted uses
        DocCommentSpacingSniff::class,          // Doc comment spacing
        OrderedClassElementsFixer::class,                 // Ordered class elements
        SingleQuoteFixer::class,                         // Single quote
    ],

    'config' => [
        CyclomaticComplexityIsHigh::class => [
            'maxComplexity' => 8,
        ],
        LineLengthSniff::class => [
            'lineLimit' => 120,
            'absoluteLineLimit' => 120,
            'ignoreComments' => false,
        ],
        OrderedImportsFixer::class => [
            'imports_order' => ['class', 'const', 'function'],
            'sort_algorithm' => 'length',
        ],
    ],

    'requirements' => [
        'min-quality' => 85,
        'min-complexity' => 85,
        'min-architecture' => 85,
        'min-style' => 85,
        'disable-security-check' => false,
    ],
];
