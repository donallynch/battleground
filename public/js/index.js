let index = {
    init: function () {
        index.registerEvents();
    },
    registerEvents: function () {
        $(document).ready(function() {
            $(document).on("click", ".learn-more", function() {
                let modal = $('#learn-more-modal');

                modal.modal('show');
            });
        });
    }
};
index.init();