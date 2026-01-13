@echo off
echo Fixing frontend asset paths...

cd public\template\assets\node_modules

REM Fix jQuery
if exist "jquery\dist\jquery.min.js" (
    if not exist "jquery\jquery-3.2.1.min.js" copy "jquery\dist\jquery.min.js" "jquery\jquery-3.2.1.min.js"
    echo jQuery fixed
)

REM Fix Bootstrap
if exist "bootstrap\dist\js\bootstrap.min.js" (
    if not exist "bootstrap\dist\js\bootstrap.bundle.min.js" copy "bootstrap\dist\js\bootstrap.min.js" "bootstrap\dist\js\bootstrap.bundle.min.js"
    echo Bootstrap fixed
)

REM Fix Popper
if exist "popper.js\dist\umd\popper.min.js" (
    mkdir "..\..\dist\js" 2>nul
    if not exist "..\..\dist\js\popper.min.js" copy "popper.js\dist\umd\popper.min.js" "..\..\dist\js\popper.min.js"
    echo Popper fixed
)

REM Fix Select2
if exist "select2\dist\js\select2.full.min.js" (
    if not exist "select2\select2.full.min.js" copy "select2\dist\js\select2.full.min.js" "select2\select2.full.min.js"
    if not exist "select2\select2.min.css" copy "select2\dist\css\select2.min.css" "select2\select2.min.css"
    echo Select2 fixed
)

REM Fix SweetAlert
if exist "sweetalert\dist\sweetalert.min.js" (
    if not exist "sweetalert\sweetalert.min.js" copy "sweetalert\dist\sweetalert.min.js" "sweetalert\sweetalert.min.js"
    if not exist "sweetalert\sweetalert.css" copy "sweetalert\dist\sweetalert.css" "sweetalert\sweetalert.css"
    echo SweetAlert fixed
)

REM Fix Toastr
if exist "toastr\build\toastr.min.js" (
    if not exist "toastr\toastr.min.js" copy "toastr\build\toastr.min.js" "toastr\toastr.min.js"
    if not exist "toastr\toastr.min.css" copy "toastr\build\toastr.min.css" "toastr\toastr.min.css"
    if not exist "toast-master" mkdir "toast-master"
    if not exist "toast-master\toastr.min.js" copy "toastr\build\toastr.min.js" "toast-master\toastr.min.js"
    if not exist "toast-master\toastr.min.css" copy "toastr\build\toastr.min.css" "toast-master\toastr.min.css"
    echo Toastr fixed
)

REM Fix DataTables
if exist "datatables.net\js\jquery.dataTables.min.js" (
    if not exist "datatables.net\jquery.dataTables.min.js" copy "datatables.net\js\jquery.dataTables.min.js" "datatables.net\jquery.dataTables.min.js"
    echo DataTables fixed
)

REM Fix Sticky-Kit
if exist "sticky-kit\dist\sticky-kit.min.js" (
    if not exist "sticky-kit\sticky-kit.min.js" copy "sticky-kit\dist\sticky-kit.min.js" "sticky-kit\sticky-kit.min.js"
    echo Sticky-Kit fixed
)

REM Fix Bootstrap Datepicker
if exist "bootstrap-datepicker\dist\js\bootstrap-datepicker.min.js" (
    if not exist "bootstrap-datepicker\bootstrap-datepicker.min.js" copy "bootstrap-datepicker\dist\js\bootstrap-datepicker.min.js" "bootstrap-datepicker\bootstrap-datepicker.min.js"
    if not exist "bootstrap-datepicker\bootstrap-datepicker.min.css" copy "bootstrap-datepicker\dist\css\bootstrap-datepicker.min.css" "bootstrap-datepicker\bootstrap-datepicker.min.css"
    echo Bootstrap Datepicker fixed
)

REM Fix Daterangepicker
if exist "daterangepicker\daterangepicker.js" (
    if not exist "bootstrap-daterangepicker" mkdir "bootstrap-daterangepicker"
    if not exist "bootstrap-daterangepicker\daterangepicker.js" copy "daterangepicker\daterangepicker.js" "bootstrap-daterangepicker\daterangepicker.js"
    if not exist "bootstrap-daterangepicker\daterangepicker.css" copy "daterangepicker\daterangepicker.css" "bootstrap-daterangepicker\daterangepicker.css"
    echo Daterangepicker fixed
)

REM Fix Bootstrap Timepicker
if exist "bootstrap-timepicker\js\bootstrap-timepicker.min.js" (
    if not exist "timepicker" mkdir "timepicker"
    if not exist "timepicker\bootstrap-timepicker.min.js" copy "bootstrap-timepicker\js\bootstrap-timepicker.min.js" "timepicker\bootstrap-timepicker.min.js"
    if not exist "timepicker\bootstrap-timepicker.min.css" copy "bootstrap-timepicker\css\bootstrap-timepicker.min.css" "timepicker\bootstrap-timepicker.min.css"
    echo Bootstrap Timepicker fixed
)

REM Fix jQuery Validation
if exist "jquery-validation\dist\jquery.validate.min.js" (
    if not exist "jquery-validation\jquery.validate.min.js" copy "jquery-validation\dist\jquery.validate.min.js" "jquery-validation\jquery.validate.min.js"
    echo jQuery Validation fixed
)

REM Fix Bootstrap Select
if exist "bootstrap-select\dist\js\bootstrap-select.min.js" (
    if not exist "bootstrap-select\bootstrap-select.min.js" copy "bootstrap-select\dist\js\bootstrap-select.min.js" "bootstrap-select\bootstrap-select.min.js"
    echo Bootstrap Select fixed
)

cd ..\..\..\..

echo.
echo Done! All assets have been fixed.
echo Please refresh your browser (Ctrl+F5) to see the changes.
