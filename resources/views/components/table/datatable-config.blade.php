@props([
    'tableId' => 'dataTable',
    'hasExport' => true,
    'hasAction' => false,
    'columns' => []
])

<script>
    $(document).ready(function() {
        // Ensure column defs are applied first, before any other initialization
        var columnDefsConfig = [];

        @if(!empty($columns))
        @foreach($columns as $index => $col)
            @if(is_array($col))
        columnDefsConfig.push({ width: @json($col[0]), targets: @json($index), className: @json($col[1]) });
            @else
        columnDefsConfig.push({ width: @json($col), targets: @json($index) });
            @endif
        @endforeach
        @endif

        $('#{{ $tableId }}').DataTable({
            stateSave: true,
            columnDefs: columnDefsConfig,
            @if($hasExport)
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn btn-primary btn-sm',
                    text: '<i class="fas fa-copy"></i> Copy',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn btn-success btn-sm',
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn btn-success btn-sm',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-danger btn-sm',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn btn-info btn-sm',
                    text: '<i class="fas fa-print"></i> Print',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                }
            ]
            @endif
        });
    });
</script>

<style>
    /* DataTable Column Styling - Higher Specificity */
    #{{ $tableId }} td.text-wrap,
    #{{ $tableId }} th.text-wrap {
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
    }

    #{{ $tableId }} td.text-nowrap,
    #{{ $tableId }} th.text-nowrap {
        white-space: nowrap !important;
    }

    #{{ $tableId }} td.text-center,
    #{{ $tableId }} th.text-center {
        text-align: center !important;
    }

    #{{ $tableId }} td.text-right,
    #{{ $tableId }} th.text-right {
        text-align: right !important;
    }

    #{{ $tableId }} td.text-left,
    #{{ $tableId }} th.text-left {
        text-align: left !important;
    }

    /* Ensure columns display properly with width constraints */
    #{{ $tableId }} td,
    #{{ $tableId }} th {
        vertical-align: middle;
    }
</style>
