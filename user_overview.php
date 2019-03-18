<DOCTYPE html>
<html>
    <head>
        <title>
        Super formulier
        </title>
    </head>
    
    <body>
        <table border="1">
            <tr>
                <th>Naam</th>
                <th>Adres</th>
                <th>Maat</th>
                <th>Kleur</th>
                <th>Glitter</th>
            </tr>
        <?php
            $ch= curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1/API/get_orders.php');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $output = curl_exec($ch);
            $data = json_decode($output);
            
            curl_close($ch);
           
            foreach($data as $row){
                        ?>
            <tr>
                <td>
                    <?php echo $row->name?>
                </td>
                <td>
                    <?php echo $row->address?>
                </td>
                <td>
                    <?php echo $row->size?>
                </td>
                <td>
                    <?php echo $row->color?>
                </td>
                <td>
                    <?php echo $row->glitter? "Ja" : "Nee";?>
                </td>
            </tr>
            <?php
    } ?>
        </table>
        <a href="index.html">Ga terug naar de bestelpagina</a>
    </body>
</html>