/*
 Template Name: Lunoz - Admin & Dashboard Template
 Author: Myra Studio
 File: Datatables
*/


$(document).ready(function() {
    // Get current locale from HTML lang attribute or default to 'fr'
    var locale = $('html').attr('lang') || 'fr';
    var isRTL = locale === 'ar';
    
    // DataTables language configuration
    var dtLanguage = {};
    if (locale === 'ar') {
        dtLanguage = {
            "sEmptyTable": "لا توجد بيانات متاحة في الجدول",
            "sLoadingRecords": "جارٍ التحميل...",
            "sProcessing": "جارٍ المعالجة...",
            "sLengthMenu": "أظهر _MENU_ مدخلات",
            "sZeroRecords": "لم يعثر على أية سجلات",
            "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
            "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sSearch": "ابحث:",
            "oPaginate": {
                "sFirst": "الأول",
                "sPrevious": "السابق",
                "sNext": "التالي",
                "sLast": "الأخير"
            }
        };
    } else if (locale === 'en') {
        dtLanguage = {
            "sEmptyTable": "No data available in table",
            "sLoadingRecords": "Loading...",
            "sProcessing": "Processing...",
            "sLengthMenu": "Show _MENU_ entries",
            "sZeroRecords": "No matching records found",
            "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
            "sInfoEmpty": "Showing 0 to 0 of 0 entries",
            "sInfoFiltered": "(filtered from _MAX_ total entries)",
            "sSearch": "Search:",
            "oPaginate": {
                "sFirst": "First",
                "sPrevious": "Previous",
                "sNext": "Next",
                "sLast": "Last"
            }
        };
    } else {
        // French (default)
        dtLanguage = {
            "sEmptyTable": "Aucune donnée disponible dans le tableau",
            "sLoadingRecords": "Chargement...",
            "sProcessing": "Traitement en cours...",
            "sLengthMenu": "Afficher _MENU_ entrées",
            "sZeroRecords": "Aucun enregistrement correspondant trouvé",
            "sInfo": "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
            "sInfoEmpty": "Affichage de l'élément 0 à 0 sur 0 élément",
            "sInfoFiltered": "(filtré de _MAX_ éléments au total)",
            "sSearch": "Rechercher :",
            "oPaginate": {
                "sFirst": "Premier",
                "sPrevious": "Précédent",
                "sNext": "Suivant",
                "sLast": "Dernier"
            }
        };
    }
    
    // Function to apply RTL styles
    function applyRTLStyles(tableId) {
        if (!isRTL) return;
        var wrapper = $(tableId + '_wrapper');
        var filter = $(tableId + '_filter');
        var length = $(tableId + '_length');
        var info = $(tableId + '_info');
        
        wrapper.addClass('rtl-datatable');
        
        if (filter.length) {
            filter.addClass('text-right');
            filter.find('label').css({
                'text-align': 'right',
                'direction': 'rtl',
                'float': 'right'
            });
            filter.find('input').css({
                'margin-right': '0.5em',
                'margin-left': '0',
                'direction': 'rtl',
                'text-align': 'right'
            });
        }
        
        if (length.length) {
            length.addClass('text-left');
            length.find('label').css({
                'text-align': 'left',
                'direction': 'rtl'
            });
            length.find('select').css('direction', 'rtl');
        }
        
        if (info.length) {
            info.css({
                'direction': 'rtl',
                'text-align': 'right'
            });
        }
    }

    // Default Datatable
    $('#basic-datatable').DataTable({
        "language": dtLanguage,
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            applyRTLStyles('#basic-datatable');
        }
    });
    
    if (isRTL) {
        setTimeout(function() { applyRTLStyles('#basic-datatable'); }, 100);
    }
    
    $('#basic-datatable2').DataTable({
        "language": dtLanguage,
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            applyRTLStyles('#basic-datatable2');
        }
    });
    
    if (isRTL) {
        setTimeout(function() { applyRTLStyles('#basic-datatable2'); }, 100);
    }

    $('.dtt').DataTable({
        "language": dtLanguage,
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            if (isRTL) {
                $('.dtt').each(function() {
                    var tableId = '#' + $(this).attr('id');
                    if (tableId !== '#') {
                        applyRTLStyles(tableId);
                    }
                });
            }
        }
    });
    
    if (isRTL) {
        setTimeout(function() {
            $('.dtt').each(function() {
                var tableId = '#' + $(this).attr('id');
                if (tableId !== '#') {
                    applyRTLStyles(tableId);
                }
            });
        }, 100);
    }

    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: ['copy', 'print', 'pdf'],
        "language": dtLanguage,
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            applyRTLStyles('#datatable-buttons');
        }
    });
    
    if (isRTL) {
        setTimeout(function() { applyRTLStyles('#datatable-buttons'); }, 100);
    }

    var table2 = $('#datatable-buttons2').DataTable({
        lengthChange: false,
        buttons: ['copy', 'print', 'pdf'],
        "language": dtLanguage,
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            applyRTLStyles('#datatable-buttons2');
        }
    });
    
    if (isRTL) {
        setTimeout(function() { applyRTLStyles('#datatable-buttons2'); }, 100);
    }

    // Multi Selection Datatable
    $('#selection-datatable').DataTable({
        select: {
            style: 'multi'
        },
        "language": dtLanguage,
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            applyRTLStyles('#selection-datatable');
        }
    });
    
    if (isRTL) {
        setTimeout(function() { applyRTLStyles('#selection-datatable'); }, 100);
    }

    // Key Datatable
    $('#key-datatable').DataTable({
        keys: true,
        "language": dtLanguage,
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            applyRTLStyles('#key-datatable');
        }
    });
    
    if (isRTL) {
        setTimeout(function() { applyRTLStyles('#key-datatable'); }, 100);
    }

    table.buttons().container()
            .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

    table2.buttons().container()
            .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

    // Complex headers with column visibility Datatable
    $('#complex-header-datatable').DataTable({
        "language": dtLanguage,
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            applyRTLStyles('#complex-header-datatable');
        },
        "columnDefs": [ {
            "visible": false,
            "targets": -1
        } ]
    });
    
    if (isRTL) {
        setTimeout(function() { applyRTLStyles('#complex-header-datatable'); }, 100);
    }

    // State Datatable
    $('#state-saving-datatable').DataTable({
        stateSave: true,
        "language": dtLanguage,
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            applyRTLStyles('#state-saving-datatable');
        }
    });
    
    if (isRTL) {
        setTimeout(function() { applyRTLStyles('#state-saving-datatable'); }, 100);
    }

});
