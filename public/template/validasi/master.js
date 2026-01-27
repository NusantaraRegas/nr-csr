$(document).ready(function() {
    $('#myTable').DataTable();
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
        // Order by the grouping
        $('#example tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });
    });
});

function hanyaAngka(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

jQuery(document).ready(function() {
    // For select 2
    $(".select2").select2();
    $('.selectpicker').selectpicker();
});

$(document).on('click', '.user-edit', function (e) {
    document.getElementById("iduser").value = $(this).attr('user-id');
    document.getElementById("username").value = $(this).attr('user-username');
    document.getElementById("email").value = $(this).attr('user-email');
    document.getElementById("nama").value = $(this).attr('user-nama');
    document.getElementById("jabatan").value = $(this).attr('user-jabatan');
    document.getElementById("area").value = $(this).attr('user-area');
    document.getElementById("role").value = $(this).attr('user-role');
    document.getElementById("status").value = $(this).attr('user-status');
});

$(document).on('click', '.perusahaan-edit', function (e) {
    document.getElementById("idperusahaan").value = $(this).attr('perusahaan-id');
    document.getElementById("nama_edit").value = $(this).attr('perusahaan-nama');
});

$(document).on('click', '.role-edit', function (e) {
    document.getElementById("idrole").value = $(this).attr('role-id');
    document.getElementById("role_edit").value = $(this).attr('role-role');
    document.getElementById("nama_edit").value = $(this).attr('role-nama');
});

$(document).on('click', '.approve-kadep', function (e) {
    document.getElementById("noAgenda").value = $(this).attr('no-agenda');
});

$(document).on('click', '.approve-kadiv', function (e) {
    document.getElementById("noAgenda2").value = $(this).attr('no-agenda');
});

$(document).on('click', '.approve-evaluator', function (e) {
    document.getElementById("noAgenda3").value = $(this).attr('no-agenda');
});

$(document).on('click', '.lampiran', function (e) {
    document.getElementById("noAgenda").value = $(this).attr('no-agenda');
});

$(document).on('click', '.approve-kadiv2', function (e) {
    document.getElementById("noAgenda2").value = $(this).attr('no-agenda');
    document.getElementById("nilaiBantuan2").value = $(this).attr('bantuan');
    document.getElementById("termin2").value = $(this).attr('termin');
});

$(document).on('click', '.stakeholder-edit', function (e) {
    document.getElementById("idstakeholder").value = $(this).attr('stakeholder-id');
    document.getElementById("nama_edit").value = $(this).attr('stakeholder-nama');
});

$(document).on('click', '.satker-edit', function (e) {
    document.getElementById("idsatker").value = $(this).attr('satker-id');
    document.getElementById("nama_edit").value = $(this).attr('satker-nama');
});