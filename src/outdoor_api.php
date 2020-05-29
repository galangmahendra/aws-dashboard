<?php 
$url_api = "http://52.221.183.208/data";
$data = file_get_contents($url_api);
$dataview = json_decode($data, true);

foreach($dataview as $r) { ?>
    <tr>
        <td class="val-time"><?php echo $r['time'] ?></td>
        <td class="val-pm2"><?php echo $r['pm2'] ?></td>
        <td class="val-pm10"><?php echo $r['pm10'] ?></td>
        <td class="val-so2"><?php echo $r['so2'] ?></td>
        <td class="val-no2"><?php echo $r['no2'] ?></td>
        <td class="val-co"><?php echo $r['co'] ?></td>
        <td class="val-o3"><?php echo $r['o3'] ?></td>
        <td class="val-ispu"><?php echo $r['ispu'] ?></td>
        <td class="val-rem"><?php echo $r['rem'] ?></td>
        <td class="val-t"><?php echo $r['t'] ?></td>
        <td class="val-rh"><?php echo $r['rh'] ?></td>
        <td class="val-hc"><?php echo $r['hc'] ?></td>
    </tr>
<?php } ?>