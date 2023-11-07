<?php

namespace Waka\Phpw\Classes;

use Closure;
use \Waka\Productor\Classes\Abstracts\BaseProductor;
use Lang;
use Arr;
use ApplicationException;
use ValidationException;

class Worder extends BaseProductor
{
    public static $config =  [
            'label' => 'waka.phpw::lang.driver.label',
            'icon' => 'icon-file-word-o',
            'description' => 'waka.phpw::lang.driver.description',
            'productorModel' => \Waka\Phpw\Models\Document::class,
            'productorCreator' => \Waka\Phpw\Classes\WordCreator::class,
            'productor_yaml_config' => '~/plugins/waka/phpw/models/document/productor_config.yaml',
            'methods' => [
                'saveTo' => [
                    'label' => 'Créer un document Word', 
                    'handler' => 'saveTo',
            ]],
        ];

    

    
    

    public function execute($templateCode, $productorHandler, $allDatas):array {
        $this->getBaseVars($allDatas);
        if($productorHandler == "saveTo") {
            $link = self::saveTo($templateCode, $this->data, function($doc) use($allDatas) {
                $doc->setOutputName(\Arr::get($allDatas, 'productorDataArray.output_name'));
            });
            return [
                'message' => 'Document prêt pour télechargement',
                'btn' => [
                    'label' => 'waka.productor::lang.drivers.sucess_label.close_download',
                    'request' => 'onCloseAndDownload',
                    'link' => $link
                ],
            ];
        } else {
            return [];
        }
    }

    /**
     * Instancieation de la class creator
     *
     * @param string $url
     * @return \Spatie\Browsershot\Browsershot
     */
    private static function instanciateCreator(string $templateCode, array $vars)
    {
        $productorClass = self::getStaticConfig('productorCreator');
        $class = new $productorClass($templateCode, $vars);
        return $class;
    }

    public static function updateFormwidget($slug, $formWidget, $config = []) {
        $productorModel = self::getProductor($slug);
        $formWidget->getField('output_name')->value = $productorModel->output_name;
        //Je n'ais pas trouvé de solution pour charger les valeurs. donc je recupère les asks dans un primer temps avec une valeur par defaut qui ne marche pas et je le réajoute ensuite.... 
        // $formWidget = self::getAndSetAsks($productorModel,$formWidget);
        return $formWidget;
    }

    public static function saveTo(string $templateCode, array $vars = [],  Closure $callback = null) {
        // Créer l'instance de pdf
        //trace_log('saveTo vars!!!',$vars);
        $creator = self::instanciateCreator($templateCode, $vars);
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
