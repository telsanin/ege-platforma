/**
 * набор функций для работы с датами
 */

fTodayJsDate = function () {

  var dDate = new Date();
  return dDate;

}


fTodayMySqlDate = function () {

  var dDate = new Date();
  return fJsDateToStr(dDate);

}


fJsDate = function (sDate) {

  dDate = new Date(sDate);
  return dDate;

}


fJsDateToStr = function (dDate) {

  day = fExactDigits(dDate.getDate(), 2);
  month = fExactDigits(dDate.getMonth()+1, 2);
  year = fExactDigits(dDate.getFullYear(), 4);

  return year + '.' + month + '.' + day;

}


fExactDigits = function (iNumber, iCount) {

  return ('0'.repeat(iCount) + iNumber).slice(-iCount);

}


// делает из JS даты - JS дату без учета времени
Date.prototype.withoutTime = function () {

  var d = new Date(this);
  d.setHours(0, 0, 0, 0);
  return d;

}


/**
 * набор функций для работы с Sql-зарпосами
 */



fExecuteInsertUpdateDeleteSqlQuerySqlQuery = function (sSqlQuery, fCallBack) {
// Эта функция выполняет INSERT/UPDATE/DELETE Sql-запрос к БД по AJAX, используя InsertUpdateDelete.php
// Примеры запросов:
// sSqlQuery = "INSERT INTO `uchenik` (`uchenik`) VALUES('new1');",
// sSqlQuery = "UPDATE `uchenik` SET `uchenik` = 'new2' WHERE `uchenik` = 'new1';",
// sSqlQuery = "DELETE FROM `uchenik` WHERE `uchenik` = 'new2';",

  $.post(
    "/put/InsertUpdateDelete.php",
    {
      sSqlQuery: sSqlQuery,
    },
    function (sResponse) {
      fCallBack(sResponse);
    }
  );

}


fExecuteSelectSqlQuery = function (sSqlQuery, fCallBack) {
// Эта функция выполняет SELECT Sql-запрос к БД по AJAX, используя Select.php
// Примеры запросов:
// sSqlQuery = "SELECT `uchenik` FROM `uchenik` WHERE `uchenik`.`uchenik` = 'Иванов';",

  $.post(
    "/put/Select.php",
    {
      sSqlQuery: sSqlQuery,
    },
    function (sResponse) {
      fCallBack(sResponse);
    }
  );

};
