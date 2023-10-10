<?php

return [
    'controllers' => [
        'documents' => [
            'label' => 'Documents',
        ],
    ],
    'driver' => [
        'label' => 'Créer des documents Word',
        'description' => 'Système Worder',
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
            'form_name' => 'Gestion document',
            'is_lot' => 'Autoriser dans les lots ?',
            'label' => 'Document',
            'name' => 'Libellé document',
            'output_name' => 'Construction du nom du fichier',
            'path' => 'Source du document',
            'rule_asks' => 'Champs éditables',
            'slug' => 'Slug ou Code',
            'state' => 'État',
            'tab_edit' => 'Éditer document',
            'tab_infos' => 'Infos',
            'tab_options' => 'Options',
            'tab_temp' => 'TEMP',
            'title' => 'Gestion document',
            'map_key' => 'Spécifier un code Map ds',
            'controllers' => [
                'check' => 'Vérifier',
                'test' => 'Tester',
            ],
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
