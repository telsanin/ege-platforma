/*
распределение задач: - ИЛИ в урок ИЛИ в дз
*/

$(function(){

    $("form#fileForm").submit(function(e){
        e.preventDefault();

        sPredmet = $('#predmet').val();
        iNomerZadaniya = $('#zadanie').val();

        var formData = new FormData();
        var fileData = document.getElementById("file");
        file = fileData.files[0];

        //здесь надо как-то брать id вновь добавленной задачи и это будет имя файла

        formData.append("userfile", file, sPredmet+'-'+iNomerZadaniya+'-'+'123.jpg');

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/post/file-upload.php");
        xhr.send(formData);

        //здесь в полу "имя файла" вновь добавленной задачи нужно прописать имя файла с картинкой

        // $.post(
        //     "/post/file-upload.php",
        //     {
        //         data: formData,
        //     },
        //     function(response){
        //         c.c(response);
        //     }
        // );

    });


    $(".copy-task").click(function(e){

        sPredmet = $('#predmet').val();
        iNomerZadaniya = $('#zadanie').val();
        sTextZadachi = $(this).parent().children('.text-zadachi').html();
        sPravilnyiOtvet = $(this).parent().children('.pravilnyi-otvet').html();
        sReshenie = $(this).parent().children('.reshenie').val();
        iSMoimiCiframi = ($(this).parent().children('.s-moimi-ciframi').prop('checked')?1:0);

        $('#text-zadachi').val(sTextZadachi);
        $('#pravilnyi-otvet').val(sPravilnyiOtvet);
        $('#reshenie').val(sReshenie);
        $('#s-moimi-ciframi').val(iSMoimiCiframi);

        $("html, body").animate({scrollTop: $("body").height()}, 300);

    });

    $(".reshenie").focusout(function(e){

        sReshenie = $(this).val();
        iTaskNumber = $(this).attr("id").substring(8);

        // c.c(sReshenie);
        // c.c(iTaskNumber);

        //сделать запрос на обновление поля reshenie таблицы zadacha
        $.post(
            "/post/reshenie.php",
            {
                idzadachi: iTaskNumber,
                sreshenie: sReshenie,
            }
        );
        //-сделать запрос на обновление поля reshenie таблицы zadacha
    });

    $(".kommentarii").focusout(function(e){

        sKommentarii = $(this).val();
        iTaskNumber = $(this).attr("id").substring(11);

            //сделать запрос на обновление поля kommentarii таблицы zadacha
            $.post(
                "/post/kommentarii.php",
                {
                    idzadachi: iTaskNumber,
                    skommentarii: sKommentarii,
                }
            );
        //-сделать запрос на обновление поля kommentarii таблицы zadacha

    });

    $(".id-podtemy").focusout(function(e){

        iIdPodtemy = $(this).val();
        iTaskNumber = $(this).attr("id").substring(10);

        //сделать запрос на обновление поля id-podtemy таблицы zadacha
        $.post(
            "/post/id-podtemy.php",
            {
                idzadachi: iTaskNumber,
                idpodtemy: iIdPodtemy,
            }
        );
        //-сделать запрос на обновление поля id-podtemy таблицы zadacha

    });


    $(".radio-v-urok").click(function(e){

        iTaskNumber = $(this).attr("id").substring(10);

        if($(this).attr('id').indexOf("none")>0){
            $(this).parent().css({'color': 'black'});
            iVUrok=0;
        }
        if($(this).attr('id').indexOf("urok")>0){
            $(this).parent().css({'color': 'blue'});
            iVUrok=1;
        }
        if($(this).attr('id').indexOf("dz")>0){
            $(this).parent().css({'color': 'brown'});
            iVUrok=3;
        }

        //сделать запрос на обновление поля urok таблицы zadacha
        $.post(
            "/post/v-urok.php",
            {
                idzadachi: iTaskNumber,
                ivurok: iVUrok,
            }
        );
        //-сделать запрос на обновление поля urok таблицы zadacha
    });

    $("#insert-vopros").click(function(e){
        sPredmet = $('#predmet').val()
        iNomerZadaniya = $('#zadanie').val()
        sTextVoprosa = $('#text-voprosa').val()
        sOtvetNaVopros = $('#otvet-na-vopros').val()

        //добавим в таблицу voprosy новую строку
        $.post(
            "/post/insert-vopros.php",
            {
                predmet: sPredmet,
                nomerzadaniya: iNomerZadaniya,
                textvoprosa: sTextVoprosa,
                otvetnavopros: sOtvetNaVopros,
            },
            function(response){
                location.reload();
            }
        );
        //-добавим в таблицу voprosy новую строку
    });

    $("#insert-zadacha").click(function(e){
        sPredmet = $('#predmet').val()
        iNomerZadaniya = $('#zadanie').val()
        sTextZadachi = $('#text-zadachi').val()
        sPravilnyiOtvet = $('#pravilnyi-otvet').val()
        sReshenie = $('#reshenie').val()
        if($('#s-moimi-ciframi').prop('checked'))
            iSMoimiCiframi = 1
        else
            iSMoimiCiframi = 0;

        //добавим в таблицу zadacha новую строку
        $.post(
            "/post/insert-zadacha.php",
            {
                predmet: sPredmet,
                nomerzadaniya: iNomerZadaniya,
                textzadachi: sTextZadachi,
                pravilnyiotvet: sPravilnyiOtvet,
                reshenie: sReshenie,
                smoimiciframi: iSMoimiCiframi,
            },
            function(response){
                location.reload();
                //отладочная строка
                //c.c(response);
            }
        );
        //-добавим в таблицу zadacha новую строку
    });

});