@extends('layouts.temp')

@section('breadcrumb')
    <h3 class="animated fadeInLeft">Dataset</h3>
@endsection

@section('content')
    <div class="col-md-12 padding-0">
        <div style="margin-bottom:20px;" class="col-md-12">
            <form id="form-support">
                <div class="col-md-3 col-md-offset-2">
                    <label class="control-label" style="font-weight:1000;">Minimal Support</label>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="hidden" name="id">
                        <input type="text" autocomplete="off" onkeypress="return err(this)" name="supp" class="form-control" aria-label="Text input with multiple buttons">
                        <div class="input-group-btn">
                            <button id="support" type="submit" class="btn btn-info">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="btn-group dropdown" style="margin-bottom:15px;">
        <a href="{{route('download')}}" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Format Import</a>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li><a onclick="Import()" href="#">Import Data</a></li>
                <li class="divider"></li>
	            <li><a href="#" onclick="Truncate()">Hapus Semua Data</a></li>
            </ul>
        </div>

        <div class="table-responsive">
            <table class="table table-stripped table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode</th>
                        <th>Jenis Kelamin</th>
                        <th>Kategori Usia</th>
                        <th>Pendidikan Terakhir</th>
                        <th>Pekerjaan</th>
                        <th>Jenis Pemakaian</th>
                        <th>Hasil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody> 
            </table>
        </div>
        @include('data.formImport')
        @include('data.formEdit')
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var tabel;
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            width:200,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        function msg(ic,tit){
            Toast.fire({icon: ic,title: tit })
        }
        $(document).ready(function(){
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
        Support()
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
                ajax:"{{route('dataset.index')}}",
                columns: [
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'code',name:'code'},
                    {data:'gender',name:'gender'},
                    {data:'usia',name:'usia'},
                    {data:'pendidikan',name:'pendidikan'},
                    {data:'pekerjaan',name:'pekerjaan'},
                    {data:'tes',name:'tes'},
                    {data:'pemakaian',name:'pemakaian'},
                    {data:'action',name:'action',orderable:false,searchable:false}
                ]
            });
            $('#form-support').on('submit',function(event){
                event.preventDefault();
                $('#support').text('Mengupdate...').attr('disabled',true);
                $.ajax({
                    url:"{{route('support.update')}}",
                    method:"POST",
                    data:$('#form-support').serialize(),
                    dataType:"JSON",
                    beforeSend:function(){
                        Swal.showLoading();
                    },
                    success:function(res){
                        $('#support').text('Update').attr('disabled',false);
                        msg('success','Update Support Sukses')
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        $('#support').text('Update').attr('disabled',false);
                        msg('error','Update Support Gagal')
                    }
                })
            })

            $('#form-import').on('submit',function(e){
                e.preventDefault();
                $('#import').text('Mengimport...').attr('disabled',true);
                $.ajax({
                    url: "{{route('import')}}",
                    method:"post",
                    data: new FormData(this),
                    cache:false,
                    contentType:false,
                    processData:false,
                    beforeSend:function(){
                    $('#modal-import').modal('hide');
                        Swal.showLoading()
                    },
                    success:function(res){
                        tabel.ajax.reload();
                        $('#import').text('Import').attr('disabled',false);
                        msg('success','Import Data Sukses')
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        $('#import').html('Import').attr('disabled',false);
                        msg('error','Import Data Gagal')
                    }
                })
            });
            $('#form-edit').on('submit',function (e) {
                e.preventDefault();
                $('#simpan').text('Menyimpan...').attr('disabled',true);
                $.ajax({
                    data:$('#form-edit').serialize(),
                    url:"{{route('dataset.store')}}",
                    type:"POST",
                    dataType:"JSON",
                    success:function(data){
                        $('#modal-edit').modal('hide');
                        $('#simpan').text('Simpan').attr('disabled',false);
                        tabel.ajax.reload();
                        msg('success','Data diubah')
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        $('#modal-edit').modal('hide');
                        $('#simpan').text('Simpan').attr('disabled',false);
                        msg('error','Gagal ubah data')
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                })
            })
        });

        function Support(){
            $.get("{{route('support.get')}}",function(res){
                    $('[name="id"]').val(res.id);
                    $('[name="supp"]').val(res.supp);
            })
        }

        function Import(){
            $('#form-import')[0].reset();
            $('.modal-title').text('Import Data');
            $('#modal-import').modal('show');
        }

        function editForm(id){
            $('#form-edit')[0].reset();
            $('.modal-title').text('Edit Data');
            $('#modal-edit').modal('show');
            $.get("{{route('dataset.index')}}"+'/'+id+'/edit',function(res){
                $('[name="id"]').val(res.id);
                $('[name="usia"]').val(res.usia);
                $('[name="gender"]').val(res.gender);
                $('[name="pendidikan"]').val(res.pendidikan);
                $('[name="pekerjaan"]').val(res.pekerjaan);
                $('[name="pemakaian"]').val(res.pemakaian);
                $('[name="tes"]').val(res.tes);
                $('[name="code"]').val(res.code);
            })
        }
        function deleteData(id){
            Swal.fire({
            title: 'Ingin Hapus data?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((res)=>{
            if(res.value){
                $.ajax({
                    url:"{{route('dataset.store')}}"+'/'+id,
                    type:"DELETE",
                    success:function(res){
                        tabel.ajax.reload();
                        msg('success','Data dihapus')
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        msg('error','Data Gagal dihapus')
                    }
                });
            }
        });
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
                    url:"{{route('truncate')}}",
                    type:"DELETE",
                    success:function(res){
                        tabel.ajax.reload();
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