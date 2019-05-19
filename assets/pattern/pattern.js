//READY
$(document).ready(function () {

    //MASK PHONE
    $(".phone").mask('(00) 00000-0000', {placeholder: "(00) 0000-0000"});

    //ATIVANDO O AUTOSIZE DOS TEXTAREAS
    autosize(document.querySelectorAll("textarea"));

});
//MAIL
function SendMail(){
    $.ajax({
        type    : "post",
        url     : "mail.php",
        dataType: "json",
        data    : {
            name    : $("#name").val(),
            email   : $("#email").val(),
            phone   : $("#phone").val(),
            body    : $("#body").val()
        },
        success: function (response) {
            
            var n = noty({
                text        : "<div><p class='text-noty-justify'>A mensagem foi enviada com sucesso ! Em breve retornaremos !</p></div>",
                type        : 'success',
                dismissQueue: true,
                closeWith   : ['click', 'backdrop'],
                timeout		: false,
                modal       : true,
                layout      : 'center',
                theme       : 'bootstrapTheme',
                maxVisible  : 10,
                animation   : {
                    open  : 'animated bounceInRight',
                    close : 'animated bounceOutRight',
                    easing: 'swing',
                    speed : 50
                },
                buttons     : [
                    {
                        addClass: 'btn btn-sm btn-noty btn-success', 
                        text: 'OK', 
                        onClick:
                        function ($noty) {
                            $noty.closeCleanUp();
                            //AÇÕES PAR A O BUTTON OK
                        }
                    }
                ]
            });

            $("#name").val("").change();
            $("#email").val("").change();
            $("#phone").val("").change();
            $("#body").val("").blur();

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("Erro ao Realizar Requisição Para Mail !");
        }
    });
}