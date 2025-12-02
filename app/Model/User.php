<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public function beforeSave($options = array()) {
        // Remove password
        if (empty($this->data[$this->alias]['password'])) {
            unset($this->data[$this->alias]['password']);
        }

        // Check if user exists
    	if (empty($this->data[$this->alias]['id']) && isset($this->data[$this->alias]['email'])) {
    		$user = $this->findByEmail($this->data[$this->alias]['email']);
    		if (!empty($user)) {
    			return false;
    		}
    	}

        // Hash password
        if (!empty($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }

        // Transform birthday to datetime format
        if (!empty($this->data[$this->alias]['birthday'])) {
        	$date = explode('/', $this->data[$this->alias]['birthday']);
        	$date = implode('-', array($date[2], $date[1], $date[0]));
        	$this->data[$this->alias]['birthday'] = $date;
        }

        return true;
    }

/*
    public $validate = array(
    	'email' => array(
    		'required' => array(
    			'rule' => 'notBlank',
    			'required' => true,
    			'allowEmpty' => false,
    			'message' => 'El campo email es requerido'
			)
		),
		'password' => array(
			'required' => array(
				'rule' => 'notBlank',
				'required' => false,
				'allowEmpty' => true,
				'message'  => 'La campo password es requerido'
			)
		),
		'name' => array(
			'required' => array(
				'rule' => 'notBlank',
				'required' => true,
				'allowEmpty' => false,
				'message'  => 'El campo nombre es requerido'
			)
		),
		'surname' => array(
			'required' => array(
				'rule' => 'notBlank',
				'required' => true,
				'allowEmpty' => false,
				'message'  => 'La campo apellido es requerido'
			)
		)
	);
*/

public $validate = array(
    	'email' => array(
    		'required' => array(
    			'rule' => 'notBlank',
    			'required' => true,
    			'allowEmpty' => false,
    			'message' => 'El campo email es requerido'
			),
            'unique' => array(
                'rule' => 'isUnique',
                'on'=>'create',
                'message'=>'Email ya registrado'
            )
		),
		'password' => array(
			'required' => array(
				'rule' => 'notBlank',
				'required' => false,
				'allowEmpty' => true,
				'message'  => 'La campo contraseña es requerido'
			),
            'minLength' => array(
                'rule' => array('minLength', '6'),
                'message' => 'La contraseña debe tener 6 caracteres como minimo'
            ),
		),
		'name' => array(
			'required' => array(
				'rule' => 'notBlank',
				'required' => true,
				'allowEmpty' => false,
				'message'  => 'El campo nombre es requerido'
			)
		),
		'surname' => array(
			'required' => array(
				'rule' => 'notBlank',
				'required' => true,
				'allowEmpty' => false,
				'message'  => 'La campo apellido es requerido'
			)
		)
	);
}
