<?php

return [
    'controllers' => [
        'documents' => [
            'label' => 'Documents',
        ],
    ],
    'driver' => [
        'description' => 'Système Worder',
        'label' => 'Créer des documents Word',
    ],
    'menu' => [
        'bloc_type' => 'Type de bloc',
        'bloc_type_description' => 'Description',
        'documents' => 'Words',
        'documents_description' => 'Gestion des modèles Word',
        'settings_category' => 'Wakaari Modèle',
    ],
    'models' => [
        'document' => [
            'controllers' => [
                'check' => 'Vérifier',
                'test' => 'Tester',
            ],
            'is_lot' => 'Autoriser dans les lots ?',
            'label' => 'Document',
            'map_key' => 'Spécifier un code Map ds',
            'name' => 'Libellé document',
            'output_name' => 'Construction du nom du fichier',
            'path' => 'Source du document',
            'slug' => 'Slug ou Code',
            'tab_infos' => 'Infos',
        ],
    ],
    'word' => [
        'processor' => [
            'bad_format' => 'Format du tag incorrect',
            'bad_tag' => 'Le type de tag est incorrect',
            'document_not_exist' => 'La source du document n\'a pas été trouvée',
        ],
    ],
];
