/*
проверка ответа на задачу
 */

$(function(){



    $(".slojnyi-otvet-otpravit").click(function(e) {

        iSlojnyiOtvenNumber = $(this).attr("id").substring(23);
        $('#slojnyi-otvet-pravilnyi-'+iSlojnyiOtvenNumber).show('slow');

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