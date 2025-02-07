@extends('master')

@section('per_tanggal_active')
    {{ 'active' }}
@endsection

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h5 class="m-0 font-weight-bold text-primary">
                Laporan per Tanggal
            </h5>
        </div>
        <div class="card-body">
            <form id="filterForm" method="GET" action="">
                <div class="form-row">
                    <div class="col-md-5 mb-3">
                        <label for="from_date">Dari</label>
                        <input type="date" class="form-control" id="from_date" name="from_date" required>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="to_date">Sampai dengan</label>
                        <input type="date" class="form-control" id="to_date" name="to_date" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control">Cari</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-4">
                <table class="table table-bordered text-dark table-hover table-striped data-table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Line</th>
                            <th>Timestamp</th>
                            <th>Tertimbang<sub>(kg)</sub></th>
                        </tr>
                    </thead>
                    <tbody id="data-body">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
</div>

@section('add_script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                let fromDate = $('#from_date').val();
                let toDate = $('#to_date').val();

                function formatDate(dateString) {
                    const date = new Date(dateString);
                    date.setHours(date.getUTCHours() + 0);

                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');
                    const seconds = String(date.getSeconds()).padStart(2, '0');

                    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                }

                if (fromDate && toDate) {
                    $.ajax({
                        url: "/laporan_per_tanggal/" + fromDate + "/" + toDate,
                        method: 'GET',
                        success: function(response) {
                            $('#data-body').empty();

                            if (response.length === 0) {
                                alert("Tidak ada data untuk tanggal yang dipilih!");
                            } else {
                                response.forEach(function(item) {
                                    $('#data-body').append(`
                                        <tr>
                                            <td>${item.line}</td>
                                            <td>${formatDate(item.created_at)}</td>
                                            <td>${item.result}</td>
                                        </tr>
                                    `);
                                });

                                $('#dataTable').DataTable({
                                    dom: 'Bfrtip',
                                    buttons: [
                                        'excelHtml5',
                                        'pdfHtml5'
                                    ],
                                    pageLength: -1,
                                    lengthMenu: [[-1], ["All"]]
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Terjadi kesalahan: " + error);
                        }
                    });
                } else {
                    alert("Mohon pilih tanggal dari dan sampai dengan!");
                }
            });
        });
    </script>

@endsection

@endsection
