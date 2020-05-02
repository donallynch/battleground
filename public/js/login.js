/* Login */
var login = {
    init: function () {
        login.registerEvents();
    },
    registerEvents: function () {
        $(document).ready(function() {
            /* Perform login click */
            $(document).on("click", ".login-post", function() {
                login.perform($(this));
            });

            /* Login form submit on keypress */
            $('input').keypress(function (e) {
                if (e.which == 13) {
                    $(this).closest('form').find('.login-post').click();
                    return false;
                }
            });
        });
    },
    perform: function (element) {
        let form = element.closest('form'),
            data = form.serialize(),
            feedback = form.find('.feedback');

        feedback.html('');

        $.post('/login', data)
            .done(function(response) {

                feedback.html(response.status);

                console.log(response);

                $(location).attr('href', '/')
            })
            .fail(function(response){
                let json = JSON.parse(response.responseText),
                    errors = json.errors;

                feedback.append('<ul>');
                $.each(errors, function(field, value) {
                    feedback.append('<li>'+ value +'</li>');
                });
                feedback.append('</ul>');
            });
    }
};
login.init();