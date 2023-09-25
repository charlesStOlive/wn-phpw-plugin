<?php namespace Waka\Phpw\Classes;

use ApplicationException;
use Lang;
use Storage;
//
use Waka\Phpw\Models\Document;
use \PhpOffice\PhpWord\TemplateProcessor;
use Waka\Wutils\Classes\TinyUuid;
class WordCreator 
{

    
    private $templateProcessor;
    //
    public $doc;
    public array $vars;
    //
    private $outputName;


    public function __construct($template,$vars)
    {
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $this->doc = Document::where('slug', $template)->first();
        $this->vars = $vars;
        $this->templateProcessor = $this->setTemplateProcessor();
    }

    public function saveTo()
    {
        $this->prepareModelData();
        $uuid = TinyUuid::generateFromDate();
        $basePath = storage_path(sprintf('app/uploads/tempproductor/%s',$uuid));
        \File::makeDirectory($basePath);
        $path = $basePath.'/'.$this->outputName . '.docx';
        $this->templateProcessor->saveAs($path);
        return $path;
    }

    /**
     * Set METHOD
     */
    public function setOutputName($outputName)
    {
        $this->outputName = $outputName;
    }

    /**
     *
     */
     /**
     * ********************************Partie liée à la création de document**********************************
     */

    private function setTemplateProcessor()
    {
        $existe = Storage::exists('media' . $this->doc->path);
        if (!$existe) {
            throw new ApplicationException(Lang::get('waka.phpw::lang.word.processor.document_not_exist'));
        }

        $document_path = storage_path('app/media' . $this->doc->path);
        $templateProcessor = new TemplateProcessor($document_path);
        return $templateProcessor;
        //trace_log(self::$templateProcessor);
    }


    private function prepareModelData()
    {
        $this->outputName = \Str::slug($this->outputName ?  $this->parseModelField($this->outputName, $this->vars) : $this->parseModelField($this->doc->output_name, $this->vars), '_');
        $this->setTemplateProcessor();
        $allOriginalTags = $this->checkTags();
        $wordResolver = new WordResolver($this->templateProcessor);
        $tempData = $this->vars;
        //trace($allOriginalTags);
        foreach($allOriginalTags as $tag) {
            if($tag->resolver == 'FNC') {
                $data = \Arr::get($tempData, $tag->varName, []);
                $wordResolver->resolveFnc($tag, $data);
            }

            if($tag->resolver == 'ds' || $tag->resolver == 'asks') {
                $data = array_get($tempData, $tag->varName);
                $wordResolver->findAndResolve($tag, $data);
            }
        }   
    }

    public function getFncAccepted()
    {
        return [
            'data',
            'ds',
            'asks',
            'FNC',
            ];
    }
    

    private function checkTags()
    {
        //trace($this->templateProcessor->getVariables());
        $allTags = $this->filterTags($this->templateProcessor->getVariables());
        //trace_log("************ALLTAGS****************", $allTags);
        return $allTags;
    }
    /**
     *
     */
    private function filterTags($tags)
    {
        $allTags = [];
        $insideBlock = false;
        $insideIs = false;
        
        //Instanciation du premier FNC TAG
        $fncTag = new WordTag('FNC');
        $fncIs = null;
        $subTags = [];
        //trace_log($tags);
        foreach ($tags as $tag) {
            $trimmedTag = trim($tag);
            // Si un / est détécté c'est une fin de bloc. on enregistre les données du bloc mais pas le tag
            //trace_log("Nouveau tag analysé : " . $tag);
            if (starts_with($trimmedTag, '/FNC.')) {
                $fncTag->addSubTags($subTags);
                array_push($allTags, $fncTag);
                $insideBlock = false;
                //trace_log("---------------------FIN----Inside bloc-------------------");
                //reinitialisation du fnc_code et des subtags
                $fncTag = new WordTag('FNC');
                $subTags = [];
                //passage au tag suivant
                continue;
            } else {
                // si on est dans un bloc on enregistre les subpart dans le bloc.
                if ($insideBlock) {
                    $subTag = new WordTag('FNC_child');
                    $subTag->decryptTag($tag);
                    array_push($subTags, $subTag);
                    continue;
                }
                $parts = explode('.', $trimmedTag);
                if (count($parts) <= 1) {
                    $error = Lang::get('waka.phpw::lang.word.processor.bad_format') . ' : ' . $tag;
                    \Log::error($error);
                    // $this->recordInform('problem', $error);
                    continue;
                }
                //trace_log($tag);
                $fncFormat = array_shift($parts);

                if (!in_array($fncFormat, $this->getFncAccepted())) {
                    $frAccepted = implode(", ", $this->getFncAccepted());
                    $error = Lang::get('waka.phpw::lang.word.processor.bad_tag') . ' : ' . $frAccepted . ' => ' . $tag;
                    \Log::error($error);
                    continue;
                }
                // si le tag commence par le nom de la source

                if ($fncFormat == 'ds' || $fncFormat == 'data') {
                    $tagObj = new WordTag('ds');
                    $tagObj->decryptTag($tag);
                    array_push($allTags, $tagObj);
                    continue;
                }
                
                if ($fncFormat == 'asks') {
                    $tagObj = new WordTag('asks');
                    $tagObj->decryptTag($tag);
                    array_push($allTags, $tagObj);
                    continue;
                }
                //trace_log(' c est un FNC alors-------------', $tag);
                $fncTag->varName = ltrim($trimmedTag, 'FNC.');
                //trace_log("nouvelle fonction : " . $fncTag['code']);
                if (!$fncTag) {
                    $txt = Lang::get('waka.phpw::lang.word.processor.bad_format') . ' : ' . $tag;
                    $this->recordInform('warning', $txt);
                    continue;
                } else {
                    // on commence un bloc
                    
                    $insideBlock = true;
                    //trace_log("-------------------------Inside bloc-------------------");
                }
            }
        }
        return $allTags;
    }
    private function parseModelField($modelValue, $value)
    {
        if ($modelValue) {
            return \Twig::parse($modelValue, $this->vars);
        } else {
            return null;
        }
    }
    
}
