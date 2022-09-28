<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>/ssh/ajaxlist",
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
        $('.modal-title').text('Tambah sakit simulator harsis');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var foto = $('#foto').prop('files')[0];
        var idsakit = document.getElementById('idsakit').value;
        var tgl = document.getElementById('tgl').value;
        var kerusakan = document.getElementById('kerusakan').value;
        var tindakan = document.getElementById('tindakan').value;
        var keterangan = document.getElementById('keterangan').value;
        
        if (idsakit === '-') {
            alert("Pilih simulator tidak boleh kosong");
        }else if(tgl === ""){
            alert("Tanggal tidak boleh kosong");
        }else if(kerusakan === ""){
            alert("Kerusakan tidak boleh kosong");
        }else if(tindakan === ""){
            alert("Tindakan tidak boleh kosong");
        } else {
            $('#btnSave').text('Saving...');
            $('#btnSave').attr('disabled', true);
            
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('idsakit', idsakit);
            form_data.append('tgl', tgl);
            form_data.append('kerusakan', kerusakan);
            form_data.append('tindakan', tindakan);
            form_data.append('keterangan', keterangan);
            form_data.append('file', foto);
            
            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>/ssh/ajax_add";
            } else {
                url = "<?php echo base_url(); ?>/ssh/ajax_edit";
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
        if (confirm("Apakah anda yakin menghapus sakit simulator harsis nomor " + nama + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/ssh/hapus/" + id,
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
        $('.modal-title').text('Ganti sakit simulator harsis');
        $.ajax({
            url: "<?php echo base_url(); ?>/sakitsimharsis/ganti/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idkorps);
                $('[name="nama"]').val(data.nama_korps);
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
                    <h4 class="card-title">JURNAL SAKIT HARSIS</h4>
                    <p class="card-description">Maintenance jurnal sakit divisi harsis</p>

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
                        <label>FOTO</label>
                        <input id="foto" name="foto" class="form-control" type="file" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>SIMULATOR</label>
                        <select id="idsakit" name="idsakit" class="form-control">
                            <option value="-">- PILIH SIMULATOR -</option>
                            <?php
                            foreach ($sakit->getResult() as $row) {
                                ?>
                            <option value="<?php echo $row->idsakit; ?>"><?php echo $row->nama_simulator; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>TANGGAL</label>
                        <input id="tgl" name="tgl" class="form-control" type="date" autocomplete="off" value="<?php echo $curdate ?>">
                    </div>
                    <div class="form-group">
                        <label>KERUSAKAN</label>
                        <input id="kerusakan" name="kerusakan" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>TINDAKAN</label>
                        <input id="tindakan" name="tindakan" class="form-control" type="text" autocomplete="off">
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