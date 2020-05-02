/* CreatePlayer */
var createPlayer = {
    init: function () {
        createPlayer.registerEvents();
    },
    registerEvents: function () {

        $(document).ready(function() {
            $(document).on("click", ".create-player-post", function() {
                createPlayer.perform($(this));
            });
        });
    },
    perform: function (element) {
        let form = element.closest('form'),
            data = form.serialize(),
            feedback = form.find('.feedback');

        feedback.html('');

        $.post('/create-player', data)
            .done(function(response) {
                let status = response.status;
                feedback.html(status);
            })
            .fail(function(response){
                let json = JSON.parse(response.responseText),
                    errors = json.errors;

                $.each(errors, function(field, value) {
                    feedback.append('<ul>');
                    feedback.append('<li>'+ value +'</li>');
                    feedback.append('</ul>');
                });
            });
    }
};
createPlayer.init();