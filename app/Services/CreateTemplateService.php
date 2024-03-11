<?php

namespace App\Services;

use App\Models\Template;

class CreateTemplateService
{
    public $template_data;
    public function __construct($template_data)
    {
        $this->template_data = $template_data;
    }
    public function saveTemplate()
    {
        $response = Template::create([
            'name' => $this->template_data[0],
            'template' => $this->template_data[1]
        ]);
        return $response;
    }
}
