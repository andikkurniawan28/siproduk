@extends('master')

@section('per_bag_active')
    {{ 'active' }}
@endsection

@section('content')
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">
                Timbangan per Bag {{ $context }}
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-dark table-hover table-striped data-table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Timestamp</th>
                            <th>Setting<sub>(kg)</sub></th>
                            <th>Tertimbang<sub>(kg)</sub></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
        </div>
    </div>
</div>
@endsection

@section("add_script")
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            order: [[0, 'desc']],
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('timbangan_per_bag', $context) }}",
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'created_at', name: 'created_at'},
                {data: 'setting', name: 'setting'},
                {data: 'result', name: 'result'},
            ],
            dom: 'lBfrtip', // Tambahkan "l" untuk menampilkan dropdown untuk jumlah baris
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Data Export - {{ strtoupper($context) }}'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Data Export - {{ strtoupper($context) }}'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Data Export - {{ strtoupper($context) }}'
                },
                {
                    extend: 'print',
                    title: 'Data Export - {{ strtoupper($context) }}'
                }
            ],
            lengthMenu: [ // Tambahkan opsi untuk jumlah baris yang ditampilkan
                [10, 25, 50, 100, -1], // Nilai untuk opsi
                [10, 25, 50, 100, "All"] // Label yang ditampilkan
            ],
            pageLength: 10 // Default jumlah baris yang ditampilkan
        });
    });
</script>


@endsection
