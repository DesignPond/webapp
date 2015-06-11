<html>
    <head>
        <style type="text/css">
            @page { margin: <?php echo $margin; ?>; }
            * {
                box-sizing: border-box;
            }
            .normalize{
                margin: 0;
                padding: 0;
            }
            .height{
                height: <?php echo $height; ?>;
                page-break-inside:avoid;
                box-sizing: border-box;
                position: relative;
            }
            span{
                position: absolute;
                display: block;
                color: #000;
                line-height: 25px;
                width: 100%;
                height: 100%;
                font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
                box-sizing: border-box;
            }
        </style>
    </head>
    <body>

        <?php if(!empty($data)) {  ?>
            <?php foreach($data as $table) { ?>
                <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="ddd" style="page-break-after:always;">

                   <?php foreach($table as $row) { ?>
                   <?php
                        echo '<tr class="normalize">';
                        foreach($row as $name)
                        {
                            echo '<td width="'.$width.'" height="'.$height.'" class="normalize height">';
                            echo '<span>'.implode('<br/>',$name).'</span>';
                            echo '</td>';
                        }
                        echo '</tr>';
                    ?>
                   <?php } ?>

                </table>
            <?php } ?>
        <?php } ?>

    </body>
</html>