<script type="text/javascript">
    
    $(document).ready(function() {
        
    });
    
    function save(){
        var lama = document.getElementById('lama').value;
        var baru = document.getElementById('baru').value;
        
        if(lama === ""){
            alert("Password lama tidak boleh kosong");
        }else if(baru === ""){
            alert("Password baru tidak boleh kosong");
        }else{
            $('#btnSave').html('<i class="mdi mdi-content-save"></i> Proses... ');
            $('#btnSave').attr('disabled',true);

            var form_data = new FormData();
            form_data.append('lama', lama);
            form_data.append('baru', baru);
            
            $.ajax({
                url: "<?php echo base_url(); ?>/changepass/proses",
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'POST',
                success: function (response) {
                    alert(response.status);
                    
                    $('#lama').val("");
                    $('#baru').val("");
                    
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
                    <h4 class="card-title">GANTI PASSWORD</h4>
                    <div class="forms-sample">
                        <div class="form-group">
                            <label>NRP</label>
                            <input type="text" class="form-control" autocomplete="off" value="<?php echo $nrp_profile; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>NAMA PERSONIL</label>
                            <input type="text" class="form-control" autocomplete="off" value="<?php echo $nama_profile; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>PASSWORD LAMA</label>
                            <input type="password" class="form-control" id="lama" name="lama" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>PASSWORD BARU</label>
                            <input type="password" class="form-control" id="baru" name="baru" autocomplete="off">
                        </div>
                        
                        <button id="btnSave" class="btn btn-primary" onclick="save()"><i class="mdi mdi-content-save"></i> Simpan </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>