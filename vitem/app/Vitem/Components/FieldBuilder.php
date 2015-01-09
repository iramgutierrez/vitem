<?php
/**
 * Created by PhpStorm.
 * User: silence
 * Date: 5/20/14
 * Time: 8:15 PM
 */

namespace Vitem\Components;

use Illuminate\Html\FormBuilder as Form;
use Illuminate\View\Factory as View;
use Illuminate\Session\Store as Session;

class FieldBuilder {

    protected $form;
    protected $view;
    protected $session;

    protected $defaultClass = [
        'default'  => 'form-control',
        'checkbox' => ''
    ];

    public function __construct(Form $form, View $view, Session $session)
    {
        $this->form = $form;
        $this->view = $view;
        $this->session = $session;
    }

    public function getDefaultClass($type)
    {
        if (isset ($this->defaultClass[$type]))
        {
            return $this->defaultClass[$type];
        }

        return $this->defaultClass['default'];
    }

    public function buildCssClasses($type, &$attributes)
    {
        $defaultClasses = $this->getDefaultClass($type);

        if (isset ($attributes['class']))
        {
            $attributes['class'] .= ' ' . $defaultClasses;
        }
        else
        {
            $attributes['class'] = $defaultClasses;
        }
    }

    public function buildLabel($name)
    {

        $nameArray = explode('.', $name);
        $name = end($nameArray);
        if (\Lang::has('validation.attributes.' . $name))
        {
            $label = \Lang::get('validation.attributes.' . $name);
        }
        else
        {
            $label = str_replace('_', ' ', $name);
        }

        return ucfirst($label);
    }

    public function buildControl($type, $name, $value = null, $attributes = array(), $options = array())
    {
        $nameArray = explode('.', $name);

        switch(count($nameArray))
        {
            case 2:
                $name = $nameArray[0].'['. $nameArray[1] .']';
                break;
            case 3:
                $name = $nameArray[0].'['. $nameArray[1] .']['. $nameArray[2] . ']';
                break;
            default:
                $name = end($nameArray);


        }

        switch ($type)
        {
            case 'select':
                $options = array('' => 'Seleccione') + $options;
                return $this->form->select($name, $options, $value, $attributes);
            case 'password':
                return $this->form->password($name, $attributes);
            case 'checkbox':
                $checked = (isset($options['checked'])) ? $options['checked'] : 'false'; 
                return $this->form->checkbox($name, $value , $checked , $attributes);
            case 'checkbox_switch':
                $checked = (isset($options['checked'])) ? $options['checked'] : 'false'; 
                return $this->form->checkbox($name, $value , $checked , $attributes);
            case 'textarea':
                return $this->form->textarea($name, $value, $attributes);
            case 'image':
                return $this->form->file($name , $attributes);
            default:
                return $this->form->input($type, $name, $value, $attributes);
        }
    }

    public function buildError($name)
    {
        $error = null;
        if ($this->session->has('errors'))
        {
            $errors = $this->session->get('errors');

            if ($errors->has($name))
            {
                $error = $errors->first($name);
            }
        }
        return $error;
    }

    public function buildTemplate($type)
    {
        
        if ( \File::exists(app_path().'/views/fields/' . $type . '.blade.php') )
        {
            return 'fields/' . $type;
        }

        return 'fields/default';
    }

    public function input($type, $name, $value = null, $attributes = array(), $options = array())
    {
        
        $this->buildCssClasses($type, $attributes);
        $label = $this->buildLabel($name);
        $control = $this->buildControl($type, $name, $value, $attributes, $options);
        $error = $this->buildError($name);
        $template = $this->buildTemplate($type);

        $label_value = false;

        if($type == 'checkbox' || $type == "checkbox_switch")
        {
            $label_value = $options['label-value'];  
        }  
        
        return $this->view->make($template, compact ('value','name', 'label', 'control', 'error', 'attributes' , 'label_value'));
    }

    public function password($name, $attributes = array())
    {
        return $this->input('password', $name, null, $attributes);
    }

    public function select($name, $options, $value = null, $attributes = array())
    {
        return $this->input('select', $name, $value, $attributes, $options);
    }
    public function checkbox($name, $value = null, $attributes = array() ,$options = array())
    {
        return $this->input('checkbox', $name, $value, $attributes, $options);
    }

    public function __call($method, $params)
    {
        array_unshift($params, $method);
        return call_user_func_array([$this, 'input'], $params);
    }
} 