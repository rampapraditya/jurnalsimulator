<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function () {
        table = $('#tb').DataTable({
            ajax: "<?php echo base_url(); ?>/sakitsimnon/ajaxdetil/<?php echo $head->idsakit; ?>",
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
        $('.modal-title').text('Tambah barang sakit');
    }

    function save() {
        var kode = document.getElementById('kode').value;
        var kode_detil = document.getElementById('kode_detil').value;
        var nama = document.getElementById('nama').value;
        var gejala = document.getElementById('gejala').value;
        var kegiatan = document.getElementById('kegiatan').value;
        var keterangan = document.getElementById('keterangan').value;
        var foto = $('#foto').prop('files')[0];
        
        if (nama === "") {
            alert("Nama barang tidak boleh kosong");
        }else if(gejala === ""){
            alert("Gejala barang tidak boleh kosong");
        } else {
            $('#btnSave').text('Saving...');
            $('#btnSave').attr('disabled', true);

            var url = "";
            if (save_method === 'add') {
                url = "<?php echo base_url(); ?>/sakitsimnon/ajax_add_detil";
            } else {
                url = "<?php echo base_url(); ?>/sakitsimnon/ajax_edit_detil";
            }
            
            var form_data = new FormData();
            form_data.append('kode', kode);
            form_data.append('kode_detil', kode_detil);
            form_data.append('nama', nama);
            form_data.append('gejala', gejala);
            form_data.append('kegiatan', kegiatan);
            form_data.append('keterangan', keterangan);
            form_data.append('file', foto);
            
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
        if (confirm("Apakah anda yakin menghapus barang nomor " + nama + " ?")) {
            $.ajax({
                url: "<?php echo base_url(); ?>/sakitsimnon/hapusdetil/" + id,
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
        $('.modal-title').text('Ganti barang sakit');
        $.ajax({
            url: "<?php echo base_url(); ?>/sakitsimnon/gantidetil/" + id,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                $('[name="kode"]').val(data.idsakit_detil);
                $('[name="nama"]').val(data.nama_barang);
                $('[name="gejala"]').val(data.gejala);
                $('[name="kegiatan"]').val(data.kegiatan);
                $('[name="keterangan"]').val(data.keterangan);
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
                    <h4 class="card-title">DETIL SAKIT SIMULATOR</h4>
                </div>
                <div class="card-body">
                    <div class="forms-sample">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>SIMULATOR</label>
                                    <input type="text" class="form-control" autocomplete="off" value="<?php echo $head->nama_simulator; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>TANGGAL</label>
                                    <input type="text" class="form-control" autocomplete="off" value="<?php echo $head->tgl; ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if($nmrole == "KOMANDAN" || $nmrole == "WADAN"){
                    
                }else{
                    ?>
                <div class="card-body">
                    <button type="button" class="btn btn-sm btn-primary" onclick="add();">Tambah Barang</button>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="reload();">Reload</button>
                </div>
                    <?php
                }
                ?>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tb" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>FOTO</th>
                                    <th>BARANG</th>
                                    <th>GEJALA</th>
                                    <th>KEGIATAN</th>
                                    <th>KETERANGAN</th>
                                    <?php
                                    if($nmrole == "KOMANDAN" || $nmrole == "WADAN"){
                                        
                                    }else{
                                        ?>
                                    <th style="text-align: center;">AKSI</th>
                                        <?php
                                    }
                                    ?>
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
                    <input type="hidden" name="kode_detil" id="kode_detil" value="<?php echo $head->idsakit; ?>">
                    <div class="form-group">
                        <label>NAMA BARANG</label>
                        <input id="nama" name="nama" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>FOTO</label>
                        <input id="foto" name="foto" class="form-control" type="file" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>GEJALA</label>
                        <input id="gejala" name="gejala" class="form-control" type="text" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>KEGIATAN</label>
                        <input id="kegiatan" name="kegiatan" class="form-control" type="text" autocomplete="off">
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