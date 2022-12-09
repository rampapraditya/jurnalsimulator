<script type="text/javascript">
    
    $(document).ready(function() {
        
    });
    
    function save(){
        var nrp = document.getElementById('nrp').value;
        var nama = document.getElementById('nama').value;
        var foto = $('#foto').prop('files')[0];
        var korps = document.getElementById('korps').value;
        var pangkat = document.getElementById('pangkat').value;
        
        if(nama === ""){
            alert("Nama tidak boleh kosong");
        }else if(korps === "-"){
            alert("Pilih korps terlebih dahulu");
        }else if(pangkat === "-"){
            alert("Pilih pangkat terlebih dahulu");
        }else{
            $('#btnSave').html('<i class="mdi mdi-content-save"></i> Proses... ');
            $('#btnSave').attr('disabled',true);

            var form_data = new FormData();
            form_data.append('nrp', nrp);
            form_data.append('nama', nama);
            form_data.append('file', foto);
            form_data.append('korps', korps);
            form_data.append('pangkat', pangkat);
            
            $.ajax({
                url: "<?php echo base_url(); ?>/profilenon/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);
                    
                    $('#btnSave').html('<i class="mdi mdi-content-save"></i> Simpan ');
                    $('#btnSave').attr('disabled',false);

                },error: function (response) {
                    alert(response.status);

                    $('#btnSave').html('<i class="mdi mdi-content-save"></i> Simpan ');
                    $('#btnSave').attr('disabled',false);
                }
            });
        }
    }
    
</script>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">PROFIL PERSONIL</h4>
                    <div class="forms-sample">
                        <div class="form-group">
                            <label>NRP</label>
                            <input type="text" class="form-control" id="nrp" name="nrp" autofocus="" autocomplete="off" value="<?php echo $nrp_profile; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>NAMA PERSONIL</label>
                            <input type="text" class="form-control" id="nama" name="nama"  autocomplete="off" value="<?php echo $nama_profile; ?>">
                        </div>
                        <div class="form-group">
                            <label>FOTO</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        <div class="form-group">
                            <label>KORPS</label>
                            <select id="korps" name="korps" class="form-control">
                                <option value="-">- PILIH KORPS -</option>
                                <?php
                                foreach ($korps->getResult() as $row) {
                                    ?>
                                <option <?php if($row->idkorps == $korps_profile){ echo 'selected'; } ?> value="<?php echo $row->idkorps; ?>"><?php echo $row->nama_korps; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>PANGKAT</label>
                            <select id="pangkat" name="pangkat" class="form-control">
                                <option value="-">- PILIH PANGKAT -</option>
                                <?php
                                foreach ($pangkat->getResult() as $row) {
                                    ?>
                                <option <?php if($row->idpangkat == $pangkat_profile){ echo 'selected'; } ?> value="<?php echo $row->idpangkat; ?>"><?php echo $row->nama_pangkat; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <button id="btnSave" class="btn btn-primary" onclick="save()"><i class="mdi mdi-content-save"></i> Simpan </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>