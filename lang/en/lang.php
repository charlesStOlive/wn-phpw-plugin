<?php

return [
    'controllers' => [
        'documents' => [
            'label' => 'Documents',
        ],
    ],
    'driver' => [
        'description' => 'Worder System',
        'label' => 'Create Word documents',
    ],
    'menu' => [
        'bloc_type' => 'Block type',
        'bloc_type_description' => 'Description',
        'documents' => 'Words',
        'documents_description' => 'Management of Word templates',
        'settings_category' => 'Wakaari Template',
    ],
    'models' => [
        'document' => [
            'controllers' => [
                'check' => 'Check',
                'test' => 'Test',
            ],
            'is_lot' => 'Allow in batches?',
            'label' => 'Document',
            'map_key' => 'Specify a Map code in',
            'name' => 'Document label',
            'output_name' => 'File name construction',
            'path' => 'Document source',
            'slug' => 'Slug or Code',
            'tab_infos' => 'Infos',
        ],
    ],
    'word' => [
        'processor' => [
            'bad_format' => 'Incorrect tag format',
            'bad_tag' => 'Incorrect type of tag',
            'document_not_exist' => 'The source of the document was not found',
        ],
    ],
];
