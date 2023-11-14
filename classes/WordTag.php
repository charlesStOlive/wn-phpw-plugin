<?php

namespace Waka\Phpw\Classes;



class WordTag
{
    public $resolver;
    public $tagType;
    public $tagKey;
    public $tagParams;
    public $tag;
    public $varName;
    public $parent;
    public $fncName;
    //
    public $subTags;

    public function __construct($resolver)
    {
        $this->resolver = $resolver;
        $this->subTags = [];
    }

    public function addSubTags($newSubTag)
    {
        $this->subTags = array_merge($this->subTags, $newSubTag);
    }

    public function decryptTag($tag)
    {
        //
        //trace_log("decryptTag", $tag);
        $tagWithoutType = $tag;
        $tagAnalysed = [];
        $tagDetails = [];
        $oldTagType = str_contains($tag, '*');
        if ($oldTagType) {
            throw new \ValidationException(['error' => 'Le tag : ' . $tag . ' contient encore une * il faut maintenant utiliser `|` ']);
        }
        $tagTypeExist = str_contains($tag, '|');
        if ($tagTypeExist) {
            $checkTag = array_map('trim', explode('|', $tag));
            $tagType = array_pop($checkTag);
            $tagAnalysed = $this->parseParams($tagType);
            $tagWithoutType = $checkTag[0];
        }
        if ($this->resolver == 'FOR' or $this->resolver == 'FOR_child' or $this->resolver == 'FOR_M' or $this->resolver == 'IS_FOR' or $this->resolver == 'IS_DS') {
            $subParts = explode('.', $tagWithoutType);
            $fncName = array_shift($subParts);
            $this->fncName = $data['fncName'] ?? null;
            $this->varName = trim(implode('.', $subParts));
        } else {
            $this->varName = trim($tagWithoutType);
        }
        $this->tagType =  $tagAnalysed['type'] ?? null;
        $this->tagParams =  $tagAnalysed['params'] ?? [];
        $this->tagKey =  $tag;
        $this->tag = $tag;
    }

    function parseParams($input)
    {
        $result = [
            'type' => null,   // Type HTM ou IMG
            'params' => []  // Paramètres entre parenthèses
        ];

        if(!$input) {
            return $result;
        }

        // Utilisez une expression régulière pour extraire les informations
        if (preg_match('/(HTM|IMG)(\(([^)]+)\))?/', $input, $matches)) {
            $result['type'] = $matches[1]; // HTM ou IMG

            if (!empty($matches[3])) {
                // S'il y a des paramètres, les séparer et les ajouter au tableau
                $params = explode(',', $matches[3]);
                $result['params'] = array_map('trim', $params);
            }
        } else {
            if(!in_array($input, ['IMG', 'HTM'])) {
                throw new \ValidationException(['error' => 'L\'input : ' . $input . ' ne peut être composé que de HTM, IMG ou IMG(Integer,Integer)']);
            } 
            $result['type'] = $input;
        }

        return $result;
    }
}
