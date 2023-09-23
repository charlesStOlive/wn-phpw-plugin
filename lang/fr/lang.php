<?php

return [
    'document' => [
        'scopes' => [
            'id' => 'ID recherché',
            'id_com' => 'Vous pouvez ajouter plusieurs ID',
            'self' => 'Fonction de restriction liée à l\'id de ce modèle ?',
            'target' => 'Relation de la cible',
            'target_com' => 'Ecrire le nom de la relation les relations parentes ne sont pas disponible',
        ],
        'title' => 'Créer document',
    ],
    'driver' => [
        'label' => 'Créer des documents word',
    ],
    'menu' => [
        'bloc_type' => 'Type de bloc',
        'bloc_type_description' => 'Description',
        'documents' => 'Words',
        'documents_description' => 'Gestion des modèles words',
        'settings_category' => 'Wakaari Modèle',
    ],
    'models' => [
        'document' => [
            'check' => 'Verifier',
            'create' => 'Créer document',
            'form_name' => 'Gestion document',
            'is_lot' => 'Autoriser dans les lots ?',
            'name' => 'libellé document',
            'output_name' => 'Construction du nom du fichier',
            'path' => 'Source du document',
            'preview_name' => 'Voir document',
            'rule_asks' => 'Champs éditables',
            'rule_conditions' => 'Conditions',
            'rule_fncs' => 'Fonctions éditables',
            'slug' => 'Slug ou Code',
            'state' => 'État',
            'tab_attributs' => 'Attributs',
            'tab_edit' => 'Editer document',
            'tab_infos' => 'Infos',
            'tab_options' => 'Options',
            'tab_session' => 'Session',
            'tab_temp' => 'TEMP',
            'test' => 'Tester',
            'title' => 'Gestion document',
            'update' => 'Modification document',
            'waka_session' => 'Clef pour LP',
            'label' => 'Document',
        ],
    ],
    'word' => [
        'error' => null,
        'processor' => [
            'bad_format' => 'Fromat du tag incorrect',
            'bad_tag' => 'Le type de tag est incorrect',
            'document_not_exist' => ' La source du document n\'a pas été trouvé',
            'errors' => 'Ce document à des erreurs, veuillez les corriger.',
            'field_not_existe' => 'Le champs n\'existe pas',
            'id_not_exist' => 'L\'id n\'existe pas',
            'success' => 'Le systhème n\'a pas trouvé d\'erreurs. Pensez à verifier votre document après édition',
        ],
    ],
    'controllers' => [
        'documents' => [
            'label' => 'Documents',
        ],
    ],
];
