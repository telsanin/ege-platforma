function functionCConsole(){
/*
Делает возможной короткую запись вывода отладочной информации
в консоль браузера Google Chrome
*/

	c=console;
	c.c=console.log;
}