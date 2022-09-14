<script type="text/javascript">

    var save_method; //for save method string
    var table, tb_renlat;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>/oprsim/ajaxlist",
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
        $('.modal-title').text('Tambah operasi latihan');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var kode_renlat = document.getElementById('kode_renlat').value;
        var foto = $('#foto').prop('files')[0];
        var tanggal = document.getElementById('tanggal').value;
        var kegiatan = document.getElementById('kegiatan').value;
        var waktuon = document.getElementById('waktuon').value;
        var waktuoff = document.getElementById('waktuoff').value;
        var kondisi = document.getElementById('kondisi').value;
        var keterangan = document.getElementById('keterangan').value;
        var mode = document.getElementById('mode').value;
        var simulator = document.getElementById('simulator').value;
        
        var form_data = new FormData();
        form_data.append('kode', kode);
        form_data.append('kode_renlat', kode_renlat);
        form_data.append('tanggal', tanggal);
        form_data.append('kegiatan', kegiatan);
        form_data.append('waktuon', waktuon);
        form_data.append('waktuoff', waktuoff);
        form_data.append('kondisi', kondisi);
        form_data.append('keterangan', keterangan);
        form_data.append('file', foto);
        form_data.append('mode', mode);
        form_data.append('simulator', simulator);
            
        if(document.getElementById('rbPemanasan').checked){
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>/oprsim/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>/oprsim/ajax_edit";
            }
            // ajax adding data to database
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

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }, error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error json " + errorThrown);

                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled', false); //set button enable 
                }
            });
        
        }else if(document.getElementById('rbLatihan').checked){
            if(kode_renlat === ""){
                alert("Pilih referensi RENLAT");
            }else{
                
                $('#btnSave').text('Saving...'); //change button text
                $('#btnSave').attr('disabled', true); //set button disable 

                var url = "";
                if (save_method === 'add') {
                    url = "<?php echo base_url(); ?>/oprsim/ajax_add";
                } else {
                    url = "<?php echo base_url(); ?>/oprsim/ajax_edit";
                }
                // ajax adding data to database
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

                        $('#btnSave').text('Save'); //change button text
                        $('#btnSave').attr('disabled', false); //set button enable 
                    }, error: function (jqXHR, textStatus, errorThrown) {
                        alert("Error json " + errorThrown);

                        $('#btnSave').text('Save'); //change button text
                        $('#btnSave').attr('disabled', false); //set button enable 
                    }
                });
            }
        }
    }

    function hapus(id, nama, mode) {
        if (confirm("Apakah anda yakin menghapus opslat nomor " + nama + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/oprsim/hapus/" + id + "/" + mode,
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
        $('.modal-title').text('Ganti operasi latihan');
        $.ajax({
            url: "<?php echo base_url(); ?>/oprsim/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.kode);
                $('[name="tanggal"]').val(data.tanggal);
                $('[name="kegiatan"]').val(data.kegiatan);
                $('[name="waktuon"]').val(data.waktu_on);
                $('[name="waktuoff"]').val(data.waktu_off);
                $('[name="kondisi"]').val(data.kondisi);
                $('[name="keterangan"]').val(data.keterangan);
                $('[name="kode_renlat"]').val(data.kode_renlat);
                $('[name="nm_renlat"]').val(data.nama_renlat);
                $('[name="mode"]').val(data.mode);
                $('[name="simulator"]').val(data.simulator);
                if(data.mode === "Pemanasan"){
                    document.getElementById('rbPemanasan').checked = true;
                }else if(data.mode === "Latihan"){
                    document.getElementById('rbLatihan').checked = true;
                }else{
                    document.getElementById('rbPemanasan').checked = true;
                }
                pilih_mode1(data.mode);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }
    
    function closemodalrenlat(){
        $('#modal_renlat').modal('hide');
    }
    
    function showopsi(){
        $('#modal_renlat').modal('show');
        tb_renlat = $('#tb_renlat').DataTable({
            ajax: "<?php echo base_url(); ?>/oprsim/ajaxrenlat",
            ordering: false,
            retrieve:true,
            scrollX: true
        });
        tb_renlat.destroy();
        tb_renlat = $('#tb_renlat').DataTable({
            ajax: "<?php echo base_url(); ?>/oprsim/ajaxrenlat",
            ordering: false,
            retrieve:true,
            scrollX: true
        });
    }
    
    function pilih(kode, nama){
        $('[name="kode_renlat"]').val(kode);
        $('[name="nm_renlat"]').val(nama);
        $('#modal_renlat').modal('hide');
    }
    
    function pilih_mode1(mode){
        if(mode === "Pemanasan"){
            $('[name="kode_renlat"]').val("");
            $('[name="nama_renlat"]').val("");
            $('[name="mode"]').val("Pemanasan");
            $('#lay_renlat').hide();
            $('#lay_simulator').show();
            
        }else if(mode === "Latihan"){
            $('[name="mode"]').val("Latihan");
            $('#lay_renlat').show();
            $('#lay_simulator').hide();
        }else{
            $('[name="mode"]').val("Pemanasan");
            $('[name="kode_renlat"]').val("");
            $('[name="nama_renlat"]').val("");
            $('#lay_renlat').hide();
            $('#lay_simulator').show();
        }
    }
    
    function pilih_mode(){
        if(document.getElementById('rbPemanasan').checked){
            $('[name="kode_renlat"]').val("");
            $('[name="nama_renlat"]').val("");
            $('[name="mode"]').val("Pemanasan");
            $('#lay_renlat').hide();
            $('#lay_simulator').show();
            
        }else if(document.getElementById('rbLatihan').checked){
            $('[name="mode"]').val("Latihan");
            $('#lay_renlat').show();
            $('#lay_simulator').hide();
        }else{
            $('[name="mode"]').val("Pemanasan");
            $('[name="kode_renlat"]').val("");
            $('[name="nama_renlat"]').val("");
            $('#lay_renlat').hide();
            $('#lay_simulator').show();
        }
    }

</script>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">TRANSAKSI OPERASI LATIHAN (OPSLAT)</h4>
                    <p class="card-description">Maintenance data operasi latihan</p>
                    <button type="button" class="btn btn-primary" onclick="add();">Tambah</button>
                    <button type="button" class="btn btn-secondary" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>FOTO</th>
                                    <th>SIMULATOR</th>
                                    <th>KEGIATAN</th>
                                    <th>TANGGAL</th>
                                    <th>WAKTU ON</th>
                                    <th>WAKTU OFF</th>
                                    <th>KONDISI</th>
                                    <th>MODE</th>
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
                    <input type="hidden" name="mode" id="mode" value="Latihan">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="opsi" id="rbPemanasan" value="Pemanasan" onchange="pilih_mode()"> Pemanasan
                                </label>
                            </div>
                            <div class="form-check" style="margin-left: 20px;">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="opsi" id="rbLatihan" value="Latihan" checked onchange="pilih_mode()"> Latihan
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="lay_simulator" style="display: none;">
                        <label>SIMULATOR</label>
                        <div class="input-group mb-3">
                            <select id="simulator" name="simulator" class="form-control">
                                <option value="-">- PILIH SIMULATOR -</option>
                                <?php
                                foreach ($simulator->getResult() as $row) {
                                    ?>
                                <option value="<?php echo $row->idsimulator; ?>"><?php echo $row->nama_simulator; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="lay_renlat">
                        <label>SIMULATOR</label>
                        <div class="input-group mb-3">
                            <input type="hidden" name="kode_renlat" id="kode_renlat">
                            <input type="text" class="form-control" readonly id="nm_renlat" name="nm_renlat">
                            <button class="btn btn-sm btn-outline-secondary" type="button" onclick="showopsi()">...</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>FOTO</label>
                        <input id="foto" name="foto" class="form-control" type="file" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>TANGGAL</label>
                        <input id="tanggal" name="tanggal" class="form-control" type="date" autocomplete="off" value="<?php echo $curdate; ?>">
                    </div>
                    <div class="form-group">
                        <label>KEGIATAN</label>
                        <input id="kegiatan" name="kegiatan" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>WAKTU ON</label>
                        <input id="waktuon" name="waktuon" class="form-control" type="time" autocomplete="off" value="<?php echo $curtime; ?>">
                    </div>
                    <div class="form-group">
                        <label>WAKTU OFF</label>
                        <input id="waktuoff" name="waktuoff" class="form-control" type="time" autocomplete="off" value="<?php echo $curtime; ?>">
                    </div>
                    <div class="form-group">
                        <label>KONDISI</label>
                        <select id="kondisi" name="kondisi" class="form-control">
                            <option value="NORMAL">NORMAL</option>
                            <option value="SAKIT">SAKIT</option>
                        </select>
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

<div class="modal fade" id="modal_renlat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>RENCANA LATIHAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodalrenlat();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tb_renlat" class="table table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>SIMULATOR</th>
                            <th>TANGGAL</th>
                            <th>NO SURAT</th>
                            <th>DARI</th>
                            <th>PERIHAL</th>
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