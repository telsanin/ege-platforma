/*
распределение задач УЧЕНИКА: - ИЛИ в урок ИЛИ в дз
*/

$(function(){

    $("#dz").click(function(e) {
        expl = location.pathname.split('/');
        if($('#rejim').prop('checked')) {
            if (location.pathname.indexOf('-uchenika') != -1)
                location.pathname = '/'+expl[1]+'/'+expl[2]+'/'+expl[3]+'/'+'dz'+'-uchenika';
        }
        else
        if (location.pathname.indexOf('-uchenika') == -1)
            location.pathname = '/'+expl[1]+'/'+expl[2]+'/'+expl[3]+'/'+'dz';
    });

    $("#urok").click(function(e) {
        expl = location.pathname.split('/');
        if($('#rejim').prop('checked')) {
            if (location.pathname.indexOf('-uchenika') != -1)
                location.pathname = '/'+expl[1]+'/'+expl[2]+'/'+expl[3]+'/'+'urok'+'-uchenika';
        }
        else
            if (location.pathname.indexOf('-uchenika') == -1)
                location.pathname = '/'+expl[1]+'/'+expl[2]+'/'+expl[3]+'/'+'urok';
    });

    $("#otchet").click(function(e) {
        expl = location.pathname.split('/');
        if($('#rejim').prop('checked')) {
            if (location.pathname.indexOf('-uchenika') != -1)
                location.pathname = '/'+expl[1]+'/'+expl[2]+'/'+expl[3]+'/'+'otchet'+'-uchenika';
        }
        else
        if (location.pathname.indexOf('-uchenika') == -1)
            location.pathname = '/'+expl[1]+'/'+expl[2]+'/'+expl[3]+'/'+'otchet';
    });

    $("#rejim").click(function(e) {
        if(location.pathname.indexOf('dz')!=-1||location.pathname.indexOf('urok')!=-1||location.pathname.indexOf('otchet')!=-1)
            if($(this).prop('checked')) {
                if (location.pathname.indexOf('-uchenika') == -1)
                    location.pathname += '-uchenika';
            }
            else
                if (location.pathname.indexOf('-uchenika') != -1)
                    location.pathname=location.pathname.slice(0, location.pathname.indexOf('-uchenika'));
    });

    $(".data-zanyatiya-input").focusout(function(e) {

        sUchenik=$('#uchenik').val();
        sPredmet=$('#predmet').val();
        sDateFrom=$(this).parent().children('.data-zanyatiya').html();
        sDateTo=$(this).val();

        $.post(
            "/post/update-data-zanyatiya.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                sdatefrom: sDateFrom,
                sdateto: sDateTo,
            },
            function(response){
                location.reload();
            }
        );
    });


    $(".otchet-kommentarii").focusout(function(e) {

        sUchenik=$('#uchenik').val();
        sPredmet=$('#predmet').val();
        sKommentarii=$(this).val();
        sDate=$(this).parent().children('.data-zanyatiya').html();

        sId = $(this).attr("id");
        aId = sId.split('-');
        sCvet = aId[1];

        $.post(
            "/post/update-otchet-kommentarii.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                skommentarii: sKommentarii,
                sdate: sDate,
                scvet: sCvet,
            }
        );
    });

    $("#kommentarii").focusout(function(e) {

        sUchenik=$('#uchenik').val();
        sPredmet=$('#predmet').val();
        sKommentarii=$(this).val();

        c.c(sUchenik);
        c.c(sPredmet);
        c.c(sKommentarii);

        //обновим таблицу uchenik-predmet
        $.post(
            "/post/update-kommentarii.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                skommentarii: sKommentarii,
            }
        );
        //--обновим таблицу uchenik-zadachi
    });

    $("#ssylka-na-dz-reshu-ege").focusout(function(e) {

        sUchenik=$('#uchenik').val();
        sPredmet=$('#predmet').val();
        sSsylkaNaDzReshuEge=$(this).val();

        // c.c(sUchenik);
        // c.c(sPredmet);
        // c.c(sSsylkaNaDzReshuEge);

        //обновим таблицу uchenik-predmet
        $.post(
            "/post/update-ssylka-na-dz-reshu-ege.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                ssylka: sSsylkaNaDzReshuEge,
            }
        );
        //--обновим таблицу uchenik-zadachi
    });

    $(".vosstanovil").click(function(e) {

        sId = $(this).attr("id");
        aId = sId.split('-');
        sUchenik = aId[0];
        sPredmet = aId[1];
        sKuda = aId[2];

        //вызнвать по AJAX: добавить строку в таблицу otchet
        //ученик предмет дата

        switch(sKuda) {
            case 'plus':
                sKuda='+1';
                break;
            case 'minus':
                sKuda='-1';
                break;
        }
        $.post(
            "/post/vosstanovil.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                skuda: sKuda,
            }
        );
        //-вызнвать по AJAX: обновить строку в таблице uchenik-predmet
    });

    $(".propustil").click(function(e) {

        sId = $(this).attr("id");

        aId = sId.split('-');

        sUchenik = aId[0];
        sPredmet = aId[1];
        sKogda = aId[2];

        var dDate = new Date();
        year = dDate.getFullYear();
        month = dDate.getMonth();
        day = dDate.getDate();

        switch (sKogda) {
            case 'vchera':
                day--;
                break;
            case 'zavtra':
                day++;
                break;
            case 'poslezavtra':
                day++;
                day++;
                break;
        }

        sDate = year + '.' + ('0' + (month + 1)).slice(-2) + '.' + ('0' + day).slice(-2);

        //вызнвать по AJAX: добавить строку в таблицу otchet
        //ученик предмет дата
        $.post(
            "/post/update-otchet-propustil.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                sdate: sDate,
            }
        );
        //-вызнвать по AJAX: обновить строку в таблице uchenik-predmet
    });

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
        sPredmet=$('#predmet').val();
        iIdZadachi=$(this).attr("id").substring(18);
        if($(this).prop("checked")) {
            iCheckBox = 1
            $(this).parent().parent().css('font-weight', 'bold');
        }
        else {
            iCheckBox = 0;
            $(this).parent().parent().css('font-weight', 'normal');
        }

        //обновим таблицу uchenik-zadachi
        $.post(
            "/post/zakonchili-na-etom.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                idzadachi: iIdZadachi,
                icheckbox: iCheckBox,
            }, function(response){
                // location.reload();
            }
        );
        //--обновим таблицу uchenik-zadachi
    });

    $(".razaktualizirovat").click(function(e) {

        sUchenik=$('#uchenik').val();
        sPredmet=$('#predmet').val();
        // iIdPodtemy=$(this).attr("id").substring(17);
        iNomerZadaniya = $(this).parent().children('.zadanie').html();
        iSortirovka = $(this).attr("id").substring(17);

        //обновим таблицу uchenik-zadachi
        $.post(
            "/post/update-otchet.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                // idpodtemy: iIdPodtemy,
                izadanie: iNomerZadaniya,
                isortirovka: iSortirovka,
            },
            function(response){
                //обновим таблицу uchenik-zadachi
                $.post(
                    "/post/razaktualizirovat.php",
                    {
                        suchenik: sUchenik,
                        spredmet: sPredmet,
                        // idpodtemy: iIdPodtemy,
                        izadanie: iNomerZadaniya,
                        isortirovka: iSortirovka,
                    },
                    function(response){
                        location.reload();
                    }
                );
                //--обновим таблицу uchenik-zadachi
            }
        );
        //--обновим таблицу uchenik-zadachi
    });

    $("#razakrualizirovat-vse-aktualnye").click(function(e) {

        sUchenik=$('#uchenik').val();
        sPredmet=$('#predmet').val();

        //обновим таблицу uchenik-zadachi
        $.post(
            "/post/razakrualizirovat-vse-aktualnye.php",
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

    $("#provereno").click(function(e) {

        sUchenik=$('#uchenik').val();
        sPredmet=$('#predmet').val();

        //обновим таблицу uchenik-zadachi
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

    $("#novye-sdelat-tekuschimi").click(function(e) {

        sUchenik=$('#uchenik').val();
        sPredmet=$('#predmet').val();

        //обновим таблицу uchenik-zadachi
        $.post(
            "/post/novye-sdelat-tekuschimi.php",
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
            "/post/vopros-aktualen.php",
            {
                uchenik: sUchenik,
                ivoprosnumber: iVoprosNumber,
                irasskazal: iAktualen,
            }
        );
        //--обновим поле aktualno таблицы uchenik-voprosy
    });

    $(".zafiksirovat").click(function(e) {

        sUchenik=$('#uchenik').val();
        sPredmet=$('#predmet').val();

        sId = $(this).attr("id");
        aId = sId.split('-');
        sKogda = aId[1];

        var dDate = new Date();
        year = dDate.getFullYear();
        month = dDate.getMonth();
        day = dDate.getDate();

        switch (sKogda) {
            case 'zavtra':
                day++;
                break;
            case 'poslezavtra':
                day++;
                day++;
                break;
        }

        sDate = year + '.' + ('0' + (month + 1)).slice(-2) + '.' + ('0' + day).slice(-2);

        $.post(
            "/post/zafiksirovat-dz.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                sdate: sDate,
            }
        );
    });

    $("#voprosy-v-otchet").click(function(e) {

        sUchenik=$('#uchenik').val();
        sPredmet=$('#predmet').val();

        $.post(
            "/post/voprosy-v-otchet.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
            }
        );
    });

    $(".otvetil").click(function(e) {

        sUchenik=$('#uchenik').val();
        sPredmet=$('#predmet').val();
        iVoprosNumber=$(this).attr("id").substring(7);

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
                predmet: sPredmet,
                ivoprosnumber: iVoprosNumber,
                iaktualno: iAktualen,
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

    // $("#import-zadach-ucheniku-urok").click(function(e){
    //
    //     // c.c('urok');
    //
    //     sUchenik = $('#uchenik').val();
    //     sPredmet = $('#predmet').val();
    //     iNomerZadaniya = $('#zadanie').val();
    //
    //     //сделать запрос на добавление
    //     $.post(
    //         "/post/import-zadach-ucheniku-urok.php",
    //         {
    //             suchenik: sUchenik,
    //             spredmet: sPredmet,
    //             izadanie: iNomerZadaniya,
    //         },
    //         function(response){
    //             location.reload();
    //         }
    //     );
    //     //-сделать запрос на добавление
    // });
    //
    // $("#import-zadach-ucheniku-dz").click(function(e){
    //
    //     c.c('dz');
    //
    //     sUchenik = $('#uchenik').val();
    //     sPredmet = $('#predmet').val();
    //     iNomerZadaniya = $('#zadanie').val();
    //
    //     //сделать запрос на добавление
    //     $.post(
    //         "/post/import-zadach-ucheniku-dz.php",
    //         {
    //             suchenik: sUchenik,
    //             spredmet: sPredmet,
    //             izadanie: iNomerZadaniya,
    //         },
    //         function(response){
    //             location.reload();
    //         }
    //     );
    //     //-сделать запрос на добавление
    // });

    $("#import-zadach-ucheniku").click(function(e){

        sUchenik = $('#uchenik').val();
        sPredmet = $('#predmet').val();
        iNomerZadaniya = $('#zadanie').val();
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

    $(".vse-aktualno").click(function(e){

        sUchenik = $('#uchenik').val();
        sPredmet = $('#predmet').val();
        switch($(this).attr("id").substring(17)) {
            case 'vurok':
                iAim=1;
                break;
            case 'vvydannomdz':
                iAim=2;
                break;
            case 'vnovomdz':
                iAim=3;
                break;
            case 'vse':
                iAim=5;
                break;
        }
        iZadanie = $('#zadanie').val();
        iAktualno = $(this).val();

        $.post(
            "/post/vse-aktualno.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                iaim: iAim,
                izadanie: iZadanie,
                iaktualno: iAktualno,
            },
            function(response){
                location.reload();
            }
        );
    });

    $(".nereshennye-radio-v-urok-uchenika").click(function(e){

        sUchenik = $('#uchenik').val();
        sPredmet = $('#predmet').val();
        // iZadanie = $('#zadanie').val();
        iUrok = $(this).val();

        $.post(
            "/post/nereshennye-v-urok-uchenika.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                // izadanie: iZadanie,
                surok: iUrok,
            },
            function(response){
                location.reload();
            }
        );
    });

    $(".vse-radio-v-urok-uchenika").click(function(e){

        sUchenik = $('#uchenik').val();
        sPredmet = $('#predmet').val();
        iUrok = $(this).val();
        iZadanie = $('#zadanie').val();

        $.post(
            "/post/vse-v-urok-uchenika.php",
            {
                suchenik: sUchenik,
                spredmet: sPredmet,
                surok: iUrok,
                izadanie: iZadanie,
            },
            function(response){
                location.reload();
            }
        );
    });


    $(".radio-v-urok-uchenika").click(function(e){

        // c.c('test');

        sUchenik = $('#uchenik').val();
        sPredmet = $('#predmet').val();
        iZadanie = $('#zadanie').val();
        iTaskNumber = $(this).attr("id").substring(10);

        // if($(this).attr('id').indexOf("none")>0){
        //     $(this).parent().css({'color': 'black'});
        //     iVUrok=0;
        // }
        // if($(this).attr('id').indexOf("urok")>0){
        //     $(this).parent().css({'color': 'blue'});
        //     iVUrok=1;
        // }


        // c.c($('#result'+$(this).attr("id").substring(10)).html());
        // c.c($('#result'+$(this).attr("id").substring(10)).html()!=undefined);

        // reshal=0;
        // if($('#reshal-'+$(this).attr("id").substring(10)).html()!=undefined)
        // reshal=1*$('#reshal-'+$(this).attr("id").substring(10)).val();
        reshal=$('#reshal-'+$(this).attr("id").substring(10)).val();

        // c.c(reshal);

        // c.c('#reshal-'+$(this).attr("id").substring(10));
        // c.c($('#reshal-'+$(this).attr("id").substring(10)).val());

        // c.c(reshal);

        if($(this).attr('id').indexOf("none")>0){
            if(reshal>0)
                $(this).parent().css({'color': 'Gray'});
            else
                $(this).parent().css({'color': 'Black'});
            iVUrok=0;
            $(this).parent().children('.razaktualizirovat').hide();
            // c.c($(this).parent().css('color'));
        }
        if($(this).attr('id').indexOf("urok")>0){
            if(reshal>0)
                $(this).parent().css({'color': 'RoyalBlue'});
            else
                $(this).parent().css({'color': 'Blue'});
            iVUrok=1;
            if(reshal!=2)
                $(this).parent().children('.razaktualizirovat').show();
            // c.c($(this).parent().css('color'));
        }
        if($(this).attr('id').indexOf("dzvy")>0){
            if(reshal>0)
                $(this).parent().css({'color': 'IndianRed'});
            else
                $(this).parent().css({'color': 'Red'});
            iVUrok=2;
            $(this).parent().children('.razaktualizirovat').hide();
            // c.c($(this).parent().css('color'));
        }
        if($(this).attr('id').indexOf("dzdz")>0){
            if(reshal>0)
                $(this).parent().css({'color': 'MediumSeaGreen'});
            else
                $(this).parent().css({'color': 'Green'});
            iVUrok=3;
            $(this).parent().children('.razaktualizirovat').hide();
            // c.c($(this).parent().css('color'));
        }

        //сделать запрос на обновление поля urok таблицы zadacha
        $.post(
            "/post/v-urok-uchenika.php",
            {
                idzadachi: iTaskNumber,
                ivurok: iVUrok,
                suchenik: sUchenik,
            },function(response) {
                $.post(
                    "/post/top-block.php",
                    {
                        suchenik: sUchenik,
                        spredmet: sPredmet,
                        izadanie: iZadanie,
                    },
                    function(response){
                        jTopBlock = JSON.parse(response);
                        // c.c(jTopBlock);
                        $('#TopBlockReshenoVNigde').html(jTopBlock.TopBlockReshenoVNigde);
                        $('#TopBlockReshenoVUroke').html(jTopBlock.TopBlockReshenoVUroke);
                        $('#TopBlockReshenoVVydannomDz').html(jTopBlock.TopBlockReshenoVVydannomDz);
                        $('#TopBlockVNigde').html(jTopBlock.TopBlockVNigde);
                        $('#TopBlockVUroke').html(jTopBlock.TopBlockVUroke);
                        $('#TopBlockVVydannomDz').html(jTopBlock.TopBlockVVydannomDz);
                    }
                );
            }
        );
    });
});