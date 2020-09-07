<?php 
$url_api = "https://www.enygma.id/aws/iotdevice/klhk/7";
$data = file_get_contents($url_api);
$dataview = json_decode($data, true);

foreach($dataview['data'] as $r) { ?>
    <tr>
        <td class="val-time"><?php echo $r['time'] ?></td>
        <td class="val-pm2"><?php echo $r['PM-2.5'] ?></td>
        <td class="val-i-pm10"><?php echo $r['PM-10.0'] ?></td>
        <td class="val-so2"><?php echo $r['SO2'] ?></td>
        <td class="val-no2"><?php echo $r['NO2'] ?></td>
        <td class="val-co"><?php echo $r['CO'] ?></td>
        <td class="val-o3"><?php echo $r['O3'] ?></td>
        <td class="val-hc"><?php echo $r['VOC'] ?></td>
        <td class="val-t"><?php echo $r['temperature'] ?></td>
        <td class="val-hum"><?php echo $r['humidity'] ?></td>
        <td class="val-ws"><?php echo !empty($r['Wind Speed']) ? $r['Wind Speed'] : '-' ?></td>
        <td class="val-ri"><?php echo !empty($r['Rain Volume mm']) ? $r['Rain Volume mm'] : '-' ?></td>
    </tr>
<?php } ?>