/*
распределение задач: - ИЛИ в урок ИЛИ в дз
*/

$(function(){

    $("form.upload-form").submit(function(e){

        // e.preventDefault();

        sPredmet = $('#predmet').val();
        iNomerZadaniya = $('#zadanie').val();
        iIdZadachi = $(this).attr("id").substring(3);

        // c.c(sPredmet);
        // c.c(iNomerZadaniya);
        // c.c(iIdZadachi);

        var fileData = document.getElementById("file"+iIdZadachi);
        file = fileData.files[0];

        if(file) {

            sFileName = sPredmet + '-' + iNomerZadaniya + '-' + iIdZadachi + '.jpg';

            var formData = new FormData();
            formData.append("userfile", file, sFileName);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/post/file-upload.php");
            xhr.send(formData);

            // так почему-то не работает..
            // $.post(
            //     "/post/file-upload.php",
            //     {
            //         data: formData,
            //     },
            //     function(response){
            //         c.c(response);
            //     }
            // );

            //здесь в поле `foto-teksta` вновь добавленной задачи пропишем имя файла с картинкой
            $.post(
                "/post/update-zadacha.php",
                {
                    iidzadachi: iIdZadachi,
                    sfilename: sFileName,
                },
                function (response) {
                    // location.reload();
                }
            );
        }
    });

    $("form#fileForm").submit(function(e){
    //загрузка файла с картинкой для новой задачи
        // e.preventDefault();

        // c.c('test');

        sPredmet = $('#predmet').val();
        iNomerZadaniya = $('#zadanie').val();
        sTextZadachi = $('#text-zadachi').val();
        sPravilnyiOtvet = $('#pravilnyi-otvet').val();
        sReshenie = $('#reshenie').val();
        if($('#s-moimi-ciframi').prop('checked'))
            iSMoimiCiframi = 1;
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
            },GetResponseCallbackFunction
        );
        //--обновим поле vremya-vypolneniya таблицы uchenik-zadachi

        function GetResponseCallbackFunction(response) {
            //благодаря замыканиям в JavaScript, эта callback-функция видит переменнные

            var fileData = document.getElementById("file");
            file = fileData.files[0];

            if(file) {

                // c.c(response);
                iIdZadachi = Number(response);
                // c.c(iIdZadachi);

                //здесь надо берем id вновь добавленной задачи и это будет имя файла
                sFileName = sPredmet + '-' + iNomerZadaniya + '-' + iIdZadachi + '.jpg';

                // c.c(sFileName);

                var formData = new FormData();
                formData.append("userfile", file, sFileName);
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "/post/file-upload.php");
                xhr.send(formData);

                // так почему-то не работает..
                // $.post(
                //     "/post/file-upload.php",
                //     {
                //         data: formData,
                //     },
                //     function(response){
                //         c.c(response);
                //     }
                // );

                //здесь в поле `foto-teksta` вновь добавленной задачи пропишем имя файла с картинкой
                $.post(
                    "/post/update-zadacha.php",
                    {
                        iidzadachi: iIdZadachi,
                        sfilename: sFileName,
                    },
                    function (response) {
                        // location.reload();
                    }
                );
            }
        }
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
        sPredmet = $('#predmet').val();
        iNomerZadaniya = $('#zadanie').val();
        sTextVoprosa = $('#text-voprosa').val();
        sOtvetNaVopros = $('#otvet-na-vopros').val();

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
        sPredmet = $('#predmet').val();
        iNomerZadaniya = $('#zadanie').val();
        sTextZadachi = $('#text-zadachi').val();
        sPravilnyiOtvet = $('#pravilnyi-otvet').val();
        sReshenie = $('#reshenie').val();
        if($('#s-moimi-ciframi').prop('checked'))
            iSMoimiCiframi = 1;
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