<?php

namespace Waka\Phpw\Behaviors;

use Backend\Classes\ControllerBehavior;
use Redirect;
//use Waka\Wutils\Classes\DataXXSource;
use Waka\Phpw\Classes\WordCreator;
use Waka\Phpw\Models\Document;
use Session;

class WordBehavior extends ControllerBehavior
{
    protected $wordBehaviorWidget;
    protected $askDataWidget;
    public $errors;

    public function __construct($controller)
    {
        parent::__construct($controller);
        $this->wordBehaviorWidget = $this->createWordBehaviorWidget();
        $this->errors = [];
        \Event::listen('waka.utils::conditions.error', function ($error) {
            array_push($this->errors, $error);
        });
    }

    /**
     * METHODES
     */

    /**
     * LOAD DES POPUPS
     */
    public function onLoadWordBehaviorPopupForm()
    {
        $modelClass = post('modelClass');
        $modelId = post('modelId');

        //$ds = \DataXXSources::findByClass($modelClass);
        $options = $ds->getProductorOptions('Waka\Phpw\Models\Document', $modelId);

        $this->vars['options'] = $options;
        $this->vars['modelId'] = $modelId;
        $this->vars['errors'] = $this->errors;
        $this->vars['modelClass'] = $modelClass;

        if($options) {
            return $this->makePartial('$/waka/phpw/behaviors/wordbehavior/_popup.htm');
        } else {
            return $this->makePartial('$/wakawutils/views/_popup_no_model.htm');
        }

        
    }
    public function onLoadWordBehaviorContentForm()
    {
        $modelClass = post('modelClass');
        $modelId = post('modelId');
        

        //$ds = \DataXXSources::findByClass($modelClass);
        $options = $ds->getProductorOptions('Waka\Phpw\Models\Document', $modelId);

        $this->vars['options'] = $options;
        $this->vars['modelId'] = $modelId;
        $this->vars['errors'] = $this->errors;
        $this->vars['modelClass'] = $modelClass;

        if($options) {
            return ['#popupActionContent' => $this->makePartial('$/waka/phpw/behaviors/wordbehavior/_content.htm')];
        } else {
            return ['#popupActionContent' => $this->makePartial('$/wakawutils/views/_content_no_model.htm')];
        }

        
    }

    public function onSelectWord() {
        $productorId = post('productorId');
        $modelId = post('modelId');
        $productor = WordCreator::find($productorId)->setModelId($modelId);


        $askDataWidget = $this->createAskDataWidget();
        $asks = $productor->getProductorAsks();
        $askDataWidget->addFields($asks);
        $this->vars['askDataWidget'] = $askDataWidget;
        return [
            '#askDataWidget' => $this->makePartial('$/wakawutils/models/ask/_widget_ask_data.htm')
        ];
    }

    public function onWordBehaviorPopupValidation()
    {
        $datas = post();
        $errors = $this->CheckValidation(\Input::all());
        if ($errors) {
            throw new \ValidationException(['error' => $errors]);
        }
        $productorId = post('productorId');
        $modelId = post('modelId');
        Session::put('word_asks_'.$modelId, $datas['asks_array'] ?? []);

        return Redirect::to('/backend/waka/phpw/documents/makeword/?productorId=' . $productorId . '&modelId=' . $modelId);
    }

    /**
     * Validations
     */
    public function CheckValidation($inputs)
    {
        $rules = [
            'modelId' => 'required',
            'productorId' => 'required',
        ];

        $validator = \Validator::make($inputs, $rules);

        if ($validator->fails()) {
            return $validator->messages()->first();
        } else {
            return false;
        }
    }
    public function makeword()
    {
        $productorId = \Input::get('productorId');
        $modelId = \Input::get('modelId');
        $asks = Session::pull('word_asks_'.$modelId);
        return WordCreator::find($productorId)->setModelId($modelId)->setAsksResponse($asks)->renderWord();
    }
    /**
     * Cette fonction est utilisé lors du test depuis le controller document.
     */
    public function onLoadWordBehaviorForm()
    {
        $productorId = post('productorId');
        return Redirect::to('/backend/waka/phpw/documents/maketest/?productorId=' . $productorId);
    }
    public function maketest()
    {
        $productorId = \Input::get('productorId');
        return WordCreator::find($productorId)->setModelTest()->setAsksResponse([])->renderWord();
    }
    

    

    public function createWordBehaviorWidget()
    {
        $config = $this->makeConfig('$/waka/phpw/models/document/fields_for_test.yaml');
        $config->alias = 'wordBehaviorformWidget';
        $config->arrayName = 'wordBehavior_array';
        $config->model = new Document();
        $widget = $this->makeWidget('Backend\Widgets\Form', $config);
        $widget->bindToController();
        return $widget;
    }

    public function createAskDataWidget()
    {
        $config = $this->makeConfig('$/wakawutils/models/ask/empty_fields.yaml');
        $config->alias = 'askDataformWidget';
        $config->arrayName = 'asks_array';
        $config->model = new \Waka\WakaBlocs\Models\RuleAsk();
        $widget = $this->makeWidget('Backend\Widgets\Form', $config);
        $widget->bindToController();
        return $widget;
    }
}
