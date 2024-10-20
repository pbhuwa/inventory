@echo off
setlocal EnableExtensions EnableDelayedExpansion

set "hostspath=%SystemRoot%\System32\drivers\etc\hosts"

rem Initialize the array of our hosts to toggle
for %%a in (
    "192.168.0.2 inventory.nphl.gov.np"
) do (
    set /a numhosts+=1
    set "host!numhosts!=%%~a"
)

>"%hostspath%.new" (
    rem Parse the hosts file, skipping the already present hosts from our list.
    rem Blank lines are preserved using findstr trick.
    for /f "delims=: tokens=1*" %%a in ('%SystemRoot%\System32\findstr.exe /n /r /c:".*" "%hostspath%"') do (
        set skipline=
        for /L %%h in (1,1,!numhosts!) do (
            if "%%b"=="!host%%h!" (
                set skipline=true
                set found%%h=true
                echo - %%b 1>&2
            )
        )
        if not "!skipline!"=="true" echo.%%b
    )
    for /L %%h in (1,1,!numhosts!) do (
        if not "!found%%h!"=="true" echo + !host%%h! 1>&2 & echo !host%%h!
    )
)
move /y "%hostspath%" "%hostspath%.bak" >nul || echo Can't backup %hostspath%
move /y "%hostspath%.new" "%hostspath%" >nul || echo Can't update %hostspath%
endlocal
pause