<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>/sakitsim/ajaxlist",
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
        $('.modal-title').text('Tambah sakit simulator');
        var mode = '';
        if(document.getElementById('rbPemanasan').checked){
            mode = document.getElementById('rbPemanasan').value;
        }else if(document.getElementById('rbLatihan').checked){
            mode = document.getElementById('rbLatihan').value;
        }else if(document.getElementById('rbSakit').checked){
            mode = document.getElementById('rbSakit').value;
        }
        
        $.ajax({
            url: "<?php echo base_url(); ?>/sakitsim/load_sim/" + mode,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('#sim').html(data.status);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function load_sim_ulang(){
        var mode = '';
        if(document.getElementById('rbPemanasan').checked){
            mode = document.getElementById('rbPemanasan').value;
        }else if(document.getElementById('rbLatihan').checked){
            mode = document.getElementById('rbLatihan').value;
        }else if(document.getElementById('rbSakit').checked){
            mode = document.getElementById('rbSakit').value;
        }
        
        $.ajax({
            url: "<?php echo base_url(); ?>/sakitsim/load_sim/" + mode,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('#sim').html(data.status);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function save() {
        var kode = document.getElementById('kode').value;
        var tanggal = document.getElementById('tanggal').value;
        var mode = '';
        if(document.getElementById('rbPemanasan').checked){
            mode = document.getElementById('rbPemanasan').value;
        }else if(document.getElementById('rbLatihan').checked){
            mode = document.getElementById('rbLatihan').value;
        }else if(document.getElementById('rbSakit').checked){
            mode = document.getElementById('rbSakit').value;
        }
        var sim = document.getElementById('sim').value;
        
        if (sim === '-') {
            alert("Pilih simulator terlebih dahulu");
        } else {
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 
            
            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>/sakitsim/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>/sakitsim/ajax_edit";
            }
            
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('tanggal', tanggal);
            form_data.append('mode', mode);
            form_data.append('sim', sim);
            
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

    function hapus(id, nama) {
        if (confirm("Apakah anda yakin menghapus sakit simulator " + nama + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/sakitsim/hapus/" + id,
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
        $('.modal-title').text('Ganti sakit simulator');
        $.ajax({
            url: "<?php echo base_url(); ?>/sakitsim/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idsakit);
                $('[name="tanggal"]').val(data.tanggal);
                if(data.model === "Pemanasan"){
                    document.getElementById('rbPemanasan').checked = true;
                }else if(data.model === "Latihan"){
                    document.getElementById('rbLatihan').checked = true;
                }else if(data.model === "Sakit"){
                    document.getElementById('rbSakit').checked = true;
                }
                load_sim_ulang1(data.kd_rujukan);
                
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function load_sim_ulang1(kode){
        var mode = '';
        if(document.getElementById('rbPemanasan').checked){
            mode = document.getElementById('rbPemanasan').value;
        }else if(document.getElementById('rbLatihan').checked){
            mode = document.getElementById('rbLatihan').value;
        }else if(document.getElementById('rbSakit').checked){
            mode = document.getElementById('rbSakit').value;
        }
        $.ajax({
            url: "<?php echo base_url(); ?>/sakitsim/load_sim1/" + mode + "/" + kode,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('#sim').html(data.status);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data load combo');
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }
    
    function detil(kode){
        window.location.href = "<?php echo base_url(); ?>/sakitsim/detil/" + kode;
    }
    
    function cetak(){
        window.location.href = "<?php echo base_url(); ?>/sakitsim/cetak";
    }

</script>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">SAKIT SIMULATOR</h4>
                    <p class="card-description">Maintenance data sakit simulator</p>
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
                                    <th>STATUS</th>
                                    <th style="text-align: center;">DETIL</th>
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
                        <label>Tanggal</label>
                        <input id="tanggal" name="tanggal" class="form-control" type="date" autocomplete="off" value="<?php echo $curdate; ?>">
                    </div>
                    <div class="form-group">
                        <label>Model</label>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="model" id="rbPemanasan" value="Pemanasan" checked onchange="load_sim_ulang()";> Pemanasan
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="model" id="rbLatihan" value="Latihan" onchange="load_sim_ulang()";> Latihan
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="model" id="rbSakit" value="Sakit" onchange="load_sim_ulang()";> Sakit
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Simulator</label>
                        <select id="sim" name="sim" class="form-control">
                            <option value="-">- PILIH SIMULATOR -</option>
                        </select>
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