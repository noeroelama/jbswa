
@echo off
set taskname="Wanesia JIBAS"
set taskrun="C:\YIM\JIBAS\xampp\htdocs\jibas\jbswa\automate\send.bat"

schtasks /create /tn %taskname% /tr %taskrun% /sc minute /mo 1 /f

echo Task "%taskname%" berhasil dibuat untuk dijalankan tiap menit.
pause
