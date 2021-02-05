<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ConfForm extends Form
{
    public function buildForm()
    {
        foreach ($this->getData('conf') as $key => $value) {
        	$this->add(${'key'}, 'text',['default_value' => $value]);
        } 
        $this->add('submit', 'submit', ['label' => 'Update','attr' => ['class' => 'btn btn-primary m-t-15 waves-effect float-right']]);

    }
}
