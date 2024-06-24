
@echo off
set taskname="Wanesia JIBAS"

schtasks /delete /tn %taskname% /f

echo Task "%taskname%" berhasil dihapus.
pause
