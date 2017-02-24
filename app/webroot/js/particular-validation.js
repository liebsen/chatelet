$(document).ready(function() {
    var modal = $('#particular-modal');
    var form = $('#particularForm');

    $(modal).bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
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
                        message: 'El campo cumpleaños es requerido y no puede estar vacio'
                    }
                }
            },
            /*'data[User][gender]': {
                validators: {
                    notEmpty: {
                        message: 'El campo genero es requerido y no puede estar vacio'
                    }
                }
            },*/
            'data[User][dni]': {
                validators: {
                    notEmpty: {
                        message: 'El campo dni es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][telephone]': {
                validators: {
                    notEmpty: {
                        message: 'El campo telefono es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][address]': {
                validators: {
                    notEmpty: {
                        message: 'El campo direccion es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][province]': {
                validators: {
                    notEmpty: {
                        message: 'El campo provincia es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][city]': {
                validators: {
                    notEmpty: {
                        message: 'El campo ciudad es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][neighborhood]': {
                validators: {
                    notEmpty: {
                        message: 'El campo barrio es requerido y no puede estar vacio'
                    }
                }
            },
            'data[User][postal_address]': {
                validators: {
                    notEmpty: {
                        message: 'El campo codigo postal es requerido y no puede estar vacio'
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
                }else{

                me[0].reset();
                me.parents('#particular-modal').modal('hide');
                location.reload();
               }
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