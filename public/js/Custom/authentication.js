/**
 * Created by Александр on 29.04.2017.
 */
(function ($) {
    var registerContainer = $('#register-form-container');
    var registerForm = $('#register-form');
    var resetForm = $('#pass-reset-form');
    var loginForm = $('#login-form-wrapper');
    var windowWidth = 859;

    $('#open-social-btn').on('click', function () {
        $('#auth-signup').addClass('hide');
        $('#auth-signup-social').addClass('show');
    });
    $('#open-register-form').on('click', function () {
        $('#auth-signup').removeClass('hide');
        $('#auth-signup-social').removeClass('show');
    });

    $('#registerLink').on('click', function () {
        if (registerContainer.hasClass('active')) {
            if (resetForm.hasClass('hidden')) {
                registerContainer.removeClass('active')
            } else {
                registerForm.removeClass('hidden');
                resetForm.addClass('hidden');
            }
        } else {
            resetForm.addClass('hidden');
            registerForm.removeClass('hidden');
            registerContainer.addClass('active').removeClass('hidden');
            if (window.innerWidth < windowWidth) {
                loginForm.addClass('hidden').removeClass('active');
            }
        }
    });

    $('#resetPassLink').on('click', function () {
        if (registerContainer.hasClass('active')) {
            if (registerForm.hasClass('hidden')) {
                registerContainer.removeClass('active')
            } else {
                registerForm.addClass('hidden');
                resetForm.removeClass('hidden');
            }
        } else {
            registerForm.addClass('hidden');
            resetForm.removeClass('hidden');
            registerContainer.addClass('active').removeClass('hidden');
            if (window.innerWidth < windowWidth) {
                loginForm.addClass('hidden').removeClass('active');
            }
        }
    });

    $(window).on('load resize', function () {
        var loginBtn = $('#login');
        if (window.innerWidth < windowWidth) {
            if (loginForm.find('.error').length) {
                loginForm.addClass('active').find('.form-close').removeClass('hidden');
            } else {
                loginForm.addClass('hidden').find('.form-close').removeClass('hidden');
            }
            loginBtn.removeClass('hidden');
        } else {
            loginForm.removeClass('hidden').find('.form-close').addClass('hidden');
            loginBtn.addClass('hidden');
        }
    });

    $('#login').on('click', function (e) {
        e.preventDefault();
        if (loginForm.hasClass('active')) {
            loginForm.removeClass('active').addClass('hidden');
        } else {
            loginForm.removeClass('hidden').addClass('active');
            registerContainer.addClass('hidden').removeClass('active');
        }
    });

    $(document)
        .on('click', '.close-btn', function () {
            $(this).parent().removeClass('active');
            if (window.innerWidth < windowWidth) {
                $(this).parent().addClass('hidden');
            }
        })
        .on('change', '.form-group.has-danger input', function () {
            $(this).closest('.form-group').removeClass('has-danger');
        });
})(jQuery);