<?php

return [
    'bloc' => [
        'bloc_name' => 'name',
        'bloc_name_ex' => 'Link to document',
        'bloc_type' => 'Content type',
        'code' => 'Code',
        'name' => 'Entitled',
        'name_ex' => 'Only used in the soundtrack',
        'nb_content' => 'variant',
        'opt_section' => 'List of options',
        'opt_section_com' => 'If empty: no options',
        'version' => 'Versions'
    ],
    'bloc_name' => [
        'bloc' => 'Reference content block',
        'bloc_name' => 'name',
        'bloc_name_ex' => 'Link to document',
        'bloc_type' => 'Content type',
        'name' => 'Entitled',
        'name_ex' => 'Only used in the soundtrack'
    ],
    'bloc_type' => [
        'ajax_method' => 'Ajax method',
        'code' => 'Block identification code',
        'datasource_accepted' => 'Model reserved for sources:',
        'datasource_accepted_comment' => 'Blank if works with all models',
        'icon_png' => 'Use a PNG icon',
        'model' => 'Associated model',
        'name' => 'Entitled',
        'scr_explication' => 'Block Explanation Word File',
        'type' => 'block type',
        'type_bloc' => 'The content will be of type: \'block\'',
        'type_row' => 'The content will be of type: \'row\'',
        'use_icon' => 'Use an October icon'
    ],
    'content' => [
        'add_base' => 'Create basic content',
        'add_version' => 'New version',
        'create_content' => 'Creating a release:',
        'name' => 'Contents',
        'reminder_content' => 'Choose or create a version in the table above. Update before leaving',
        'sector' => 'Sector of this version',
        'sector_placeholder' => 'Choose a sector',
        'update_content' => 'Version update',
        'version_for_sector' => 'Version for the sector:',
        'versions' => 'Versions'
    ],
    'contents' => [
        'linkedphoto' => [
            'height' => 'Height (mm)',
            'image' => 'Choose a picture',
            'image_placeholder' => '--Choose an image--',
            'keep_ratio' => 'Keep the ration',
            'unit' => 'Unity',
            'width' => 'Width (mm)',
            'width_explication' => '165mm is the default content width'
        ],
        'mediastextes' => [
            'Jump' => 'Add a second paragraph break',
            'data_prompt' => 'Create a text + photo initial',
            'path' => 'Choose a picture',
            'value' => 'Text'
        ],
        'textes' => [
            'Jump' => 'Add a second paragraph break',
            'data_prompt' => 'Create a text paraph',
            'value' => 'Text'
        ]
    ],
    'document' => [
        'check' => 'To verify',
        'data_source' => ' Data sources',
        'download' => 'Download an example',
        'name' => 'name',
        'name_construction' => 'File name construction',
        'path' => 'Source file',
        'scopes' => [
            'com' => 'You can decide to display this model only under certain criteria Attention only id values are accepted',
            'conditions' => 'Conditions',
            'id' => 'ID sought',
            'id_com' => 'You can add multiple IDs',
            'prompt' => 'Add a new limit',
            'self' => 'Restriction function linked to the id of this model?',
            'target' => 'Target relationship',
            'target_com' => 'Write the name of the relation the parent relations are not available',
            'title' => 'limit the document for a target'
        ],
        'test_id' => 'Test ID',
        'title' => 'Create a Word document'
    ],
    'menu' => [
        'documents' => 'Words',
        'documents_description' => 'Word models management ',
        'settings_category' => 'Wakaari Model',
        'title' => 'Contents'
    ],
    'models' => [
        'document' => [
            'check' => 'Check',
            'courriers' => 'Document management',
            'create' => 'Create Document',
            'data_source' => 'Data Source',
            'edit' => 'Edit document',
            'form_name' => 'Document management',
            'is_lot' => 'Allow in batches?',
            'name' => 'document wording',
            'output_name' => 'File name construction',
            'path' => 'Document source',
            'preview_name' => 'See document',
            'rule_asks' => 'Editable fields',
            'rule_conditions' => 'Conditions',
            'rule_fncs' => 'Editable functions',
            'slug' => 'Slug/Code',
            'state' => 'State',
            'tab_attributs' => 'Attributes',
            'tab_edit' => 'Edit document',
            'tab_infos' => 'Info',
            'tab_options' => 'Options',
            'tab_temp' => 'TEMP',
            'test' => 'Test',
            'test_id' => 'Testing model',
            'title' => 'Document title',
            'update' => 'Document modification '
        ]
    ],
    'objtext' => [
        'data' => 'Paragraphs',
        'data_prompt' => 'Click here to add a paragraph',
        'jump' => 'Line break between two paragraphs',
        'value' => 'Paragraph'
    ],
    'word' => [
        'error' => [
            'no_image' => 'Image or mount does not exist'
        ],
        'processor' => [
            'bad_format' => 'Fromat du tag incorrect',
            'bad_tag' => 'The tag type is incorrect',
            'document_not_exist' => ' The source of the document was not found',
            'errors' => 'This document has errors, please correct them.',
            'field_not_existe' => 'The field does not exist',
            'id_not_exist' => 'ID does not exist',
            'success' => 'The system did not find any errors. Remember to check your document after editing',
            'type_not_exist' => 'This type of tag does not exist'
        ]
    ]
];
