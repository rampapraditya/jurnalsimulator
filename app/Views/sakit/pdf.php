<html>
    <head>
        <title>JURNAL SIMULATOR</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 0.5cm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 0.5cm;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 1cm;

                /** Extra personal styles **/
                background-color: white;
                font-size: 9px;
                color: black;
                text-align: center;
                line-height: 1cm;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 1cm;

                /** Extra personal styles **/
                background-color: white;
                font-size: 9px;
                color: black;
                text-align: center;
                line-height: 1cm;
            }
            
            .dash{
                border: 0 none;
                border-top: 1px dashed #322f32;
                background: none;
                height:0;
            } 
              
            .circle {
                border-radius: 50%;
                width: 10px;
                height: 10px;
                padding: 5px;
                background: #fff;
                border: 0.8px solid #000;
                color: #000;
                text-align: center;
                font: 9px Arial, sans-serif;
            }
        </style>
    </head>
    <body>
<!--        <header>
            RAHASIA
        </header>
        <footer>
        </footer>-->
        <main style="font-size: 12px;">
            <table border="0">
                <tr>
                    <td style="text-align: center;">MARKAS BESAR ANGKATAN LAUT</td>
                </tr>
                <tr>
                    <td style="text-align: center;">SEKOLAH TINGGI TEKNOLOGI<hr></td>
                </tr>
            </table>
            <p style="text-align: center; font-size: 14px;">SAKIT SIMULATOR</p>
            <table style="font-family: Arial; width: 100%; margin-top: 20px; border-collapse: collapse; border: 1px solid black;" border="1">
                <tr>
                    <th style="text-align: center; padding: 5px;">NO</th>
                    <th style="text-align: center; padding: 5px;">SIMULATOR</th>
                    <th style="text-align: center; padding: 5px;">TANGGAL</th>
                    <th style="text-align: center; padding: 5px;">DETIL</th>
                </tr>
                <?php
                $no = 1;
                foreach ($list->getResult() as $row) {
                    ?>
                <tr>
                    <td style="padding: 5px;"><?php echo $no; ?></td>
                    <?php
                    $nama_simulator = $model->getAllQR("SELECT nama_simulator FROM simulator where idsimulator = '" . $row->simulator . "';")->nama_simulator;
                    ?>
                    <td style="padding: 5px;"><?php echo $nama_simulator; ?></td>
                    <td style="padding: 5px;"><?php echo $row->tgl; ?></td>
                    <td style="padding: 5px;">
                        <table style="font-family: Arial; width: 100%; margin-top: 20px; border-collapse: collapse; border: 1px solid darkgray;" border="1">
                            <tr>
                                <th style="text-align: center; padding: 5px;">FOTO</th>
                                <th style="text-align: center; padding: 5px;">BARANG</th>
                                <th style="text-align: center; padding: 5px;">GEJALA</th>
                                <th style="text-align: center; padding: 5px;">KEGIATAN</th>
                            </tr>
                            <?php
                            $list1 = $model->getAllQ("SELECT * FROM sakit_detil where idsakit = '" . $row->idsakit . "';");
                            foreach ($list1->getResult() as $row1) {
                                ?>
                            <tr>
                                <td style="padding: 5px;">
                                    <?php
                                    $defimg = 'images/noimg.png';
                                    if (strlen($row1->foto) > 0) {
                                        if (file_exists($modul->getPathApp().$row1->foto)) {
                                            $defimg = 'uploads/'.$row1->foto;
                                        }
                                    }
                                    ?>
                                    <img src="<?php echo $defimg; ?>" class="img-thumbnail" style="width: 50px; height: auto;">
                                </td>
                                <td style="padding: 5px;"><?php echo $row1->nama_barang; ?></td>
                                <td style="padding: 5px;"><?php echo $row1->gejala; ?></td>
                                <td style="padding: 5px;"><?php echo $row1->kegiatan; ?></td>
                            </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </td>
                </tr>
                    <?php
                    $no++;
                }
                ?>
            </table>
        </main>
    </body>
</html>