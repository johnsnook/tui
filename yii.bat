@echo off

rem -------------------------------------------------------------
rem  Tui command line bootstrap script for Windows.
rem
rem  @author Qiang Xue <qiang.xue@gmail.com>
rem  @link http://www.tuiframework.com/
rem  @copyright Copyright (c) 2008 Tui Software LLC
rem  @license http://www.tuiframework.com/license/
rem -------------------------------------------------------------

@setlocal

set TUI_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%TUI_PATH%tui" %*

@endlocal
