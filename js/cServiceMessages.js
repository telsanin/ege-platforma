class cServiceMessages {
// Класс cServiceMessages

  sText = '';
  sButton1Caption = '';

  sCancelButtonCaption = 'Отменить';
  iInitialCancelTime = 10;
  iCurrentCancelTime = 0;
  iCancelIntervalId;
  iCancelTimerId;
  sResultText = '';

  sSqlQuery = '';
  sCancelSqlQuery = '';


  // Конструктор
  constructor() {

    // установка визульного макета объекта
    // (div-блока '#oServiceMessages')
    this.template = " \
      <button id=\"ServiceMessagesButton1\" style=\"text-decoration: underline; border: none; outline: none; background: none;  cursor: pointer;\" ></button> \
      <span id=\"ServiceMessagesText\"></span> \
      <span id=\"ServiceMessagesCountdown\" style=\"display: none;\"> \
        <span id=\"ServiceMessagesResultText\" style=\"display: none;\"></span> \
        <button id=\"ServiceMessagesCancelButton\" style=\"display: none; text-decoration: underline; border: none; outline: none; background: none;  cursor: pointer; display: none;\" >Отменить</button> \
        <span id=\"ServiceMessagesCountdownItem\"></span> \
      </span> \
      <button id=\"ServiceMessagesCloseButton\" style=\"text-decoration: underline; border: none; outline: none; background: none;  cursor: pointer;\" >X</button> \
    ";

    // первоначальная инициализация свойств объекта
    $('#oServiceMessages').html(this.template);
    $('#oServiceMessages #ServiceMessagesText').html(this.sText);
    $('#oServiceMessages #ServiceMessagesButton1Caption').html(this.sButton1Caption);
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCancelButton').html(this.sCancelButtonCaption);
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesResultText').html(this.sResultText);


    // обработчики событий на элементах div-блока '#oServiceMessages'

    // обработчик-по-умолчанию события Click кнопки Button1
    $('#oServiceMessages #ServiceMessagesButton1').click(function () {
      fExecuteInsertUpdateDeleteSqlQuerySqlQuery(oServiceMessages.sSqlQuery, function (sResponse) {
        // c.c(sResponse);
        oServiceMessages.countdownFadeInAndStart();
        if (sResponse === 'success') {
          oServiceMessages.cancelButtonFadeIn();
        } else {
          oServiceMessages.resultText('Не у далось выполнить :(');
          oServiceMessages.resultTextFadeIn();
        }
      });
    });

    // обработчик-по-умолчанию события Click кнопки Cancel
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCancelButton').click(function (obj) {
      fExecuteInsertUpdateDeleteSqlQuerySqlQuery(oServiceMessages.sCancelSqlQuery, function (sResponse) {
        // c.c(sResponse);
        oServiceMessages.countdownStop();
        if (sResponse === 'fail') {
          $('#oServiceMessages #ServiceMessagesCountdown').fadeOut(function(){
            //oServiceMessages.cancelButtonFadeOut();
            $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCancelButton').hide();
            oServiceMessages.resultText('Не удалось отменить :(');
            oServiceMessages.countdownFadeIn();
            oServiceMessages.countdownStart();
          });
        } else {
          oServiceMessages.fadeOut();
        }
      });
    });

    // обработчик события Click кнопки CloseButton
    $('#oServiceMessages #ServiceMessagesCloseButton').click(function (e) {
      oServiceMessages.fadeOut();
    });

  }


  // Методы

  fadeIn() {
    $('#oServiceMessages').fadeIn();
  }


  // getter-setter текста сообщения
  text(sText) {
    // вызов без параметра, значит режим геттера, возвращаем свойство
    if (!arguments.length)
      return this.sText;
    // иначе режим сеттера
    this.sText = sText;
    $('#oServiceMessages #ServiceMessagesText').html(this.sText);
  }


  // getter-setter заголовка кнопки Button1
  button1Caption(sCaption) {
    this.sButton1Caption = sCaption;
    $('#oServiceMessages #ServiceMessagesButton1').html(this.sButton1Caption);
  }

  // setter обработчика события Button1.click
  serviceMessagesButton1OnClick(fFunc) {
    $('#oServiceMessages #ServiceMessagesButton1').off('click');
    $('#oServiceMessages #ServiceMessagesButton1').click(fFunc);
  }

  // setter countcownItem
  countdownItem(iCoundowm) {
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCountdownItem').html(iCoundowm);
  }



  countdownStart(sTypeOfCountdown) {

    this.resultTextShow();
    this.countdownItem(this.iInitialCancelTime);
    this.countdownItemShow();
    this.countdownFadeIn();

    this.iCurrentCancelTime = this.iInitialCancelTime;
    this.iCancelIntervalId = setInterval(function () {
      oServiceMessages.decrementCountdown();
    }, 1000);

    this.iCancelTimerId = setTimeout(function () {
        clearInterval(oServiceMessages.iCancelIntervalId);
        if (sTypeOfCountdown != 'cCountdownOnly') {
          $('#oServiceMessages').fadeOut(function () {
            //иначе, пока постепенно гасится #oServiceMessages, видно, как исчезают внутренные элементы
            oServiceMessages.countdownFadeOut();
            oServiceMessages.cancelButtonHide();
            oServiceMessages.resultTextHide();
            oServiceMessages.ResultText('');
          });
        } else {
          $('#oServiceMessages #ServiceMessagesCountdown').fadeOut(function () {
            //иначе, пока постепенно гасится #oServiceMessages, видно, как исчезают внутренные элементы
            oServiceMessages.cancelButtonHide();
          });
        }
      },
      (this.iInitialCancelTime - 1) * 1000
    );

  }

  setInitialCountdown() {
    this.iCurrentCancelTime = this.iInitialCancelTime;
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCountdownItem').html(this.iCurrentCancelTime);
  }

  decrementCountdown() {
    this.iCurrentCancelTime--;
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCountdownItem').html(this.iCurrentCancelTime);
  }


  countdownFadeIn() {
    $('#oServiceMessages #ServiceMessagesCountdown').fadeIn();
  }


  countdownItemFadeIn() {
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCountdownItem').fadeIn();
  }
  countdownItemShow() {
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCountdownItem').show();
  }


  cancelButtonFadeIn() {
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCancelButton').fadeIn();
  }
  cancelButtonShow() {
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCancelButton').show();
  }
  // setter обработчика события Cancel.click
  serviceMessagesCancelOnClick(fFunc) {
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCancelButton').off('click');
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCancelButton').click(fFunc);
  }
  cancelButtonFadeOut() {
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCancelButton').fadeOut();
  }
  cancelButtonHide() {
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCancelButton').hide();
  }


  resultTextFadeIn() {
    // $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesResultText').fadeIn();
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesResultText').fadeIn();
  }
  resultTextShow() {
    // $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesResultText').fadeIn();
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesResultText').show();
  }
  // setter текста результата операции
  resultText(sResultText) {
    this.sResultText = sResultText;
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesResultText').html(this.sResultText);
  }
  resultTextFadeOut() {
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesResultText').fadeOut();
  }
  resultTextHide() {
    $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesResultText').hide();
  }


  countdownStop() {
    clearInterval(this.iCancelIntervalId);
    clearTimeout(this.iCancelTimerId);
  }

  countdownFadeOut(sTypeOfCountdown) {
    if (sTypeOfCountdown != 'cCountdownOnly') {
      $('#oServiceMessages').fadeOut(function () {
        //иначе, пока постепенно гасится #oServiceMessages, видно, как исчезают внутренные элементы
        $('#oServiceMessages #ServiceMessagesCountdown').hide();
        $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCancelButton').hide();
        $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesResultText').hide();
        $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesResultText').html('');
      });
    } else {
      $('#oServiceMessages #ServiceMessagesCountdown').fadeOut(function () {
        //иначе, пока постепенно гасится #oServiceMessages, видно, как исчезают внутренные элементы
        $('#oServiceMessages #ServiceMessagesCountdown #ServiceMessagesCancelButton').hide();
      });
    }
  }


  fadeOut() {
    $('#oServiceMessages').fadeOut();
    oServiceMessages.countdownStop();
  }


};


/*
let oServiceMessages = new cServiceMessages;
// oServiceMessages.text('test');

sUchenikName = 'nikita';

/!*
 oServiceMessages.button1Caption('Добавить ученика ' + sUchenikName);
 oServiceMessages.sSqlQuery = "INSERT INTO `uchenik` (`uchenik`, `komment`) VALUES('" + sUchenikName + "', 'hello world!');";
 oServiceMessages.sCancelSqlQuery = "DELETE FROM `uchenik` WHERE `uchenik` = '" + sUchenikName + "';";
 *!/


oServiceMessages.button1Caption('Найти ученика ' + sUchenikName);
oServiceMessages.sSqlQuery = "SELECT MAX(`date`) FROM `otchet` WHERE `otchet`.`uchenik` = '" + sUchenikName + "';";

// изменим обработчик Button1Click
oServiceMessages.serviceMessagesButton1OnClick(function () {
  fExecuteSelectSqlQuery(oServiceMessages.sSqlQuery, function (sResponse) {
    if (sResponse !== '') {
      if (fJsDate(sResponse) < fTodayJsDate()) {
        //добавим отчет по ученику на сегодня
        //
        //
        oServiceMessages.resultText('Добавил отчет по ' + sUchenikName + ' за сегодня');
      }
    }
    else {
      oServiceMessages.resultText('Не удалось получить дату последнего отчет по ' + sUchenikName);
    }
    oServiceMessages.resultTextFadeIn();
    oServiceMessages.startCountdown();
  });
});

oServiceMessages.show();
*/


/*
 <a id=\"ServiceMessagesButton1Caption\" style=\"text-decoration: underline;\">Отменить</a>
 */

