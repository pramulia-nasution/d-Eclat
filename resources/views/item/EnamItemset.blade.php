@extends('layouts.temp')

@section('breadcrumb')
    <h3 class="animated fadeInLeft">Declat</h3>
    <p class="animated fadeInDown">
        6-Itemset
    </p>
@endsection

@section('content')
<div class="col-md-12 padding-0">
    @if ($total > 0 && $cek)
    <button id="btn" style="margin-bottom:15px;" onclick="Calculate()" type="button" class="btn btn-primary"><i class="fa fa-calculator"></i> Buat 6-Itemset</button>
    @endif
    <button  style="margin-bottom:15px;"  type="button" onclick="Truncate()" class="btn btn-warning btn-gradient"><i class=" fa fa-trash-o"></i>  Kosongkan Itemset</button>
    <a href="{{route('export.excel')}}" style="margin-bottom:15px;" class="btn btn-success btn-gradient"><i class=" fa fa-file-excel-o"></i> Export Excel </a>
    <a href="{{route('export.pdf')}}"  style="margin-bottom:15px;" class="btn btn-danger btn-gradient"><i class=" fa fa-file-pdf-o"></i> Export Pdf</a>
   
    <div class="table-responsive">
        <table id="tabel" class="table table-stripped table-bordered">
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
    <hr/>
    <label style="font-size:16px;font-weight:1000;">Nilai Confidence</label>
    <div class="table-responsive">
        <table id="tabel_2" class="table table-stripped table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Frekuensi Itemset</th>
                    <th>Support (%)</th>
                    <th>Confidence (%)</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<label style="font-size:16px;font-weight:1000;">Hasil Evaluasi</label>
<div  class="table-responsive">
    <table id="tabel_3" class="table table-hover">
        <thead>
            <tr>
                <th width="10">No.</th>
                <th>Kesimpulan</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@section('js')
<script type="text/javascript">
    var tabel,tabel_2,tabel_3;
    $(document).ready(function(){
        $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            tabel_3 = $('#tabel_3').DataTable({
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
                ajax:"{{route('declat.evaluation')}}",
                columns: [
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'name',name:'name'}
                ]
            });
            tabel_2 = $('#tabel_2').DataTable({
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
                ajax:"{{route('declat.confidence')}}",
                columns: [
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'itemset',name:'itemset'},
                    {data:'support',name:'support'},
                    {data:'confidence',name:'confidence'}
                ]
            });
            tabel = $('#tabel').DataTable({
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
                ajax:"{{route('declat.enam')}}",
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
                url:"{{route('declat.set6')}}",
                beforeSend:function(){
                    Swal.showLoading()
                },
                success:function(res){
                    tabel.ajax.reload();
                    tabel_2.ajax.reload();
                    tabel_3.ajax.reload();
                    $('#btn').addClass('hidden');
                    msg('success','Sukses','Kalkulasi Selesai')
                },
                error:function(jqXHR, textStatus, errorThrown){
                    msg('error','Opps..','Proses Kalkulasi Error')
                }
            })
        }
        function Truncate(){
            Swal.fire({
            title: 'Ingin kosongkan data?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((res)=>{
            if(res.value){
                $.ajax({
                    url:"{{route('truncate.data')}}",
                    type:"DELETE",
                    beforeSend:function(){
                        Swal.showLoading()
                    },
                    success:function(res){
                        tabel.ajax.reload();
                        tabel_2.ajax.reload();
                        tabel_3.ajax.reload();
                        $('#clear').addClass('hidden');
                        msg('success','Data dihapus')
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        msg('error','Data Gagal dihapus')
                    }
                });
            }
        });
    }
</script>
@endsection