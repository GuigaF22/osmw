<?php 
if (isset($_SESSION['authentification']))
{
    echo '<p class="pull-right"><span class="label label-danger">Espace Securise Niveau '.$_SESSION['privilege'].'</span></p>';
    echo '<h1>Gestion des Sauvegardes</h1>';
    echo '<div class="clearfix"></div>';

    if (isset($_POST['OSSelect'])) {$_SESSION['opensim_select'] = trim($_POST['OSSelect']);}

    echo '<p>Simulateur selectionne ';
    echo '<strong class="label label-info">'.$_SESSION['opensim_select'].' '.INI_Conf_Moteur($_SESSION['opensim_select'], "version").'</strong>';
    echo '</p>';

    if ($_SESSION['osAutorise'] != '')
    {
        $osAutorise = explode(";", $_SESSION['osAutorise']);
        for($i = 0; $i < count($osAutorise); $i++)
        {
            if (INI_Conf_Moteur($_SESSION['opensim_select'], "osAutorise") == $osAutorise[$i]) {$moteursOK = true;}
        }
    }
    else {$moteursOK = false;}

    $btnN1 = "disabled"; $btnN2 = "disabled"; $btnN3 = "disabled";
    if ($_SESSION['privilege'] == 4) {$btnN1 = ""; $btnN2 = ""; $btnN3 = "";}   // Niv 4	
    if ($_SESSION['privilege'] == 3) {$btnN1 = ""; $btnN2 = ""; $btnN3 = "";}   // Niv 3
    if ($_SESSION['privilege'] == 2) {$btnN1 = ""; $btnN2 = "";}                // Niv 2
    // if ($_SESSION['privilege'] == 1) {$btnN1 = "";}                          // Niv 1
    if ($moteursOK == true) {if( $_SESSION['privilege'] == 1) {$btnN1 = ""; $btnN2 = ""; $btnN3 = "";}}

    if (isset($_POST['cmd']))
    {
        $filename2 = INI_Conf_Moteur($_SESSION['opensim_select'], "address").$FichierINIOpensim;			 
        if (file_exists($filename2)) {$filename = $filename2;}
        else {;}

        if (!$fp = fopen($filename, "r")) 
        {
            echo "Echec de l'ouverture du fichier ".$filename;
        }

        $tabfich = file($filename); 
        $n = count($tabfich);

        for($i = 1; $i < $n; $i++)
        {
            if (strpos($tabfich[$i], ";") === false)
            {
                $porthttp = strstr($tabfich[$i], "port");
                $access_password = strstr($tabfich[$i], "access_password");

                if (!empty($porthttp))
                {
                    $posEgal = strpos($porthttp, '=');
                    $longueur = strlen($porthttp);
                    $RemotePort = substr($porthttp, $posEgal + 1);
                }

                if (!empty($access_password))
                {
                    $posEgal = strpos($access_password, '=');
                    $longueur = strlen($access_password);
                    $access_password2 = trim(substr($access_password, $posEgal + 1));
                    // $longueur2 = strlen($access_password2);
                    // $Remote_access_password = substr($access_password2, 1,$longueur2-2 );			
                }
            }
        }
        fclose($fp);

        // $myRemoteAdmin = new RemoteAdmin(trim($hostnameSSH), trim($RemotePort), trim($Remote_access_password));
        $myRemoteAdmin = new RemoteAdmin(trim($hostnameSSH), trim($RemotePort), trim($access_password2));

        if ($_POST['backup_sim'] == '1' && $_POST['format_backup'] == 'OAR')
        {
            $parameters = array(
                'region_name' => $_POST['name_sim'], 
                'filename' => 'BackupOAR_'.$_POST['name_sim'].'_'.date(d_m_Y_h).'.oar'
            );
            $myRemoteAdmin->SendCommand('admin_save_oar', $parameters);
        }

        echo '<div class="alert alert-success alert-anim">';
        echo '<i class="glyphicon glyphicon-ok"></i>';
        echo ' Fichier en cours de creation, veuillez consulter le <strong>Log</strong> ...';
        echo '</div>';
    }

    $sql = 'SELECT * FROM moteurs';
    $req = mysqli_query($db, $sql) or die('Erreur SQL !<p>'.$sql.'</p>'.mysqli_error($db));

    // echo '<h4>Selectionner un Simulateur</h4>';
    echo '<form class="form-group" method="post" action="">';
    echo '<div class="form-inline">';
    echo '<label for="OSSelect"></label>Select Simulator ';
    echo '<select class="form-control" name="OSSelect">';

    while($data = mysqli_fetch_assoc($req))
    {
        // if ($data['osAutorise'] != '') {echo $data['osAutorise'];}
        // else {$osAutorise = explode(";", $data['osAutorise']); echo count($osAutorise);}
        $sel = "";
        if ($data['id_os'] == $_SESSION['opensim_select']) {$sel = "selected";}
        echo '<option value="'.$data['id_os'].'" '.$sel.'>'.$data['name'].' '.$data['version'].'</option>';
    }

    echo'</select>';
    echo' <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i> Choisir</button>';
    echo '</div>';
    echo'</form>';
    mysqli_close($db);

    $filename2 = INI_Conf_Moteur($_SESSION['opensim_select'], "address")."Regions/".$FichierINIRegions;
    if (file_exists($filename2)) {$filename = $filename2 ;}
    else {;}

    $tableauIni = parse_ini_file($filename, true);
    if ($tableauIni == FALSE){echo '<p class="alert alert-danger">Proleme de lecture du fichier .ini <strong>$filename</strong></p>';}

    $filename2 = INI_Conf_Moteur($_SESSION['opensim_select'], "address").$FichierINIOpensim;		
    if (file_exists($filename2)) {$filename = $filename2 ;}
    else {;}

    if (!$fp = fopen($filename, "r")) 
    {
        echo "<p class='alert alert-danger'>Echec de l'ouverture du fichier .ini <strong>$filename</strong></p>";
    }

    $tabfich = file($filename); 
    $n = count($tabfich);
    $srvOS = 9000;

    for($i = 1; $i < $n; $i++)
    {
        if (strpos($tabfich[$i], ";") === false)
        {
            $porthttp = strstr($tabfich[$i], "http_listener_port");

            if (!empty($porthttp))
            {
                $posEgal = strpos($porthttp, '=');
                $longueur = strlen($porthttp);
                $srvOS = substr($porthttp, $posEgal + 1);
            }
        }
    }
    fclose($fp);

    echo '<p>Nombre total de regions <span class="badge">'.count($tableauIni).'</span></p>';
    echo '<table class="table table-hover">';
    echo '<tr>';
    echo '<th>Name</th>';
    echo '<th>Image</th>';
    echo '<th>Uuid</th>';
    echo '<th>Location</th>';
    echo '<th>Public IP/Host</th>';
    echo '<th>Private IP/Host</th>';
    echo '<th>Port</th>';
    echo '<th>Action</th>';
    echo '</tr>';

    foreach($tableauIni as $key => $value)
    {
        $uuid = str_replace("-", "", $tableauIni[$key]['RegionUUID']);
        $ImgMap = "http://".$hostnameSSH.":".trim($srvOS)."/index.php?method=regionImage".$uuid;
        if (Test_Url($ImgMap) == false) {$ImgMap = "img/offline.jpg";}

        echo '<tr>';
        echo '<td><h5>'.$key.'</h5></td>';
        echo '<td><a href="index.php?a=21"><img  style="height: 38px;" class="img-thumbnail" alt="" src="'.$ImgMap.'"></a></td>';
        echo '<td><h5><span class="badge">'.$tableauIni[$key]['RegionUUID'].'</span></h5></td>';
        echo '<td><h5><span class="badge">'.$tableauIni[$key]['Location'].'</span></h5></td>';
        echo '<td><h5>'.$tableauIni[$key]['ExternalHostName'].'</h5></td>';
        echo "<td><h5><span class='badge'>".$tableauIni[$key]['InternalAddress']."</span></h5></td>";
        echo '<td><h5><span class="badge">'.$tableauIni[$key]['InternalPort'].'</span></h5></td>';

        echo '<td>';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="backup_sim" value="1" >';
        echo '<input type="hidden" name="format_backup" value="OAR" >';
        echo '<input type="hidden" name="name_sim" value="'.$key.'">';
        echo '<button type="submit" name="cmd" class="btn btn-success" value="Save OAR" '.$btnN2.'>';
        echo '<i class="glyphicon glyphicon-save"></i> Save OAR';
        echo '</button>';

        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';	
}
else {header('Location: index.php');}
?>
