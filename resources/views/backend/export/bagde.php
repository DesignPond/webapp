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
                max-height: <?php echo $height; ?>;;
                page-break-inside:avoid;
                box-sizing: border-box;
                position: relative;
            }
            div{
                width: auto;
                height: auto;
                margin: auto;
                text-align: center;
            }
            span{
                font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
                color: #000;
                line-height: 20px;
                font-size: 15px;
                max-resolution: 0;
                padding: 0;
                display: block;
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

                            //echo '<div>'.implode('<br/>',$name).'</div>';
                            echo '<div>';
                            echo '<span>'.implode('</span><span>', $name).'</span>';
                            echo '</div>';

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