<DOCTYPE html>
    <html>

    <head>
        <title>
            User overview
        </title>
    </head>

    <body>
        <table border="1">
            <tr>
                <th>Gebruikersnaam</th>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Rol</th>
            </tr>
            <?php
            $ch= curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1/API/get_users.php');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $output = curl_exec($ch);
            $data = json_decode($output);
            
            curl_close($ch);
           
            foreach($data as $row){
                        ?>
            <tr>
                <td>
                    <?php echo $row->firstName?>
                </td>
                <td>
                    <?php echo $row->lastName?>
                </td>
                <td>
                    <?php echo $row->userName?>
                </td>
                <td>
                    <?php echo $row->role?>
                </td>
            </tr>
            <?php
    } ?>
        </table>
    </body>

    </html>
