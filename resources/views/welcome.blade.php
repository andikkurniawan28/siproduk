@extends('master')

@section('dashboad_active')
    {{ 'active' }}
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard - Produksi Gula Hari Ini <sub>({{ date('d-m-Y') }})</sub></h1>
            <a href="{{ route('laporan_per_tanggal.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-calendar fa-sm text-white-50"></i> Laporan per Tanggal</a>
        </div>

        <!-- Content Row -->
        <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <h3 class="font-weight-bold text-primary text-uppercase mb-1">
                                    Global
                                </h3>

                                <!-- Table 1: Data Summary -->
                                <table class="table table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Tertimbang<sub>(Sak)</sub></td>
                                            <td id="global-tersak">---</td>
                                        </tr>
                                        <tr>
                                            <td>Tertimbang<sub>(Ku)</sub></td>
                                            <td id="global-terku">---</td>
                                        </tr>
                                        <tr>
                                            <td>Minimum<sub>(kg)</sub></td>
                                            <td id="global-min">---</td>
                                        </tr>
                                        <tr>
                                            <td>Maksimum<sub>(kg)</sub></td>
                                            <td id="global-max">---</td>
                                        </tr>
                                        <tr>
                                            <td>Rerata<sub>(kg)</sub></td>
                                            <td id="global-avg">---</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @foreach (['A1', 'A2', 'B1', 'B2', 'C1', 'C2'] as $cardTitle)
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <h3 class="font-weight-bold text-primary text-uppercase mb-1">
                                        {{ $cardTitle }}
                                    </h3>

                                    <!-- Table 1: Data Summary -->
                                        <table class="table table-bordered table-sm">
                                            <tbody>
                                                <tr>
                                                    <td>Tertimbang<sub>(Sak)</sub></td>
                                                    <td id="{{ $cardTitle }}-tersak">---</td>
                                                </tr>
                                                <tr>
                                                    <td>Tertimbang<sub>(Ku)</sub></td>
                                                    <td id="{{ $cardTitle }}-terku">---</td>
                                                </tr>
                                                <tr>
                                                    <td>Minimum<sub>(kg)</sub></td>
                                                    <td id="{{ $cardTitle }}-min">---</td>
                                                </tr>
                                                <tr>
                                                    <td>Maksimum<sub>(kg)</sub></td>
                                                    <td id="{{ $cardTitle }}-max">---</td>
                                                </tr>
                                                <tr>
                                                    <td>Rerata<sub>(kg)</sub></td>
                                                    <td id="{{ $cardTitle }}-avg">---</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('add_script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('dashboard_api') }}",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response) {
                    // Update Global Data
                    $('#global-tersak').text(response.global.tertimbang_sak);
                    $('#global-terku').text(response.global.tertimbang_ku);
                    $('#global-min').text(response.global.min ?? '-');
                    $('#global-max').text(response.global.max ?? '-');
                    $('#global-avg').text(response.global.avg ?? '-');

                    // Update Each Card
                    ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'].forEach(function(card) {
                        $('#'+card+'-tersak').text(response[card].tertimbang_sak);
                        $('#'+card+'-terku').text(response[card].tertimbang_ku);
                        $('#'+card+'-min').text(response[card].min ?? '-');
                        $('#'+card+'-max').text(response[card].max ?? '-');
                        $('#'+card+'-avg').text(response[card].avg ?? '-');
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    });
</script>
@endsection
