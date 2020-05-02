/* submitBattle */
var submitBattle = {
    init: function () {
        submitBattle.registerEvents();
    },
    registerEvents: function () {

        $(document).ready(function() {
            $(document).on("click", ".submit-battle-post", function() {
                submitBattle.perform($(this));
            });
        });
    },
    perform: function (element) {
        let form = element.closest('form'),
            data = form.serialize(),
            feedback = form.find('.feedback');

        feedback.html('');

        $.post('/submit-battle', data)
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
submitBattle.init();