<DOCTYPE html>
    <html>

    <head>
        <title>
            User overview
        </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="styling/style-login.css">
    </head>

    <body>
        <table>
            <tr>
                <th class="headerUserTable" colspan="6">Gebruikersoverzicht 
                </th>
            </tr>
            <tr>
                <th>GEBRUIKERSNAAM</th>
                <th>VOORNAAM</th>
                <th>ACHTERNAAM</th>
                <th>ROL</th>
                <th></th>
                <th></th>
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
                    <?php echo $row->userName?>
                </td>
                <td>
                    <?php echo $row->firstName?>
                </td>
                <td>
                    <?php echo $row->lastName?>
                </td>
                <td>
                    <?php echo $row->role?>
                </td>
                <td>
                    <i class="fa fa-pencil"></i>
                </td>
                <td>
                    <i class="fa fa-trash"></i>
                </td>
            </tr>
            <?php
    } ?>
        </table>
    </body>

    </html>
