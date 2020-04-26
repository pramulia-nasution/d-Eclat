@extends('layouts.temp')

@section('breadcrumb')
    <h3 class="animated fadeInLeft">Declat</h3>
    <p class="animated fadeInDown">
        3-Itemset
    </p>
@endsection

@section('content')
<div class="col-md-12 padding-0">
    @if ($total > 0 && $cek)
    <button id="btn" style="margin-bottom:15px;" onclick="Calculate()" type="button" class="btn btn-primary"><i class="fa fa-calculator"></i> Buat 3-Itemset</button>
    @endif
    <div class="table-responsive">
        <table class="table table-stripped table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Inisial</th>
                    <th>TID List</th>
                    <th>Support Count</th>
                    <th>Support (%)</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    var tabel;
    $(document).ready(function(){
        $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            tabel = $('.table').DataTable({
                oLanguage: {
                    sSearch       :"<i class='fa fa-search fa-fw'></i> Cari: ",
                    sLengthMenu   :"Tampilkan _MENU_ data", 
                    sInfo         :"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    sInfoFiltered :"(disaring dari _MAX_ total data)", 
                    sZeroRecords  :"Oops..data kosong", 
                    sEmptyTable   :"Data kosong.", 
                    sInfoEmpty    :"Menampilkan 0 sampai 0 data",
                    sProcessing   :"Sedang memproses...", 
                    oPaginate: {
                        sPrevious :"Sebelumnya",
                        sNext     :"Selanjutnya",
                        sFirst    :"Pertama",
                        sLast     :"Terakhir"
                    }
                },
                processing:true,
                serverSide:true,
                ajax:"{{route('declat.tiga')}}",
                columns: [
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'inisial',name:'inisial'},
                    {data:'tidList',name:'tidList'},
                    {data:'supportCount',name:'supportCount'},
                    {data:'support',name:'suppot'}
                ]
            });
    });
    function msg(ic,tit,tex){
            Swal.fire({icon: ic,title: tit,text:tex,timer:2000 })
    }

        function Calculate(){
            $.ajax({
                url:"{{route('declat.set3')}}",
                beforeSend:function(){
                    Swal.showLoading()
                },
                success:function(res){
                    tabel.ajax.reload();
                    $('#btn').addClass('hidden');
                    msg('success','Sukses','Kalkulasi Selesai')
                },
                error:function(jqXHR, textStatus, errorThrown){
                    msg('error','Opps..','Proses Kalkulasi Error')
                }
            })
        }
</script>
@endsection