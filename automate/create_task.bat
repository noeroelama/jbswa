
@echo off
set taskname="Wanesia JIBAS"
set taskrun="C:\YIM\JIBAS\xampp\htdocs\jibas\jbswa\automate\send.bat"

:: Create the task to run every minute with highest privileges and system account
schtasks /create /tn %taskname% /tr %taskrun% /sc minute /mo 1 /ru "SYSTEM" /RL HIGHEST /F

echo Task "%taskname%" berhasil dibuat untuk dijalankan tiap menit.
pause
