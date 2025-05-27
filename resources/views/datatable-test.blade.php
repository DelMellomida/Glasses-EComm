<div>
    <!-- Simplicity is the essence of happiness. - Cedric Bledsoe -->
</div>
<!DOCTYPE html>
<html>
<head>
    <title>DataTable Test</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
</head>
<body>
    <h1>DataTable Export Test</h1>
    
    <table id="test_table" class="display">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td>Edit</td>
            </tr>
            <tr>
                <td>Jane Smith</td>
                <td>jane@example.com</td>
                <td>Edit</td>
            </tr>
            <tr>
                <td>Bob Johnson</td>
                <td>bob@example.com</td>
                <td>Edit</td>
            </tr>
        </tbody>
    </table>

    <!-- Load scripts in exact order -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>

    <script>
    $(document).ready(function() {
        console.log('=== DataTable Test Debug ===');
        console.log('jQuery version:', $.fn.jquery);
        console.log('DataTables loaded:', typeof $.fn.DataTable);
        console.log('Buttons loaded:', typeof $.fn.DataTable.Buttons);
        console.log('csvHtml5 available:', typeof $.fn.DataTable.ext.buttons.csvHtml5);
        console.log('excelHtml5 available:', typeof $.fn.DataTable.ext.buttons.excelHtml5);
        
        $('#test_table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csvHtml5',
                'excelHtml5',
                {
                    extend: 'collection',
                    text: 'Export All',
                    buttons: [
                        'csvHtml5',
                        'excelHtml5'
                    ]
                }
            ]
        });
    });
    </script>
</body>
</html>