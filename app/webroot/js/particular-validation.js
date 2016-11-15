$(document).ready(function() {
    var modal = $('#particular-modal'),
        form = $('#particularForm');

    modal.bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            /*valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'*/
        },
        fields: {
            'data[User][email]': {
                validators: {
                    notEmpty: {
                        message: 'El campo email es requerido y no puede estar vacio'
                    },
                    emailAddress: {
                        message: 'No se ingreso una direccion de email valida'
                    }
                }
            },
            'data[User][password]': {
                validators: {
                    notEmpty: {
                        message: 'El campo password es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][name]': {
                validators: {
                    notEmpty: {
                        message: 'El campo nombre es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][surname]': {
                validators: {
                    notEmpty: {
                        message: 'El campo apellido es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][birthday]': {
                validators: {
                    notEmpty: {
                        message: 'El campo apellido es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][gender]': {
                validators: {
                    notEmpty: {
                        message: 'El campo apellido es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][dni]': {
                validators: {
                    notEmpty: {
                        message: 'El campo apellido es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][telephone]': {
                validators: {
                    notEmpty: {
                        message: 'El campo apellido es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][address]': {
                validators: {
                    notEmpty: {
                        message: 'El campo apellido es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][province]': {
                validators: {
                    notEmpty: {
                        message: 'El campo apellido es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][city]': {
                validators: {
                    notEmpty: {
                        message: 'El campo apellido es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][neighborhood]': {
                validators: {
                    notEmpty: {
                        message: 'El campo apellido es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][postal_address]': {
                validators: {
                    notEmpty: {
                        message: 'El campo apellido es requerido y no puede estar vacio'
                    }
                }
            }
        }
    });

    form.submit(function(e) {
        var me = $(this),
            data = me.serialize(),
            url = me.attr('action');

        $.post(url, data)
            .success(function(response) {
                if (!response.success) {
                    $.growl.error({
                        title: 'Error al registrar usuario',
                        message: 'Por favor verifica los datos introducidos e intenta de nuevo'
                    });
                    return false;
                }

                $.growl.notice({
                    title: 'Usuario registrado',
                    message: 'Ya puedes iniciar sesion con tu usuario y contraseña'
                });
                me[0].reset();
                me.parents('#particular-modal').modal('hide');
            })
            .fail(function() {
                $.growl.error({
                    title: 'Error al registrar usuario',
                    message: 'Por favor verifica los datos introducidos e intenta de nuevo'
                });
            });

        e.preventDefault();
        return false;
    });
});