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
                    <?php echo $row->firstname? /*TODO: edit to proper name*/>
                </td>
                <td>
                    <?php echo $row->lastname? /*TODO: edit to proper name*/>
                </td>
                <td>
                    <?php echo $row->username? /*TODO: edit to proper name*/>
                </td>
                <td>
                    <?php echo $row->role? /*TODO: edit to proper name*/>
                </td>
            </tr>
            <?php
    } ?>
        </table>
        <a href="index.html">Ga terug naar de bestelpagina</a>
    </body>
</html>