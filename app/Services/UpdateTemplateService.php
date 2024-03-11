<?php

namespace App\Services;

use App\Models\Template;

class UpdateTemplateService
{
    private $template_data;
    public function __construct($template_data)
    {
        $this->template_data = $template_data;
    }
    public function updateTemplate()
    {
        $template = Template::find($this->template_data[2]);
        $template->name = $this->template_data[0];
        $template->template = $this->template_data[1];
        $response = $template->save();
        return $response;
    }
}
