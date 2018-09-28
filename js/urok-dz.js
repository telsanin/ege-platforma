/*
распределение задач УЧЕНИКА: - ИЛИ в урок ИЛИ в дз
*/

$(function(){

    $("#insert-vopros-ucheniku").click(function(e){
        sPredmet = $('#predmet').val()
        iNomerZadaniya = $('#zadanie').val()
        sTextVoprosa = $('#text-voprosa').val()
        sOtvetNaVopros = $('#otvet-na-vopros').val()
        sUchenik = $('#uchenik').val()
        //инициализируем
        // iIdVoprosa=0;

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
                //добавим в таблицу uchenik-voprosy новую строку
                $.post(
                    "/post/insert-vopros-ucheniku.php",
                    {
                        uchenik: sUchenik,
                        predmet: sPredmet,
                        idvoprosa: response,
                    },
                    function(response){
                        location.reload();
                    }
                );
                //-добавим в таблицу uchenik-voprosy новую строку
            }
        );
        //-добавим в таблицу voprosy новую строку
    });

     $(".zakonchili-na-etom").click(function(e) {

        sUchenik=$('#uchenik').val();
        iIdZadachi=$(this).attr("id").substring(18);
        if($(this).prop("checked"))
            iCheckBox=1
        else
            iCheckBox=0;

        // c.c(sUchenik);
        // c.c(iIdZadachi);
        // c.c(iCheckBox);

        //обновим таблицу uchenik-zadachi
        $.post(
            "/post/zakonchili-na-etom.php",
            {
                suchenik: sUchenik,
                idzadachi: iIdZadachi,
                icheckbox: iCheckBox,
            }
        );
        //--обновим таблицу uchenik-zadachi
    });

    $(".razaktualizirovat").click(function(e) {

        iNomerZadaniya = $(this).parent().children('.zadanie').html();
        sPredmet=$('#predmet').val();
        sUchenik=$('#uchenik').val();
        iIdPodtemy=$(this).attr("id").substring(17);

        //обновим таблицу uchenik-zadachi
        $.post(
            "/post/update-otchet.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
            },
            function(response){
                // location.reload();
            }
        );
        //--обновим таблицу uchenik-zadachi

        //обновим таблицу uchenik-zadachi
        $.post(
            "/post/razaktualizirovat.php",
            {
                suchenik: sUchenik,
                idpodtemy: iIdPodtemy,
                izadanie: iNomerZadaniya,
            },
            function(response){
                location.reload();
            }
        );
        //--обновим таблицу uchenik-zadachi

    });

    $("#provereno").click(function(e) {

        sUchenik=$('#uchenik').val();
        sPredmet=$('#predmet').val();

        //обновим таблицу uchenik-zadachi
        //поставим в поле urok 2 (новое ДЗ) везде, где стоит 3 (актуалное ДЗ)
        //поставим в поле aktualno=0
        $.post(
            "/post/provereno.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
            },
            function(response){
                location.reload();
            }
        );
        //--обновим таблицу uchenik-zadachi
    });

    $(".zadacha-uchenika-aktualna").click(function(e) {

        sUchenik=$('#uchenik').val();
        iIdZadachi=$(this).attr("id").substring(8);
        sPredmet=$('#predmet').val();

        c.c(sUchenik);
        c.c(iIdZadachi);
        c.c(sPredmet);

        if($(this).prop('checked'))
            iAktualen=1;
        else
            iAktualen=0;

        //обновим поле aktualno таблицы uchenik-zadachi
        $.post(
            "/post/zadacha-uchenika-aktualna.php",
            {
                suchenik: sUchenik,
                iidzadachi: iIdZadachi,
                iaktualno: iAktualen,
                spredmet: sPredmet,
            }
        );
        //--обновим поле aktualno таблицы uchenik-zadachi
    });

    $(".vopros-aktualen").click(function(e) {

        sUchenik=$('#uchenik').val();
        iVoprosNumber=$(this).attr("id").substring(15);

        if($(this).prop('checked'))
            iAktualen=1;
        else
            iAktualen=0;

        //обновим поле aktualno таблицы uchenik-voprosy
        //!используем уже готовый запрос!
        $.post(
            "/post/rasskazal.php",
            {
                uchenik: sUchenik,
                ivoprosnumber: iVoprosNumber,
                irasskazal: iAktualen,
            }
        );
        //--обновим поле aktualno таблицы uchenik-voprosy
    });

    // $(".vopros-rasskazal").click(function(e) {
    //
    //     sUchenik=$('#uchenik').val();
    //     iVoprosNumber=$(this).attr("id").substring(16);
    //     if($(this).prop('checked'))
    //         iRasskazal=0;
    //     else
    //         iRasskazal=1;
    //     // c.c($(this).prop('checked'));
    //
    //     //обновим поле aktualno таблицы uchenik-voprosy
    //     $.post(
    //         "/post/rasskazal.php",
    //         {
    //             uchenik: sUchenik,
    //             ivoprosnumber: iVoprosNumber,
    //             irasskazal: iRasskazal,
    //         }
    //     );
    //     //--обновим поле aktualno таблицы uchenik-voprosy
    // });

    $(".sbrosit-vremya").click(function(e) {
        $('#last-time').val(+new Date());
        // c.c($('#last-time').val());
    });

    $(".zafiksirovat-vremya").click(function(e) {

        sUchenik=$('#uchenik').val();
        iTaskNumber=$(this).attr("id").substring(19);
        iLastTime = $('#last-time').val();

        iVremyaVypolneniya = Math.round((+new Date() - iLastTime)) - 3 * 60 * 60 * 1000;//милисекунд; вычитать 3 часа приходится из-за временной зоны
        dTime = new Date(iVremyaVypolneniya);
        sVremyaVypolneniya = dTime.getHours() + ':' + dTime.getMinutes() + ':' + dTime.getSeconds();
        //c.c(iVremyaVypolneniya);
        //c.c(sVremyaVypolneniya);

        $('#last-time').val(+new Date());
        //обновим поле vremya-vypolneniya таблицы uchenik-zadachi
        $.post(
            "/post/vremya-vypolneniya.php",
            {
                idzadachi: iTaskNumber,
                uchenik: sUchenik,
                vremyavypolneniya: sVremyaVypolneniya,
            },
            GetResponseCallbackFunction
        );
        //--обновим поле vremya-vypolneniya таблицы uchenik-zadachi

        function GetResponseCallbackFunction(response) {
            /*благодаря замыканиям в JavaScript, эта callback-функция видит переменнную
             iTaskNumber
             */
            $('#fiks-vremya'+iTaskNumber).html(sVremyaVypolneniya);
            $("#fiks-vremya"+iTaskNumber).hide().fadeIn(200);
        }
    });

    $("#import-zadach-ucheniku-urok").click(function(e){

        c.c('urok');

        sUchenik = $('#uchenik').val();
        sPredmet = $('#predmet').val();
        iNomerZadaniya = $('#zadanie').val();

        //сделать запрос на добавление
        $.post(
            "/post/import-zadach-ucheniku-urok.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                izadanie: iNomerZadaniya,
            },
            function(response){
                location.reload();
            }
        );
        //-сделать запрос на добавление
    });

    $("#import-zadach-ucheniku-dz").click(function(e){

        c.c('dz');

        sUchenik = $('#uchenik').val();
        sPredmet = $('#predmet').val();
        iNomerZadaniya = $('#zadanie').val();

        //сделать запрос на добавление
        $.post(
            "/post/import-zadach-ucheniku-dz.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                izadanie: iNomerZadaniya,
            },
            function(response){
                location.reload();
            }
        );
        //-сделать запрос на добавление
    });

    $("#import-zadach-ucheniku").click(function(e){

        sUchenik = $('#uchenik').val();
        sPredmet = $('#predmet').val();
        iNomerZadaniya = $('#zadanie').val();

        //c.c(sUchenik);
        //c.c(sPredmet);
        //c.c(iNomerZadaniya);

        //сделать запрос на добавление
        $.post(
            "/post/import-zadach-ucheniku.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                izadanie: iNomerZadaniya,
            },
            function(response){
                // c.c('test');
                location.reload();
                //отладочная строка
                //c.c(response);
            }
        );
        //-сделать запрос на добавление
    });

    $(".radio-v-urok-uchenika").click(function(e){

        // c.c('test');

        sUchenik = $('#uchenik').val();
        iTaskNumber = $(this).attr("id").substring(10);

        if($(this).attr('id').indexOf("none")>0){
            $(this).parent().css({'color': 'black'});
            iVUrok=0;
        }
        if($(this).attr('id').indexOf("urok")>0){
            $(this).parent().css({'color': 'blue'});
            iVUrok=1;
        }
        if($(this).attr('id').indexOf("dzdz")>0){
            $(this).parent().css({'color': 'brown'});
            iVUrok=3;
        }
        if($(this).attr('id').indexOf("dzvy")>0){
            $(this).parent().css({'color': 'red'});
            iVUrok=2;
        }

        //сделать запрос на обновление поля urok таблицы zadacha
        $.post(
            "/post/v-urok-uchenika.php",
            {
                idzadachi: iTaskNumber,
                ivurok: iVUrok,
                suchenik: sUchenik,
            }
        );
        //-сделать запрос на обновление поля urok таблицы zadacha
    });
});