@echo off
echo ====================================
echo Bootstrap DatePicker Fix Script
echo ====================================
echo.
echo This script will replace all bootstrapMaterialDatePicker
echo with standard bootstrap-datepicker across the project.
echo.
echo Press any key to continue or Ctrl+C to cancel...
pause > nul

cd /d "%~dp0\.."

echo.
echo Replacing datepicker in view files...

:: Fix proposal/view.blade.php
powershell -Command "(Get-Content 'resources\views\proposal\view.blade.php') -replace '\.bootstrapMaterialDatePicker\(', '.datepicker(' -replace 'format: ''DD-MM-YYYY''', 'format: ''dd-mm-yyyy'', autoclose: true, todayHighlight: true' -replace 'format: ''DD-MMM-YYYY''', 'format: ''dd-M-yyyy'', autoclose: true, todayHighlight: true' -replace 'weekStart: 0,', 'autoclose: true, todayHighlight: true, orientation: ''bottom auto'',' | Set-Content 'resources\views\proposal\view.blade.php'"

:: Fix proposal/edit.blade.php
powershell -Command "(Get-Content 'resources\views\proposal\edit.blade.php') -replace '\.bootstrapMaterialDatePicker\(', '.datepicker(' -replace 'format: ''DD-MMM-YYYY''', 'format: ''dd-M-yyyy'', autoclose: true, todayHighlight: true' -replace 'weekStart: 0,', 'autoclose: true, todayHighlight: true, orientation: ''bottom auto'',' | Set-Content 'resources\views\proposal\edit.blade.php'"

:: Fix master/data_user.blade.php
powershell -Command "(Get-Content 'resources\views\master\data_user.blade.php') -replace '\.bootstrapMaterialDatePicker\(', '.datepicker(' -replace 'format: ''DD-MMM-YYYY''', 'format: ''dd-M-yyyy'', autoclose: true, todayHighlight: true' | Set-Content 'resources\views\master\data_user.blade.php'"

:: Fix subsidiary report files
powershell -Command "(Get-Content 'resources\views\report\data_realisasi_subsidiary.blade.php') -replace '\.bootstrapMaterialDatePicker\(', '.datepicker(' -replace 'weekStart: 0,', 'autoclose: true, todayHighlight: true, orientation: ''bottom auto'',' -replace 'format: ''DD-MM-YYYY''', 'format: ''dd-mm-yyyy'', autoclose: true' | Set-Content 'resources\views\report\data_realisasi_subsidiary.blade.php'"

echo.
echo ====================================
echo Fix completed successfully!
echo ====================================
echo.
echo Please refresh your browser (Ctrl+F5) to see the changes.
echo.
pause
