/*
проверка ответа на задачу
 */

$(function(){


    $("form.upload-form").submit(function(e){

        sUchenik = $('#uchenik').val();
        sPredmet = $('#predmet').val();
        iIdZadachi = $(this).parent().parent().children('.id-zadachi').val();

        var fileData = document.getElementById("file"+iIdZadachi);
        file = fileData.files[0];

        if(file) {

            sFileName = sUchenik + '-' + sPredmet + '-' + iIdZadachi + '.jpg';

            var formData = new FormData();
            formData.append("userfile", file, sFileName);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/post/reshenie-uchenika-upload.php");
            xhr.send(formData);

            //здесь в поле `foto-teksta` вновь добавленной задачи пропишем имя файла с картинкой
            $.post(
                "/post/update-foto-resheniya-uchenika.php",
                {
                    spredmet: sPredmet,
                    suchenik: sUchenik,
                    idzadachi: iIdZadachi,
                    sfilename: sFileName,
                },
                function (response) {
                    // location.reload();
                }
            );
        }
    });

    $(".slojnyi-otvet-checkbox").click(function(e) {

        sUchenik = $('#uchenik').val();
        sPredmet = $('#predmet').val();
        iThisId = $(this).attr("id");
        iSlojnyiOtvetNumber = iThisId.substring(iThisId.length-1);
        iOtvetilPravilno = ($(this).prop('checked')?1:0);
        iIdZadachi = $(this).parent().parent().children('.id-zadachi').val();

        iReshenoPravino = 1;
        $(this).parent().parent().find('.slojnyi-otvet-checkbox').each(function(i, elem){
            iReshenoPravino *= ($(this).prop('checked')?1:0);
            if(!iReshenoPravino) return false;
        });

        if(iReshenoPravino==0) iReshenoPravino=-1;

        $.post(
            "/post/update-slojnyi-otvet-otvetil-pravilno.php",
            {
                iotvetilpravilno: iOtvetilPravilno,
                ireshenopravino: iReshenoPravino,
                islojnyiotvetnumber: iSlojnyiOtvetNumber,
                spredmet: sPredmet,
                suchenik: sUchenik,
                idzadachi: iIdZadachi,
            }
        );
    });


    $(".zagruzit-reshenie-celikom").click(function(e) {

        sUchenik = $('#uchenik').val();
        sPredmet = $('#predmet').val();
        iThisId = $(this).attr("id");
        iIdZadachi = $(this).attr('id').substring(26);

        var fileData = document.getElementById("file"+iIdZadachi);
        file = fileData.files[0];

        if(file) {

            $(this).parent().parent().parent().find('.slojnyi-otvet-pravilnyi').show('slow');
            $(this).parent().parent().hide();
            $(this).parent().parent().parent().find('.slojnyi-otvet-uchenika').hide();
            $(this).parent().parent().parent().find('.slojnyi-otvet-otpravit').hide();

            sFileName = sUchenik + '-' + sPredmet + '-' + iIdZadachi + '.jpg';

            var formData = new FormData();
            formData.append("userfile", file, sFileName);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/post/reshenie-uchenika-upload.php");
            xhr.send(formData);

            //здесь в поле `foto-teksta` вновь добавленной задачи пропишем имя файла с картинкой
            $.post(
                "/post/update-foto-resheniya-uchenika.php",
                {
                    spredmet: sPredmet,
                    suchenik: sUchenik,
                    idzadachi: iIdZadachi,
                    sfilename: sFileName,
                },
                function (response) {
                    $.post(
                        "/post/kolichestvo-popytok.php",
                        {
                            idzadachi: iIdZadachi,
                            uchenik: sUchenik,
                        },
                        function(response){
                            $.post(
                                "/post/resheno-pravilno.php",
                                {
                                    idzadachi: iIdZadachi,
                                    uchenik: sUchenik,
                                    predmet: sPredmet,
                                    result: -1,
                                }
                            );
                        }
                    );

                }
            );
        }

    });

    // $(".zagruzit-reshenie-celikom").click(function(e) {
    //     sUchenik = $('#uchenik').val();
    //     sPredmet = $('#predmet').val();
    //     iThisId = $(this).attr("id");
    //     iIdZadachi = $(this).attr('id').substring(26);
    //
    //     $(this).parent().parent().find('.slojnyi-otvet-pravilnyi').show('slow');
    //     $(this).parent().hide();
    //
    //     $.post(
    //         "/post/kolichestvo-popytok.php",
    //         {
    //             idzadachi: iIdZadachi,
    //             uchenik: sUchenik,
    //         },
    //         function(response){
    //             $.post(
    //                 "/post/resheno-pravilno.php",
    //                 {
    //                     idzadachi: iIdZadachi,
    //                     uchenik: sUchenik,
    //                     predmet: sPredmet,
    //                     result: -1,
    //                 }
    //             );
    //         }
    //     );
    // });


    $(".slojnyi-otvet-otpravit").click(function(e) {

        sUchenik = $('#uchenik').val();
        sPredmet = $('#predmet').val();
        iThisId = $(this).attr("id");
        iSlojnyiOtvetNumber = iThisId.substring(iThisId.length-1);
        sSlojnyiOtvetUchenika = $(this).parent().children('#slojnyi-otvet-uchenika-'+iSlojnyiOtvetNumber).val().replace(/'/g, "\\\'").replace(/\"/g, "\\\"").replace(/>/g, "&gt;").replace(/</g, "&lt;");
        //заменяем
        //' на \'
        //и
        //" на \"
        //и
        //< на &lt;
        //и
        //> на &gt;
        // c.c(sSlojnyiOtvetUchenika);
        iIdZadachi = $(this).parent().children('.id-zadachi').val();

        $(this).parent().children('#slojnyi-otvet-pravilnyi-'+iSlojnyiOtvetNumber).show('slow');
        $(this).hide();

        $.post(
            "/post/update-slojnyi-otvet.php",
            {
                sslojnyiotvetuchenika: sSlojnyiOtvetUchenika,
                islojnyiotvetnumber: iSlojnyiOtvetNumber,
                spredmet: sPredmet,
                suchenik: sUchenik,
                idzadachi: iIdZadachi,
            }
        );

    });


    $("#skryt-reshennye").click(function(e) {

        sUchenik = $('#uchenik').val();
        sPredmet = $('#predmet').val();
        iSkrytReshennye = ($(this).prop('checked')?1:0);

        // c.c(sUchenik);
        // c.c(sPredmet);
        // c.c(iSkrytReshennye);

        //здесь надо скрыть со страницы решенные задачи
        if(iSkrytReshennye)
            $('.zadacha[resheno-pravilno=1]').hide('slow')
        else
            $('.zadacha').show('slow');
        //-здесь надо скрыть со страницы решенные задачи

        $.post(
            "/post/skryt-reshennye.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                iskrytreshennye: iSkrytReshennye,
            }
        );
    })

    $("input.vsyo-ploho").click(function(e) {

        sUchenik = $('#uchenik').val();
        iTaskNumber = $(this).attr("id").substring(10);
        iRazobratNaZanyatii = ($('#vsyo-ploho'+iTaskNumber).prop('checked')?1:0);

        //обновим поле razobrat-na-zanyatii таблицы uchenik-zadachi
        $.post(
            "/post/razobrat-na-zanyatii.php",
            {
                idzadachi: iTaskNumber,
                uchenik: sUchenik,
                razobratnazanyatii: iRazobratNaZanyatii,
            }
        );
        //-обновим поле razobrat-na-zanyatii таблицы uchenik-zadachi
    })

	$("button.uveren").click(function(e) {

        sUchenik=$('#uchenik').val();
        sPredmet=$('#predmet').val();
        iTaskNumber=$(this).attr("id").substring(6);
        sOtvetUchenika=$('#input'+iTaskNumber).val();
        iLastZadacha=$('#last-zadacha').val();
        // iBeginTime = $('#begin-time').val();
        iEndTime = $('#end-time').val();

        tt=$('#vremya-predyduschih-popytok'+iTaskNumber).val().split(":");
        iVremyaPredyduschihPopytok = (tt[0]*3600+tt[1]*60+tt[2]*1)*1000;

        //обновим поле kolichestvo-popytok таблицы uchenik-zadachi
        $.post(
            "/post/kolichestvo-popytok.php",
            {
                idzadachi: iTaskNumber,
                uchenik: sUchenik,
            }
        );
        //-обновим поле kolichestvo-popytok таблицы uchenik-zadachi

        tNow=+new Date();

        // if(iTaskNumber!=iLastZadacha){
            //приступил к новой задаче
            iVremyaVypolneniya = iVremyaPredyduschihPopytok + Math.round(tNow - iEndTime) - 3 * 60 * 60 * 1000;//милисекунд; вычитать 3 часа приходится из-за временной зоны
            // $('#begin-time').val(iEndTime);
        // }
        // else {
            //решает ту же задачу
            // iVremyaVypolneniya = iVremyaPredyduschihPopytok + Math.round((tNow) - iBeginTime) - 3 * 60 * 60 * 1000;//милисекунд; вычитать 3 часа приходится из-за временной зоны
        // }
        dTime = new Date(iVremyaVypolneniya);
        sVremyaVypolneniya = dTime.getHours() +':' +  dTime.getMinutes() +':' +  dTime.getSeconds();
        $('#vremya-predyduschih-popytok'+iTaskNumber).val(sVremyaVypolneniya);

        $('#end-time').val(tNow);
        $('#last-zadacha').val(iTaskNumber);

        //$('#begin-time').val(iEndTime);

        // c.c('пред задача: '+iTaskNumber);
        // c.c('тек задача: '+iTaskNumber);
        // c.c('старт: '+$('#begin-time').val());
        // c.c('конец: '+$('#end-time').val());
        // c.c('-----------------------------------');

        //обновим поле vremya-vypolneniya таблицы uchenik-zadachi
        $.post(
            "/post/vremya-vypolneniya.php",
            {
                idzadachi: iTaskNumber,
                uchenik: sUchenik,
                vremyavypolneniya: sVremyaVypolneniya,
            }
        );
        //--обновим поле vremya-vypolneniya таблицы uchenik-zadachi

        //получим правильный ответ на задачу из БД
		$.get(
			"/get/pravilnyi-otvet-na-zadazhu.php",
			{
                idzadachi: iTaskNumber,
			},
            GetResponseCallbackFunction
		);
		//-получим правильный ответ на задачу из БД

        function GetResponseCallbackFunction(response) {
			/*благодаря замыканиям в JavaScript, эта callback-функция видит переменнные
			 iTaskNumber
			 и
			 sOtvetUchenika
			*/
            if(sOtvetUchenika==response) {

                //ответ ученика совпадает с правильным ответом
                $("#result"+iTaskNumber).html('Правильно :)');
                $("#result"+iTaskNumber).hide().fadeIn();
                $("#result"+iTaskNumber).css("color","lime");
                $("#uveren"+iTaskNumber).hide();
                $("#div-vsyo-ploho"+iTaskNumber).hide();
                //$("#dontknow"+iTaskNumber).hide();
                //обновим поле resheno таблицы uchenik-zadachi
                iResult=1;
                $.post(
                    "/post/resheno-pravilno.php",
                    {
                        idzadachi: iTaskNumber,
                        uchenik: sUchenik,
                        predmet: sPredmet,
                        result: iResult,
                    }
                );
                //-обновим поле resheno таблицы uchenik-zadachi
                //обновим поле razobrat-na-zanyatii таблицы uchenik-zadachi
                // $.post(
                //     "/post/razobrat-na-zanyatii.php",
                //     {
                //         idzadachi: iTaskNumber,
                //         uchenik: sUchenik,
                //         razobratnazanyatii: 0,
                //     }
                // );
                //-обновим поле razobrat-na-zanyatii таблицы uchenik-zadachi

            }
            else{

                // c.c(sOtvetUchenika);
                // c.c(response);

                $("#result"+iTaskNumber).html('Неправильно :(');
                $("#result"+iTaskNumber).hide().fadeIn();
                $("#result"+iTaskNumber).css("color","red");
                iResult=-1;
                $.post(
                    "/post/resheno-pravilno.php",
                    {
                        idzadachi: iTaskNumber,
                        uchenik: sUchenik,
                        predmet: sPredmet,
                        result: iResult,
                    }
                );
            }
            $('#kolichestvo'+iTaskNumber).html(Number($('#kolichestvo'+iTaskNumber).html())+1);
            $('#kolichestvo-popytok'+iTaskNumber).show();

            //отладочная строка
            //c.c(response);
        }
	})
});