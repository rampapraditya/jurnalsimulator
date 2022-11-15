<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>/personil/ajaxlist",
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
        $('.modal-title').text('Tambah personil');
    }

    function save() {
        var nrp = document.getElementById('nrp').value;
        var nama = document.getElementById('nama').value;
        var pangkat = document.getElementById('pangkat').value;
        var korps = document.getElementById('korps').value;
        var email = document.getElementById('email').value;
        
        if (nrp === '') {
            alert("NRP tidak boleh kosong");
        }else if(nama === ""){
            alert("Nama tidak boleh kosong");
        }else if(pangkat === "-"){
            alert("Pangkat tidak boleh kosong");
        }else if(korps === "-"){
            alert("Korps tidak boleh kosong");
        } else {
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled', true); //set button disable 

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>/personil/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>/personil/ajax_edit";
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
    }

    function hapus(id, nama) {
        if (confirm("Apakah anda yakin menghapus personil " + nama + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/personil/hapus/" + id,
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
        $('.modal-title').text('Ganti personil');
        $.ajax({
            url: "<?php echo base_url(); ?>/personil/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idusers);
                $('[name="nrp"]').val(data.nrp);        
                $('[name="nama"]').val(data.nama);
                $('[name="email"]').val(data.email);
                $('[name="korps"]').val(data.idkorps);
                $('[name="pangkat"]').val(data.idpangkat);
                $('[name="role"]').val(data.idrole);
                $('[name="iddivisi"]').val(data.iddivisi);
                $('[name="idjabatan"]').val(data.idjabatan);
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data');
            }
        });
    }
    
    function closemodal(){
        $('#modal_form').modal('hide');
    }

</script>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">MASTER PERSONIL</h4>
                    <p class="card-description">Maintenance data personil</p>
                    <button type="button" class="btn btn-primary" onclick="add();">Tambah</button>
                    <button type="button" class="btn btn-secondary" onclick="reload();">Reload</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NRP</th>
                                    <th>NAMA</th>
                                    <th>KORPS</th>
                                    <th>PANGKAT</th>
                                    <th>AKSES</th>
                                    <th>DIVISI</th>
                                    <th>JABATAN</th>
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
                        <label>NRP</label>
                        <input id="nrp" name="nrp" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>NAMA</label>
                        <input id="nama" name="nama" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>EMAIL</label>
                        <input id="email" name="email" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>PANGKAT</label>
                        <select id="pangkat" name="pangkat" class="form-control">
                            <option value="-">- PILIH PANGKAT -</option>
                            <?php
                            foreach ($pangkat->getResult() as $row) {
                                ?>
                            <option value="<?php echo $row->idpangkat; ?>"><?php echo $row->nama_pangkat; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>KORPS</label>
                        <select id="korps" name="korps" class="form-control">
                            <option value="-">- PILIH KORPS -</option>
                            <?php
                            foreach ($korps->getResult() as $row) {
                                ?>
                            <option value="<?php echo $row->idkorps; ?>"><?php echo $row->nama_korps; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>HAK AKSES</label>
                        <select id="role" name="role" class="form-control">
                            <option value="-">- PILIH HAK AKSES -</option>
                            <?php
                            foreach ($hakakses->getResult() as $row) {
                                ?>
                            <option value="<?php echo $row->idrole; ?>"><?php echo $row->nama_role; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>DIVISI</label>
                        <select id="iddivisi" name="iddivisi" class="form-control">
                            <option value="-">- PILIH DIVISI -</option>
                            <?php
                            foreach ($divisi->getResult() as $row) {
                                ?>
                            <option value="<?php echo $row->iddivisi; ?>"><?php echo $row->nama_divisi; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>JABATAN</label>
                        <select id="idjabatan" name="idjabatan" class="form-control">
                            <option value="-">- PILIH JABATAN -</option>
                            <?php
                            foreach ($jabatan->getResult() as $row) {
                                ?>
                            <option value="<?php echo $row->idjabatan; ?>"><?php echo $row->nama_jabatan; ?></option>
                                <?php
                            }
                            ?>
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