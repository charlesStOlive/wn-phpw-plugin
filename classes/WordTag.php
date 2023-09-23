<?php namespace Waka\Phpw\Classes;



class WordTag 
{
    public $resolver;
    public $tagType;
    public $tagKey;
    public $tag;
    public $varName;
    public $parent;
    public $fncName;
    //
    public $subTags;

    public function __construct($resolver) {
        $this->resolver = $resolver;
        $this->subTags = [];
    }

    public function addSubTags($newSubTag) {
        $this->subTags = array_merge($this->subTags, $newSubTag);
    }

    public function decryptTag($tag) {
        //
        //trace_log("decryptTag", $tag);
        $tagWithoutType = $tag;
        $tagType = null;
        $tagTypeExist = str_contains($tag, '*');
        if ($tagTypeExist) {
            $checkTag = explode('*', $tag);
            $tagType = array_pop($checkTag);
            $tagWithoutType = $checkTag[0];
        }
        if($this->resolver == 'FNC' or $this->resolver == 'FNC_child' or $this->resolver == 'FNC_M' or $this->resolver == 'IS_FNC' or $this->resolver == 'IS_DS') {
            $subParts = explode('.', $tagWithoutType);
            $fncName = array_shift($subParts);
            $this->fncName = $data['fncName'] ?? null;
            $this->varName = trim(implode('.', $subParts));
        } 
        else {
            $this->varName = trim($tagWithoutType);
        }
        $this->tagType =  $tagType;
        $this->tagKey =  $tag;
        $this->tag = $tag;
        
        
       
        
        
        
    }
}
