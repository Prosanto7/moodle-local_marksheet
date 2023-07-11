 define([
    'jquery',
    'core/ajax',
    'core/str',
    'core/modal_factory',
    'core/modal_events',
    'core/notification'
 ], function($, Ajax, str, ModalFactory, ModalEvents) {
        $('.delete-btn').on('click', function() {
            let elementId = $(this).attr('id');
            let arr = elementId.split("-");
            let markId = arr[arr.length - 1];
            ModalFactory.create({
                type: ModalFactory.types.SAVE_CANCEL,
                title: str.get_string('deletetitle', 'local_marksheet', '', ''),
                body: str.get_string('modalmessage', 'local_marksheet', '', '')
            }).then(function(modal) {
                modal.setSaveButtonText(str.get_string('delete', 'local_marksheet', '', ''));
                let root = modal.getRoot();
                root.on(ModalEvents.save, function() {
                    let wsfunction = 'local_marksheet_delete_mark_by_id';
                    let params = {
                        'markid': markId,
                    };
                    let request = {
                        methodname: wsfunction,
                        args: params
                    };
                    Ajax.call([request])[0].done(function() {
                        window.location.href = $(location).attr('href');
                    }).fail(function() {
                        window.location.href = $(location).attr('href');
                    });
                });
                modal.show();
            });
        });
 });