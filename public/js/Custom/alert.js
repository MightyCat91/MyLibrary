function Alert(type, message, customDelay) {
    var icon, delay;
    console.log(typeof customDelay);
    if (typeof customDelay === 'undefined') {
        delay = 3500;
    } else {
        delay = customDelay;
    }

    console.log(delay);
    switch(type) {
        case 'success':
            icon = 'fa fa-check';
            break;
        case 'info':
            icon = 'fa fa-info';
            break;
        case 'warning':
            icon = 'fa fa-exclamation-circle';
            break;
        case 'error':
            icon = 'fa fa-times';
            break;
        default:
            jQuery.error = "Alert type [" + type + "] incorrect";
    }

    $.notify({
        icon: icon,
        message: message
    },{
        type: type,
        delay: delay,
        spacing: 5
    });
}
