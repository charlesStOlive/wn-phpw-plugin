<?php

namespace Waka\Phpw\Classes;

use Closure;
use Waka\Productor\Interfaces\BaseProductor;
use Waka\Productor\Interfaces\SaveTo;
use Lang;
use Arr;
use ApplicationException;
use ValidationException;

class Worder implements BaseProductor, SaveTo
{
    use \Waka\Productor\Classes\Traits\TraitProductor; 

    public static function getConfig()
    {
        return [
            'label' => Lang::get('waka.phpw::lang.driver.label'),
            'icon' => 'icon-file-word-o',
            'description' => Lang::get('waka.phpw::lang.driver.description'),
            'productorModel' => \Waka\Phpw\Models\Document::class,
            'productorCreator' => \Waka\Phpw\Classes\WordCreator::class,
            'productor_yaml_config' => '~/plugins/waka/phpw/models/document/productor_config.yaml',
            'methods' => [
                'saveTo' => [
                    'label' => 'Créer un document Word', 
                    'handler' => 'saveTo',
            ]],
        ];
    }

    public static function updateFormwidget($slug, $formWidget) {
        $productorModel = self::getProductor($slug);
        $formWidget->getField('output_name')->value = $productorModel->output_name;
        //Je n'ais pas trouvé de solution pour charger les valeurs. donc je recupère les asks dans un primer temps avec une valeur par defaut qui ne marche pas et je le réajoute ensuite.... 
        $formWidget = self::getAndSetAsks($productorModel,$formWidget);
        return $formWidget;
    }
    

    public static function execute($templateCode, $productorHandler, $allDatas):array {
        //trace_log($allDatas);
        $modelId = Arr::get($allDatas, 'modelId');
        $modelClass = Arr::get($allDatas, 'modelClass');
        $dsMap = Arr::get($allDatas, 'dsMap', null);
        //
        $targetModel = $modelClass::find($modelId);
        $data = [];
        if ($targetModel) {
            //trace_log('dsMap key!',$dsMap);
            $data = $targetModel->dsMap($dsMap);
            //trace_log('data dsMap!',$data);
        }
        if($productorHandler == "saveTo") {
            $link = self::saveTo($templateCode, $data, [], '', function($doc) use($allDatas) {
                $doc->setOutputName(\Arr::get($allDatas, 'productorDataArray.output_name'));
            });
            return [
                'message' => 'Document prêt pour télechargement',
                'btn' => [
                    'label' => 'Télécharger le fichier',
                    'request' => 'onCloseAndDownload',
                    'link' => $link
                ],
            ];
        } else {
            return [];
        }
    }

    public static function saveTo(string $templateCode, array $vars = [], array $options = [], string $path = '',  Closure $callback = null) {
        // Créer l'instance de pdf
        $creator = self::instanciateCreator($templateCode, $vars, $options);
        // Appeler le callback pour définir les options
        if (is_callable($callback)) {
            $callback($creator);
        }
        try {
            return $creator->saveTo();
        } catch (\Exception $ex) {
            throw $ex;
        }

    }
}
