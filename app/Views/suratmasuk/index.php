<script type="text/javascript">

    var save_method; //for save method string
    var table, tbsim;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>/suratmasuk/ajaxlist",
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
        $('.modal-title').text('Tambah surat rencana latihan');
    }

    function save() {
        var kode_sim = document.getElementById('kode_sim').value;
        var tanggal = document.getElementById('tanggal').value;
        var nosurat = document.getElementById('nosurat').value;
        var dari = document.getElementById('dari').value;
        
        if(document.getElementById('rbAlat').checked){
            if (kode_sim === '') {
                alert("Pilih simulator terlebih dahulu");
            }else if(tanggal === ""){
                alert("Tanggal tidak boleh kosong");
            }else if(nosurat === ""){
                alert("Nomor surat tidak boleh kosong");
            }else if(dari === ""){
                alert("Dari tidak boleh kosong");
            } else {
                gass();
            }
            
        }else if(document.getElementById('rbNonAlat').checked){
            if(tanggal === ""){
                alert("Tanggal tidak boleh kosong");
            }else if(nosurat === ""){
                alert("Nomor surat tidak boleh kosong");
            }else if(dari === ""){
                alert("Dari tidak boleh kosong");
            } else {
                gass();
            }
            
        }else{
            if (kode_sim === '') {
                alert("Pilih simulator terlebih dahulu");
            }else if(tanggal === ""){
                alert("Tanggal tidak boleh kosong");
            }else if(nosurat === ""){
                alert("Nomor surat tidak boleh kosong");
            }else if(dari === ""){
                alert("Dari tidak boleh kosong");
            } else {
                gass();
            }
        }
        
        
    }
    
    function gass(){
        $('#btnSave').text('Saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "";
        if (save_method === 'add') {
            url = "<?php echo base_url(); ?>/suratmasuk/ajax_add";
        } else {
            url = "<?php echo base_url(); ?>/suratmasuk/ajax_edit";
        }
        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
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

    function hapus(id, nama) {
        if (confirm("Apakah anda yakin menghapus surat masuk nomor " + nama + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/suratmasuk/hapus/" + id,
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
        $('.modal-title').text('Ganti surat rencana latihan');
        $.ajax({
            url: "<?php echo base_url(); ?>/suratmasuk/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idsuratmasuk);
                $('[name="kode_sim"]').val(data.idsimulator);
                $('[name="nm_sim"]').val(data.nama_simulator);
                $('[name="tanggal"]').val(data.tanggal);
                $('[name="nosurat"]').val(data.nosurat);
                $('[name="dari"]').val(data.dari);
                $('[name="perihal"]').val(data.perihal);
                $('[name="keterangan"]').val(data.keterangan);
                if(data.mode === "Alat"){
                    document.getElementById('rbAlat').checked = true;
                }else if(data.mode === "Non Alat"){
                    document.getElementById('rbNonAlat').checked = true;
                }else{
                    document.getElementById('rbAlat').checked = true;
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
    
    function closemodalsim(){
        $('#modal_sim').modal('hide');
    }
    
    function showsim(){
        $('#modal_sim').modal('show');
        tbsim = $('#tbsim').DataTable({
            ajax: "<?php echo base_url(); ?>/suratmasuk/ajaxsim",
            ordering: false,
            retrieve:true,
            scrollX: true
        });
        tbsim.destroy();
        tbsim = $('#tbsim').DataTable({
            ajax: "<?php echo base_url(); ?>/suratmasuk/ajaxsim",
            ordering: false,
            retrieve:true,
            scrollX: true
        });
    }
    
    function pilih(kode, nama){
        $('[name="kode_sim"]').val(kode);
        $('[name="nm_sim"]').val(nama);
        $('#modal_sim').modal('hide');
    }
    
    function pilih_mode1(mode){
        if(mode === "Alat"){
            $('#lay_alat').show();
            $('[name="mode"]').val("Alat");
            
        }else if(mode === "Non Alat"){
            $('[name="kode_sim"]').val("");
            $('[name="nm_sim"]').val("");
            $('[name="mode"]').val("Non Alat");
            $('#lay_alat').hide();
        }else{
            $('#lay_alat').show();
            $('[name="mode"]').val("Alat");
        }
    }
    
    function pilih_mode(){
        if(document.getElementById('rbAlat').checked){
            $('#lay_alat').show();
            $('[name="mode"]').val("Alat");
            
        }else if(document.getElementById('rbNonAlat').checked){
            $('[name="kode_sim"]').val("");
            $('[name="nm_sim"]').val("");
            $('[name="mode"]').val("Non Alat");
            $('#lay_alat').hide();
        }else{
            $('#lay_alat').show();
            $('[name="mode"]').val("Alat");
        }
    }
    
    function cetak(){
        window.open("<?php echo base_url(); ?>/suratmasuk/cetak", "_blank");
    }

</script>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">TRANSAKSI SURAT MASUK (RENLAT)</h4>
                    <p class="card-description">Maintenance data surat masuk / surat rencana latihan</p>

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
                    <input type="hidden" name="mode" id="mode" value="Alat">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="opsi" id="rbAlat" value="Alat" checked onchange="pilih_mode()"> Alat
                                </label>
                            </div>
                            <div class="form-check" style="margin-left: 20px;">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="opsi" id="rbNonAlat" value="Non Alat" onchange="pilih_mode()"> Non Alat
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="lay_alat">
                        <label>SIMULATOR</label>
                        <div class="input-group mb-3">
                            <input type="hidden" name="kode_sim" id="kode_sim">
                            <input type="text" class="form-control" readonly id="nm_sim" name="nm_sim">
                            <button class="btn btn-sm btn-outline-secondary" type="button" onclick="showsim()">...</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>TANGGAL</label>
                        <input id="tanggal" name="tanggal" class="form-control" type="date" autocomplete="off" value="<?php echo $curdate; ?>">
                    </div>
                    <div class="form-group">
                        <label>NO SURAT</label>
                        <input id="nosurat" name="nosurat" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>DARI</label>
                        <input id="dari" name="dari" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>PERIHAL</label>
                        <input id="perihal" name="perihal" class="form-control" type="text" autocomplete="off">
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

<div class="modal fade" id="modal_sim" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>DATA SIMULATOR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodalsim();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tbsim" class="table table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>SIMULATOR</th>
                            <th>LETAK</th>
                            <th>TAHUN</th>
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