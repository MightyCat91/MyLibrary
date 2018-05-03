function Alert(type, message, customDelay) {
    var icon, delay;
    if (typeof customDelay === 'undefined') {
        delay = 4000;
    } else {
        delay = customDelay;
    }

    switch (type) {
        case 'success fa-lg':
            icon = 'fa fa-check';
            break;
        case 'info':
            icon = 'fa fa-info-circle fa-lg';
            break;
        case 'warning':
            icon = 'fa fa-exclamation-circle fa-lg';
            break;
        case 'danger':
            icon = 'fa fa-lock fa-lg';
            break;
        default:
            jQuery.error = "Alert type [" + type + "] incorrect";
    }

    $.notify({
        icon: icon,
        message: message
    }, {
        type: type,
        delay: delay,
        spacing: 5,
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
        '<span data-notify="icon"></span> ' +
        '<div class="alert-wrapper">' +
        '<span data-notify="title">{1}</span> ' +
        '<span data-notify="message">{2}</span>' +
        '<div class="progress" data-notify="progressbar">' +
        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
        '</div>' +
        '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>' +
        '<div class="close-wrapper"><button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button></div>' +
        '</div>'
    });
}
