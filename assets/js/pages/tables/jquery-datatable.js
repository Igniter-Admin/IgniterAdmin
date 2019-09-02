$(function () {
    $('.js-basic-example').DataTable({
        responsive: true,
        aoColumnDefs: [
          {
             bSortable: false,
             aTargets: [ -1 ]
          }
        ]
    });

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});