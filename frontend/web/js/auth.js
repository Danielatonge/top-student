    $('.auth-form').on('submit', function(e){
        e.preventDefault();
        let data = $(this).serializeArray();
        $.ajax({
            url: '/user/sign-in/login',
            method: 'POST',
            dataType: 'json',
            data: data,
            success: function (response) {
                if (response.error) {
                    $('.auth-form .error-input').hide();
                    for (var key in response.error) {
                        if (response.error.hasOwnProperty(key)) {
                            $('.auth-form [name="'+ key +'"]').siblings('.error-input').show().text(response.error[key]);
                            if (key == 'password') {
                                $('.auth-form [name="passwordConfirm"]').siblings('.error-input').show().text(response.error[key]);
                            }
                        }
                    }
                } else {
                    window.location = '/';
                }
            }
        });
    });

    $('[name="address[]"]').suggestions({
        token: "3d99c0f9e95dc8d10aef69bba346a80db02a30be",
        type: "ADDRESS",
        /* Вызывается, когда пользователь выбирает одну из подсказок */
        onSelect: function(suggestion) {
            console.log(suggestion);
        }
    });
    $('[name="address"]').suggestions({
        token: "3d99c0f9e95dc8d10aef69bba346a80db02a30be",
        type: "ADDRESS",
        /* Вызывается, когда пользователь выбирает одну из подсказок */
        onSelect: function(suggestion) {
            console.log(suggestion);
        }
    });
    $('[name="filials[]"]').suggestions({
        token: "3d99c0f9e95dc8d10aef69bba346a80db02a30be",
        type: "ADDRESS",
        /* Вызывается, когда пользователь выбирает одну из подсказок */
        onSelect: function(suggestion) {
            console.log(suggestion);
        }
    });

    $('.registration-form').on('submit', function(e){
        e.preventDefault();
        let data = $(this).serializeArray();
        console.log(data);
        $.ajax({
            url: '/user/sign-in/signup',
            method: 'POST',
            dataType: 'json',
            data: data,
            success: function (response) {
                if (response.error) {
                    $('.registration-form:visible .error-input').hide();
                    for (var key in response.error) {
                        if (response.error.hasOwnProperty(key)) {
                            $('.registration-form:visible [name="'+ key +'"]').siblings('.error-input').show().text(response.error[key]);
                            if (key == 'password') {
                                $('.registration-form:visible [name="passwordConfirm"]').siblings('.error-input').show().text(response.error[key]);
                            }
                        }
                    }
                } else {
                    if (data[0].name == "redirect_from") {
                        window.location = data[0].value;
                    } else {
                        window.location = '/';
                    }

                }
            }
        });
    })
