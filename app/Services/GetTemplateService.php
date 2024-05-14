<?php

namespace App\Services;

use App\Models\Template;

class GetTemplateService{
    public function getTemplate($client_id){
        $templates = Template::where('client_id',$client_id)->get();
        return $templates;
    }
}