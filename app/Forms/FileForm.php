<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class FileForm extends Form
{
    public function buildForm()
    {
        
        $this->add('upload_file', 'file', ['rules' => 'required','attr' => ['class' => 'form-control-file']]);
        
        $this->add('submit', 'submit', ['label' => 'Upload','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect float-right']]);

    }
}
