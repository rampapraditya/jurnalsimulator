<html>
    <head>
        <title>PENILAIAN</title>
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
            <p style="text-align: center; font-size: 14px;">SURAT MASUK</p>
            <table style="font-family: Arial; width: 100%; margin-top: 20px; border-collapse: collapse; border: 1px solid black;" border="1">
                <tr>
                    <th style="text-align: center; padding: 5px;">NO</th>
                    <th style="text-align: center; padding: 5px;">SIMULATOR</th>
                    <th style="text-align: center; padding: 5px;">TANGGAL</th>
                    <th style="text-align: center; padding: 5px;">NO SURAT</th>
                    <th style="text-align: center; padding: 5px;">PERIHAL</th>
                    <th style="text-align: center; padding: 5px;">TANGGAL</th>
                    <th style="text-align: center; padding: 5px;">KETERANGAN</th>
                </tr>
                <?php
                $no = 1;
                foreach ($list->getResult() as $row) {
                    ?>
                <tr>
                    <td style="padding: 5px;"><?php echo $no; ?></td>
                    <td style="padding: 5px;"><?php echo $row->nama_simulator; ?></td>
                    <td style="padding: 5px;"><?php echo $row->tgl; ?></td>
                    <td style="padding: 5px;"><?php echo $row->nosurat; ?></td>
                    <td style="padding: 5px;"><?php echo $row->dari; ?></td>
                    <td style="padding: 5px;"><?php echo $row->perihal; ?></td>
                    <td style="padding: 5px;"><?php echo $row->keterangan; ?></td>
                </tr>
                    <?php
                    $no++;
                }
                ?>
            </table>
        </main>
    </body>
</html>