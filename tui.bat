@echo off

rem -------------------------------------------------------------
rem  Tui command line bootstrap script for Windows.
rem -------------------------------------------------------------

@setlocal

set TUI_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%TUI_PATH%tui" %*

@endlocal
