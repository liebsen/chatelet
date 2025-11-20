$(document).ready(function() {
    var modal = $('#registro_form');
    var form = $('#registro_form');

    $('#registro_form').bootstrapValidator({
        message: 'No es un valor válido para este campo',
        framework: 'bootstrap',
        excluded: ':disabled',
        submitButtons: 'input[type="submit"]',
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
                        message: 'Contraseña es requerido'
                    },
                    stringLength: {
                        min: 4,
                        max: 20,
                        message: 'El campo contraseña debe tener como mínimo 6 caracteres y 20 como máximo'
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
            /*'data[User][birthday]': {
                validators: {
                    notEmpty: {
                        message: 'Este campo es requerido y no puede estar vacio'
                    }
                }
            }
            'data[User][gender]': {
                validators: {
                    notEmpty: {
                        message: 'El campo genero es requerido y no puede estar vacio'
                    }
                }
            },
            data[User][dni]': {
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
            }*/
        }
    }).on('change', '[name="data[User][birthday]"]', function(e) {
        //$("#birthday").val($(this).datepicker('getFormattedDate'));
            //$('#registro_form').bootstrapValidator('options.fields.data[User][birthday]');
        if($("#birthday").val()!=''){
            $("#registro_form").data('bootstrapValidator').updateStatus('data[User][birthday]', 'VALID').validateField("data[User][birthday]");
            $("#registro_form").bootstrapValidator('disableSubmitButtons', false);
        }
        //$(this).closest('#registro_form').bootstrapValidator('revalidateField', $(this).prop('name'), true);
    }).on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
            $("#registro_form").bootstrapValidator('disableSubmitButtons', false);
            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(response) {
                if (!response.success) {
                    if(response.errors!=undefined){
                        if(response.errors.email!=undefined){
                            $(".validation-email").html(response.errors.email[0]);
                            $("#email").parent().removeClass('has-success');
                            $("#email").parent().addClass('has-error');
                        }
                        if(response.errors.password!=undefined){
                            $(".validation-password").html(response.errors.password[0]);
                            $("#password").parent().removeClass('has-success');
                            $("#password").parent().addClass('has-error');
                        }
                    }
                    $.growl.error({
                        title: 'Error al registrar usuario',
                        message: 'Por favor verifica los datos introducidos e intenta de nuevo'
                    });
                    return false;
                }else{

                // me[0].reset();
                // me.parents('#registro_form').modal('hide');
                // location.reload();
               }
            }, 'json');
        });

});