function popNotif(options = {}) {
    let timeout = options.time ? options.time : 5000;
    let config = { timeOut: timeout, extendedTimeOut: 1000, closeButton: true, closeDuration: 300, progressBar: true, closeHtml: '<button><i class="fal fa-times"></i></button>' }
    if (options.tipo == 'error') {
        let msg = (options.msg ? options.msg : 'Falha!');
        if (options.titulo) {
            toastr.error(msg, options.titulo, config);
        } else {
            toastr.error('', msg, config);
        }

        if (options.campos) {
            options.campos.forEach(campo => {
                $(`[name=${campo}]`).addClass('f-error');
                $(`[name=${campo}]`).off('focus.error').on('focus.error', function () {
                    $(`[name=${campo}]`).removeClass('f-error');
                });
            });
        }
    } else if (options.tipo == 'atencao') {
        let msg = (options.msg ? options.msg : 'Atenção!');
        if (options.titulo) {
            toastr.warning(msg, options.titulo, config);
        } else {
            toastr.warning('', msg, config);
        }
    } else {
        let msg = (options.msg ? options.msg : 'Sucesso!');

        config.positionClass = 'toast-top-center';
        if (options.titulo) {
            toastr.success(msg, options.titulo, config);
        } else {
            toastr.success('', msg, config);
        }
    }

    if (options.console) console.log(options.console);
}
