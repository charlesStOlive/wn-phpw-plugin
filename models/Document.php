<?php namespace Waka\Phpw\Models;

use Model;

/**
 * document Model
 */

class Document extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    use \Winter\Storm\Database\Traits\SoftDelete;
    use \Winter\Storm\Database\Traits\Sortable;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'waka_phpw_documents';


    /**
     * @var array Guarded fields
     */
    protected $guarded = ['id'];

    /**
     * @var array Fillable fields
     */
    //protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required',
        'path' => 'required',
    ];

    public $customMessages = [
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [
        'config',
    ];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [
    ];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

/**
    * @var array Spécifié le type d'export à utiliser pour chaque champs
    */
    public $importExportConfig = [
    ]; 

    /**
     * @var array Relations
     */
    public $hasOne = [
    ];
    public $hasMany = [
    ];
    public $hasOneThrough = [
    ];
    public $hasManyThrough = [
    ];
    public $belongsTo = [
    ];
    public $belongsToMany = [
    ];        
    public $morphTo = [
    ];
    public $morphOne = [
        // 'waka_session' => [
        //     'Waka\Session\Models\WakaSession',
        //     'name' => 'sessioneable',
        //     'delete' => true
        // ],
    ];
    public $morphMany = [
        'rule_asks' => [
            'Waka\WakaBlocs\Models\RuleAsk',
            'name' => 'askeable',
            'delete' => true
        ],
        // 'rule_fncs' => [
        //     'Waka\WakaBlocs\Models\RuleFnc',
        //     'name' => 'fnceable',
        //     'delete' => true
        // ],
        // 'rule_conditions' => [
        //     'Waka\WakaBlocs\Models\RuleCondition',
        //     'name' => 'conditioneable',
        //     'delete' => true
        // ],
    ];
    public $attachOne = [
    ];
    public $attachMany = [
    ];

    //startKeep/

    /**
     *EVENTS
     **/
    public function beforeSave() 
    {

    }


    /**
     * LISTS
     **/

    /**
     * GETTERS
     **/

    /**
     * SCOPES
     */

    /**
     * SETTERS
     */
 
    /**
     * FILTER FIELDS
     */
    public function filterFields($fields, $context = null) {
        $user = \BackendAuth::getUser();
        //La limite du  nombre de asks est géré dans le controller.
        if(!$user->hasAccess(['waka.phpw.admin.super'])) {
            if(isset($fields->code)) {
                    $fields->slug->readOnly = true;
            }
            if(isset($fields->has_asks)) {
                    $fields->has_asks->readOnly = true;
            }
        }
    }

    /**
     * OTHERS
     */

//endKeep/
}