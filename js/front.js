/*
проверка ответа на задачу
 */

$(function(){

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
        iTaskNumber=$(this).attr("id").substring(6);
        sOtvetUchenika=$('#input'+iTaskNumber).val();

        iLastTime = $('#last-time').val();
        iLastZadacha = $('#last-zadacha').val();

        //c.c(sUchenik);
        //c.c(iTaskNumber);
        //c.c(iRazobratNaZanyatii);

        //обновим поле kolichestvo-popytok таблицы uchenik-zadachi
        $.post(
            "/post/kolichestvo-popytok.php",
            {
                idzadachi: iTaskNumber,
                uchenik: sUchenik,
            }
        );
        //-обновим поле kolichestvo-popytok таблицы uchenik-zadachi

        if(iTaskNumber!=iLastZadacha) {

            //c.c(iLastTime);
            //c.c(+new Date());

            iVremyaVypolneniya =  Math.round((+new Date() - iLastTime))-3*60*60*1000;//милисекунд; вычитать 3 часа приходится из-за временной зоны
            dTime = new Date(iVremyaVypolneniya);
            sVremyaVypolneniya = dTime.getHours() +':' +  dTime.getMinutes() +':' +  dTime.getSeconds();
            //c.c(iVremyaVypolneniya);
            //c.c(sVremyaVypolneniya);


            $('#last-zadacha').val(iTaskNumber);
            $('#last-time').val(+new Date());
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
        }

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
                $("#result"+iTaskNumber).css("color","green");
                $("#uveren"+iTaskNumber).hide();
                $("#div-vsyo-ploho"+iTaskNumber).hide();
                //$("#dontknow"+iTaskNumber).hide();
                //обновим поле resheno таблицы uchenik-zadachi
                $.post(
                    "/post/resheno-pravilno.php",
                    {
                        idzadachi: iTaskNumber,
                        uchenik: sUchenik,
                    }
                );
                //-обновим поле resheno таблицы uchenik-zadachi
                //обновим поле razobrat-na-zanyatii таблицы uchenik-zadachi
                $.post(
                    "/post/razobrat-na-zanyatii.php",
                    {
                        idzadachi: iTaskNumber,
                        uchenik: sUchenik,
                        razobratnazanyatii: 0,
                    }
                );
                //-обновим поле razobrat-na-zanyatii таблицы uchenik-zadachi

            }
            else{
                $("#result"+iTaskNumber).html('Неправильно :(');
                $("#result"+iTaskNumber).hide().fadeIn();
                $("#result"+iTaskNumber).css("color","red");
            }
            $('#kolichestvo'+iTaskNumber).html(Number($('#kolichestvo'+iTaskNumber).html())+1);
            $('#kolichestvo-popytok'+iTaskNumber).show();

            //отладочная строка
            //c.c(response);
        }
	})
});