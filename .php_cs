<?php

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(false)
    ->setRules([
        '@PSR2' => true,
        '@Symfony' => true,
        'array_indentation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'multiline_whitespace_before_semicolons' => true,
        'ordered_imports' => true,
        'phpdoc_to_comment' => false,
        'visibility_required' => ['property', 'method', 'const'],
        'escape_implicit_backslashes' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__ . '/src')
            ->in(__DIR__ . '/tests')
    )
;
