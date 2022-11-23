<script type="text/javascript">

    var save_method; //for save method string
    var table, tb_sakit;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>/jhh/ajaxlist",
            ordering: false
        });
    });

    function reload() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah harwat harsis');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var idsakit_harsis = document.getElementById('idsakit_harsis').value;
        var tgl = document.getElementById('tgl').value;
        var kegiatan = document.getElementById('kegiatan').value;
        var pelaksanaan = document.getElementById('pelaksanaan').value;
        var keterangan = document.getElementById('keterangan').value;
        
        if (idsakit_harsis === '') {
            alert("Pilih sakit harsis tidak boleh kosong");
        }else if(tgl === ""){
            alert("Tanggal tidak boleh kosong");
        }else if(kegiatan === ""){
            alert("Kegiatan tidak boleh kosong");
        }else if(pelaksanaan === ""){
            alert("Pelaksanaan tidak boleh kosong");
        } else {
            $('#btnSave').text('Saving...');
            $('#btnSave').attr('disabled', true);
            
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('idsakit', idsakit_harsis);
            form_data.append('tgl', tgl);
            form_data.append('kegiatan', kegiatan);
            form_data.append('pelaksanaan', pelaksanaan);
            form_data.append('keterangan', keterangan);
            
            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>/jhh/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>/jhh/ajax_edit";
            }
            
            $.ajax({
                url: url,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (data) {
                    alert(data.status);
                    $('#modal_form').modal('hide');
                    reload();

                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);
                    
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Save');
                    $('#btnSave').attr('disabled', false);
                }
            });
        }
    }

    function hapus(id, nama) {
        if (confirm("Apakah anda yakin menghapus harwat harsis nomor " + nama + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/jhh/hapus/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    alert(data.status);
                    reload();
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error hapus data');
                }
            });
        }
    }

    function ganti(id) {
        save_method = 'update';
        $('#form')[0].reset();
        $('#modal_form').modal('show');
        $('.modal-title').text('Ganti harwat harsis');
        $.ajax({
            url: "<?php echo base_url(); ?>/jhh/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idharwat_harsis);
                $('[name="idsakit_harsis"]').val(data.idsakit_harsis);
                $('[name="kerusakan"]').val(data.kerusakan);
                $('[name="tindakan"]').val(data.tindakan);
                $('[name="tgl"]').val(data.tanggal);
                $('[name="kegiatan"]').val(data.kegiatan);
                $('[name="pelaksanaan"]').val(data.pelaksanaan);
                $('[name="keterangan"]').val(data.keterangan);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }
    
    function show_sakit_harsis(){
        $('#modal_sakit').modal('show');
        tb_sakit = $('#tb_sakit').DataTable({
            ajax: "<?php echo base_url(); ?>/jhh/ajaxshowsakit",
            ordering: false,
            retrieve:true
        });
        tb_sakit.destroy();
        tb_sakit = $('#tb_sakit').DataTable({
            ajax: "<?php echo base_url(); ?>/jhh/ajaxshowsakit",
            ordering: false,
            retrieve:true
        });
    }
    
    function pilih(idsakit, kerusakan, tindakan){
        $('[name="idsakit_harsis"]').val(idsakit);
        $('[name="kerusakan"]').val(kerusakan);
        $('[name="tindakan"]').val(tindakan);
        $('#modal_sakit').modal('hide');
    }
    
    function cm_sakit(){
        $('#modal_sakit').modal('hide');
    }
    
    function cetak(){
        window.location.href = "<?php echo base_url(); ?>/jhh/cetak";
    }

</script>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">JURNAL HARWAT HARSIS</h4>
                    <p class="card-description">Maintenance jurnal perawatan sakit simulator</p>

                    <button type="button" class="btn btn-primary" onclick="add();">Tambah</button>
                    <button type="button" class="btn btn-secondary" onclick="reload();">Reload</button>
                    <button type="button" class="btn btn-secondary" onclick="cetak();">Cetak</button>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
									<th>SIMULATOR</th>
                                    <th>TANGGAL</th>
                                    <th>KEGIATAN</th>
                                    <th>PELAKSANA</th>
                                    <th>KETERANGAN</th>
                                    <th>STATUS</th>
                                    <th style="text-align: center;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form" class="form-horizontal">
                    <input type="hidden" name="kode" id="kode">
                    <div class="form-group">
                        <label>SAKIT</label>
                        <div class="input-group mb-3">
                            <input type="hidden" name="idsakit_harsis" id="idsakit_harsis">
                            <input type="text" class="form-control" readonly id="kerusakan" name="kerusakan">
                            <button class="btn btn-sm btn-outline-secondary" type="button" onclick="show_sakit_harsis()">...</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>TINDAKAN</label>
                        <input id="tindakan" name="tindakan" class="form-control" type="text" autocomplete="off" readonly>
                    </div>
                    <div class="form-group">
                        <label>TANGGAL</label>
                        <input id="tgl" name="tgl" class="form-control" type="date" autocomplete="off" value="<?php echo $curdate ?>">
                    </div>
                    <div class="form-group">
                        <label>KEGIATAN</label>
                        <input id="kegiatan" name="kegiatan" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>PELAKSANA</label>
                        <input id="pelaksanaan" name="pelaksanaan" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>KETERANGAN</label>
                        <input id="keterangan" name="keterangan" class="form-control" type="text" autocomplete="off">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnSave" type="button" class="btn btn-primary" onclick="save();">Save</button>
                <button type="button" class="btn btn-secondary" onclick="closemodal();">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_sakit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Data Sakit Harsis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cm_sakit();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tb_sakit" class="table table-hover" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>FOTO</th>
                                <th>SIMULATOR</th>
                                <th>TANGGAL</th>
                                <th>KERUSAKAN</th>
                                <th>TINDAKAN</th>
                                <th>KETERANGAN</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>