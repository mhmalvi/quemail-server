<?php

namespace App\Services;

use App\Models\Template;

class GetTemplateService{
    public function getTemplate(){
        $templates = Template::all();  
        return $templates;
    }
}