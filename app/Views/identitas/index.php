<script type="text/javascript">
    
    $(document).ready(function() {
        
    });
    
    function save(){
        var ins = document.getElementById('ins').value;
        var slogan = document.getElementById('slogan').value;
        var tahun = document.getElementById('tahun').value;
        var pimpinan = document.getElementById('pimpinan').value;
        var alamat = document.getElementById('alamat').value;
        var kdpos = document.getElementById('kdpos').value;
        var tlp = document.getElementById('tlp').value;
        var fax = document.getElementById('fax').value;
        var web = document.getElementById('web').value;
        var lat = document.getElementById('lat').value;
        var lon = document.getElementById('lon').value;
        var foto = $('#logo').prop('files')[0];
        
        if(ins === ""){
            alert("Instansi tidak boleh kosong");
        }else if(alamat === ""){
            alert("Alamat tidak boleh kosong");
        }else if(tlp === ""){
            alert("Telepon tidak boleh kosong");
        }else{
            $('#btnSave').html('<i class="mdi mdi-content-save"></i> Proses... ');
            $('#btnSave').attr('disabled',true);

            var form_data = new FormData();
            form_data.append('nama', ins);
            form_data.append('slogan', slogan);
            form_data.append('tahun', tahun);
            form_data.append('pimpinan', pimpinan);
            form_data.append('alamat', alamat);
            form_data.append('kdpos', kdpos);
            form_data.append('tlp', tlp);
            form_data.append('fax', fax);
            form_data.append('web', web);
            form_data.append('lat', lat);
            form_data.append('lon', lon);
            form_data.append('file', foto);
            
            $.ajax({
                url: "<?php echo base_url(); ?>/identitas/proses",
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
                    <h4 class="card-title">IDENTITAS PERUSAHAAN / INSTANSI</h4>
                    <div class="forms-sample">
                        <div class="form-group">
                            <label>NAMA INSTANSI</label>
                            <input type="text" class="form-control" id="ins" name="ins" autofocus="" autocomplete="off" value="<?php echo $instansi; ?>">
                        </div>
                        <div class="form-group">
                            <label>SLOGAN</label>
                            <input type="text" class="form-control" id="slogan" name="slogan"  autocomplete="off" value="<?php echo $slogan; ?>">
                        </div>
                        <div class="form-group">
                            <label>TAHUN BERDIRI</label>
                            <input type="text" class="form-control" id="tahun" name="tahun" autocomplete="off" onkeypress="return hanyaAngka(event,false);" value="<?php echo $tahun; ?>">
                        </div>
                        <div class="form-group">
                            <label>PIMPINAN</label>
                            <input type="text" class="form-control" id="pimpinan" name="pimpinan"  autocomplete="off" value="<?php echo $pimpinan; ?>">
                        </div>
                        <div class="form-group">
                            <label>ALAMAT</label>
                            <input type="text" class="form-control" id="alamat" name="alamat"  autocomplete="off" value="<?php echo $alamat; ?>">
                        </div>
                        <div class="form-group">
                            <label>KODE POS</label>
                            <input type="text" class="form-control" id="kdpos" name="kdpos"  autocomplete="off" onkeypress="return hanyaAngka(event, false);" value="<?php echo $kdpos; ?>">
                        </div>
                        <div class="form-group">
                            <label>TELEPON</label>
                            <input type="text" class="form-control" id="tlp" name="tlp"  autocomplete="off" onkeypress="return hanyaAngka(event, false);" value="<?php echo $tlp; ?>">
                        </div>
                        <div class="form-group">
                            <label>FAX</label>
                            <input type="text" class="form-control" id="fax" name="fax"  autocomplete="off" value="<?php echo $fax; ?>">
                        </div>
                        <div class="form-group">
                            <label>WEBSITE</label>
                            <input type="text" class="form-control" id="web" name="web"  autocomplete="off" value="<?php echo $website; ?>">
                        </div>
                        <div class="form-group">
                            <label>LOGO</label>
                            <input type="file" class="form-control" id="logo" name="logo">
                        </div>
                        <div class="form-group">
                            <label>LINTANG</label>
                            <input type="text" class="form-control" id="lat" name="lat"  autocomplete="off" value="<?php echo $lat; ?>">
                        </div>
                        <div class="form-group">
                            <label>BUJUR</label>
                            <input type="text" class="form-control" id="lon" name="lon"  autocomplete="off" value="<?php echo $lon; ?>">
                        </div>
                        <button id="btnSave" class="btn btn-primary" onclick="save()"><i class="mdi mdi-content-save"></i> Simpan </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>