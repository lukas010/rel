<?php

// reiketu patikrinti ar username nesusideda vien tik is skaiciu

class Validate
{
    private $_passed = false;
    private $_errors = array();
    private $_db = null;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array())
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {

                // Patikrinimas, ar bent vienas checkbox'as perduodamas
                if (array_key_exists($item, $source)) {
                    $value = $source[$item];                //$value = trim($source[$item]); ?
                }

                $item = escape($item);

                if ($rule === 'required' && empty($value)) {
                    $this->addError("{$item} required");
                } elseif (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$item} > {$rule_value}");
                            }
                        break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$item} < {$rule_value}");
                            }
                        break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} = {$item}");
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array('username', '=', $value));
                            if ($check->count()) {
                                $this->addError("{$item} exists");
                            }
                        break;
                    }
                }
            }
        }
        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return $this;
    }

    private function addError($error)
    {
        $this->_errors[] = $error;
    }

    public function errors()
    {
        return $this->_errors;
    }

    public function passed()
    {
        return $this->_passed;
    }
}
