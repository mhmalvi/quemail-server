<?php

namespace App\Services;

class GetTemplateService{
    public function getTemplate(){
        return $templates = Template::all();        
    }
}