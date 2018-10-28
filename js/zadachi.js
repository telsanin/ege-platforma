/*
распределение задач: - ИЛИ в урок ИЛИ в дз
а также другие полезные вещи ;)
*/

$(function(){

    $('.top-block').click(function(e) {

        target=$(this).attr('id').substr(10);
        c.c(target);

        expl = location.pathname.split('/');
        location.pathname = '/' + expl[1] + '/' + expl[2] + '/' + expl[3] + '/' + expl[4] + '/' + target;
    });


    $('.tr-for-selection').click(function(e){
        $('.tr-for-selection').css('background-color','');
        $(this).css('background-color','lightyellow');

        iSelectionNumber=$(this).attr("id").substring(17);
        $('#selectionnumber').val(iSelectionNumber);

        iSelectionPodtemaNumber=$(this).attr("podt");
        $('#selectionpodtemanumber').val(iSelectionPodtemaNumber);
    });

    $('.sort-podtemu').click(function(e){

        iIdPodtemyCurrent=$('#selectionpodtemanumber').val();

        oCurrentObj = $('.tr-for-selection[podt='+iIdPodtemyCurrent+']');
        oCurrentObj.css('background-color', 'lightyellow');

        if($(this).attr('id')=='vverh-podtemu')
            iIdPodtemyOther = 1*iIdPodtemyCurrent-10;
        else
            iIdPodtemyOther = 1*iIdPodtemyCurrent+10;

        oOtherObj=$('.tr-for-selection[podt='+iIdPodtemyOther+']');

        //смысла в этом нет, но без этого почему-то глючит :(
        oOtherObj.css('border', 'solid 1px lightgray');
        //-смысла в этом нет, но без этого почему-то глючит :(

        if(oOtherObj.length) {

            if ($(this).attr('id') == 'vverh-podtemu') {
                oOtherObjFirst = $('.tr-for-selection[podt=' + iIdPodtemyOther + ']:first');
                oOtherObjFirst.before(oCurrentObj);
            }
            else {
                oOtherObjFirst = $('.tr-for-selection[podt=' + iIdPodtemyOther + ']:last');
                oOtherObjFirst.after(oCurrentObj);
            }

            oCurrentObj.attr('podt', iIdPodtemyOther);
            oOtherObj.attr('podt', iIdPodtemyCurrent);

            $('#selectionpodtemanumber').val(iIdPodtemyOther);

            iNomerZadaniya = $('#zadanie').val();
            sPredmet = $('#predmet').val();

            $.post(
                "/post/update-sort-podtemy.php",
                {
                    spredmet: sPredmet,
                    inomerzadaniya: iNomerZadaniya,
                    iidpodtemycurrent: iIdPodtemyCurrent,
                    iidpodtemyother: iIdPodtemyOther,
                },
                function (response) {
                }
            );
        }
        else {
            oCurrentObj.fadeOut('fast').fadeIn('fast');
        }
    });

    $('.sort-zadachu').click(function(e){

        iSelectionNumber=$('#selectionnumber').val();
        iSortSelection=$('#sortirovka'+iSelectionNumber).val();

        iIdPodtemyCurrent=$('#selectionpodtemanumber').val();

        if($(this).attr('id')=='vverh-zadachu')
            oOtherObj=$('#tr-for-selection-'+iSelectionNumber).prev();
        else
            oOtherObj=$('#tr-for-selection-'+iSelectionNumber).next();

        if(oOtherObj.attr('podt')) {
            iOtherSelectionNumber=oOtherObj.attr("id").substring(17);

            iSortOtherSelection=$('#sortirovka'+iOtherSelectionNumber).val();

            iIdPodtemyOther=$('#tr-for-selection-'+iOtherSelectionNumber).attr('podt');

            if(iIdPodtemyCurrent==iIdPodtemyOther) {

                sContentOfCurrent = $('#tr-for-selection-' + iSelectionNumber).html();
                sContentOfOther = $('#tr-for-selection-' + iOtherSelectionNumber).html();

                $('#tr-for-selection-' + iOtherSelectionNumber).html(sContentOfCurrent);
                $('#tr-for-selection-' + iSelectionNumber).html(sContentOfOther);

                $('#sortirovka'+iSelectionNumber).val(iSortOtherSelection);
                $('#sortirovka'+iOtherSelectionNumber).val(iSortSelection);

                sContentOfCurrent = $('#tr-for-selection-' + iSelectionNumber).html();
                sContentOfOther = $('#tr-for-selection-' + iOtherSelectionNumber).html();

                $('#tr-for-selection-' + iSelectionNumber).css('background-color', '');
                $('#tr-for-selection-' + iOtherSelectionNumber).css('background-color', 'lightyellow');


                $('#tr-for-selection-' + iSelectionNumber).attr('id','tr-for-selection-temp');
                $('#tr-for-selection-' + iOtherSelectionNumber).attr('id','tr-for-selection-'+iSelectionNumber);
                $('#tr-for-selection-temp').attr('id','tr-for-selection-'+iOtherSelectionNumber);

                $.post(
                    "/post/update-sort-zadachu.php",
                    {
                        icurrentid: iSelectionNumber,
                        iotherid: iOtherSelectionNumber,
                        icurrentsortnumber: iSortSelection,
                        iothersortnumber: iSortOtherSelection,
                    },
                    function (response) {
                        // location.reload();
                    }
                );

            }
            else {
                $('#tr-for-selection-'+iSelectionNumber).fadeOut('fast').fadeIn('fast');
            }
        }
        else {
            $('#tr-for-selection-'+iSelectionNumber).fadeOut('fast').fadeIn('fast');
        }
    });

    $("#only-sort").click(function(e) {

        iNomerZadaniya = $('#zadanie').val();
        sPredmet = $('#predmet').val();

        $.post(
            "/post/sortirovka.php",
            {
                onlysort: 1,
                inomerzadaniya: iNomerZadaniya,
                spredmet: sPredmet,
            },
            function (response) {
                location.reload();
            }
        );
    });


    $("#zadachi-sortirovka").click(function(e) {

        iNomerZadaniya = $('#zadanie').val();
        sPredmet = $('#predmet').val();

        $.post(
            "/post/sortirovka.php",
            {
                inomerzadaniya: iNomerZadaniya,
                spredmet: sPredmet,
            }
            ,
            function(response){
                // c.c(response);
                location.reload();
            }
        );
    });

    $("#upload-zadachi").click(function(e){

        $.post(
            "/post/SERVICE_import_from_txt.php"
        ,
        function (response) {
            $('#answer').html(response);
            // location.reload();
        }
        );

    });

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
                        location.reload();
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
        sIdPodtemy = $(this).pFarent().children('.id-podtemy').val();
        sPodtema = $(this).parent().children('.kommentarii').val();

        // c.c(sTextZadachi);
        // c.c(sIdPodtemy);
        // c.c(sPodtema);

        $('#text-zadachi').val(sTextZadachi);
        $('#pravilnyi-otvet').val(sPravilnyiOtvet);
        $('#reshenie').val(sReshenie);
        $('#s-moimi-ciframi').val(iSMoimiCiframi);
        $('#id-podtemy').val(sIdPodtemy);
        $('#kommentarii').val(sPodtema);

        // $("html, body").animate({scrollTop: $("body").height()}, 300);
        $("html, body").animate({scrollTop: 0}, 300);

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
        //-сделать запрос на обновление поля text-zadachi таблицы zadacha
    });

    $(".text-zadachi").focusout(function(e){

        sTextZadachi = $(this).val();
        iTaskNumber = $(this).attr("id").substring(12);

        //сделать запрос на обновление поля reshenie таблицы zadacha
        $.post(
            "/post/update-text-zadachi.php",
            {
                idzadachi: iTaskNumber,
                stextzadachi: sTextZadachi,
            }
        );
        //-сделать запрос на обновление поля text-zadachi таблицы zadacha
    });

    $(".pravilnyi-otvet").focusout(function(e){

        sPravilnyiOtvet = $(this).val();
        iTaskNumber = $(this).attr("id").substring(15);

        //сделать запрос на обновление поля pravilnyi-otvet таблицы zadacha
        $.post(
            "/post/update-pravilnyi-otvet.php",
            {
                idzadachi: iTaskNumber,
                spravilnyiotvet: sPravilnyiOtvet,
            }
        );
        //-сделать запрос на обновление поля pravilnyi-otvet таблицы zadacha
    });

    $(".sortirovka").focusout(function(e){

        iSortirovka = $(this).val();
        iIdZadachi = $(this).attr("id").substring(10);

        //сделать запрос на обновление поля sortirovka таблицы zadacha
        $.post(
            "/post/update-sortirovka.php",
            {
                iidzadachi: iIdZadachi,
                isortirovka: iSortirovka,
            }
        );
        //-сделать запрос на обновление поля sortirovka таблицы zadacha

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

        if(!(iIdPodtemy = $(this).val()))
            iIdPodtemy = $(this).html();

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
        e.preventDefault();
        sPredmet = $('#predmet').val();
        iNomerZadaniya = $('#zadanie').val();
        sTextZadachi = $('#text-zadachi').val();
        sPravilnyiOtvet = $('#pravilnyi-otvet').val();
        sReshenie = $('#reshenie').val();
        sIdPodtemy = $('#id-podtemy').val();
        sPodtema = $('#kommentarii').val();

        // c.c(sIdPodtemy);
        // c.c(sPodtema);
        // c.c(sReshenie);

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
                sidpodtemy: sIdPodtemy,
                kommentarii: sPodtema,
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