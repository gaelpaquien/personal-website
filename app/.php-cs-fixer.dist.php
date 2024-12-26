<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('vendor')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@DoctrineAnnotation' => true,
        'concat_space' => ['spacing' => 'one'],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'declare_strict_types' => true,
        'phpdoc_summary' => false,
        'native_function_invocation' => ['include' => ['@internal'], 'scope' => 'namespaced', 'strict' => true],
        'self_accessor' => false,
        'ordered_traits' => false,
        'types_spaces' => ['space' => 'single'],
        'class_definition' => ['single_line' => false],
        'phpdoc_align' => ['align' => 'left'],
        'array_syntax' => ['syntax' => 'short'],
        'strict_param' => true,
        'binary_operator_spaces' => ['default' => 'align_single_space_minimal'],
        'single_quote' => true,
        'phpdoc_scalar' => true,
        'no_unused_imports' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
    ])
    ->setFinder($finder)
    ->setUsingCache(true)
;
