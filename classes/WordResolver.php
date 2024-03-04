<?php

namespace Waka\Phpw\Classes;

use Waka\Wutils\Classes\WakaDate;

class WordResolver
{

    private $templateProcessor;

    public function __construct($templateProcessor)
    {
        $this->templateProcessor = $templateProcessor;
    }


    public function resolveFnc($tag, $data)
    {
        $functionName = $tag->varName;
        if (is_object($data)) {
            throw new \SystemException('Attention ! verifiez votre module de fonction ||' . $tag->varName . '|| Il ne retourne pas un array');
        }
        if (!is_array($data)) {
            //trace_log($functionName);
            //trace_log($data);
            throw new \SystemException('Attention ! verifiez votre module de fonction ||' . $tag->varName . '|| Il ne retourne pas un array');
        }
        $countFunctionRows = count($data);
        $tagName = 'FOR.' . $functionName;
        // trace_log($countFunctionRows, $tag);
        if (!$countFunctionRows) {
            //trace("row vide", $tagName);
            $this->templateProcessor->replaceBlock($tagName, 'Aucune données');
        } else {
            //trace("row ok", $tagName);
            $this->templateProcessor->cloneBlock($tagName, $countFunctionRows, true, true);
            $i = 1; //i permet de creer la cla #i lors du clone row
            foreach ($data as $functionRow) {
                foreach ($tag->subTags as $subTag) {
                    $subTag->tagKey =  $subTag->tag . '#' . $i;
                    $fncData = $functionRow[$subTag->varName] ?? false;
                    if (!$fncData) {
                        $fncData = array_get($functionRow, $subTag->varName);
                    }
                    $this->findAndResolve($subTag, $fncData);
                }
                $i++;
            }
        }


        //
    }

    public function findAndResolve($wordTag, $tagData)
    {
        $tagType = $wordTag->tagType;
        switch ($tagType) {
            case 'HTM':
                $this->resolveHtmRow($wordTag, $tagData);
                break;
            case 'MD':
                $this->resolveMdRow($wordTag, $tagData);
                break;
            case 'TXT':
                $this->resolveHtmToTxtRow($wordTag, $tagData);
                break;
            case 'IMG':
                $this->resolveImgRow($wordTag, $tagData);
                break;
            default:
                $this->resolveBasicRow($wordTag, $tagData);
        }
    }

    public function resolveBasicRow($wordTag, $tagData)
    {
        //trace_log($tagData);

        if ($wordTag->tagType != null) {
            $tagData = $this->transformValue($tagData, $wordTag->tagType);
        } else {
            //$tagData = preg_replace('/[^\w\s\.\,\;\:\'\"]/u', '', $tagData);
        }
        $this->templateProcessor->setValue($wordTag->tagKey, $tagData);
    }

    public function resolveHtmRow($wordTag, $tagData)
    {
        //trace_log('resoudre un htm------------------------');
        $tagData = html_entity_decode(preg_replace("/[\r\n]{2,}/", "\n", $tagData), ENT_QUOTES, 'UTF-8');
        //Nettoyage des caractères spéciaux
        //$tagData = preg_replace('/[^\w\s\.\,\;\:\'\"]/u', '', $tagData);
        $this->templateProcessor->setHtmlValue($wordTag->tagKey, $tagData, true);
        //$this->templateProcessor->setValue($wordTag->tagKey, "attente correction de html", true);
    }

    public function resolveMdRow($wordTag, $tagData)
    {
        $tagKey = $wordTag->tagType;
        if (!$tagData) {
            $tagData = '';
        } else {
            $tagData = \Markdown::parse($tagData);
            $tagData = html_entity_decode(preg_replace("/[\r\n]{2,}/", "\n", $tagData), ENT_QUOTES, 'UTF-8');
        }
        $this->templateProcessor->setHtmlValue($wordTag->tagKey, $tagData, true);
        //$this->templateProcessor->setValue($wordTag->tagKey, "attente correction de html", true);
    }

    public function resolveHtmToTxtRow($wordTag, $tagData)
    {
        $tagKey = $wordTag->tagType;
        if (!$tagData) {
            $tagData = '';
        } else {
            $tagData = \Markdown::parse($tagData);
            $tagData = html_entity_decode(preg_replace("/[\r\n]{2,}/", "\n", $tagData), ENT_QUOTES, 'UTF-8');
            //Nettoyage des caractères spéciaux
            //$tagData = preg_replace('/[^\w\s\.\,\;\:\'\"]/u', '', $tagData);
            $tagData = strip_tags($tagData);
        }
        // $tagData = html_entity_decode(preg_replace("/[\r\n]{2,}/", "\n", $tagData), ENT_QUOTES, 'UTF-8');
        $this->templateProcessor->setValue($wordTag->tagKey, $tagData, true);
    }

    public function resolveImgRow($wordTag, $tagData)
    {

        $params = $wordTag->tagParams;
        $path = $tagData['path'] ?? false;
        $width = null;
        $height = null;

        
        $title = $tagData['title'] ?? false;
        $width = $tagData['width'] ?? false;
        $height = $tagData['height'] ?? false;
        if(!empty($params)) {
            $width = $params[0] ?? $width;
            $height = $params[1] ?? $height;
        } 
        
        if ($path) {
            // trace_log(['path' => $path, 'width' => $width . 'px', 'height' => $height . 'px']);
            try {
                if (!$width or !$height) {
                    $this->templateProcessor->setImageValue($wordTag->tagKey, $path);
                } else {
                    $this->templateProcessor->setImageValue($wordTag->tagKey, ['path' => $path, 'width' => $width, 'height' => $height], 1);
                }
            } catch (\Exception $ex) {
                //trace_log('Error Processing image');
                //trace_log($ex->getMessage());
            }
        } else {
            // trace_log('pas de path');
            $this->templateProcessor->setValue($wordTag->tagKey, "", 1);
        }
    }

    public function transformValue($value, $type)
    {
        \Log::info(sprintf('les types de value en dehors de HTM et IMG n existe plaus. Il faut les supprimer : %s %s', $value, $type));
        return $value;
    }
}
