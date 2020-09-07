<?php 
ini_set('default_socket_timeout', 900);
$url_api = "https://www.enygma.id/aws/iotdevice/klhk/7";
$data = file_get_contents($url_api);
$dataview = json_decode($data, true);

foreach($dataview['data'] as $r) { ?>
    <tr>
        <td class="val-time"><?php echo !empty($r['time']) ? $r['time'] : '-' ?></td>
        <td class="val-pm2"><?php echo !empty($r['PM-2.5']) ? $r['PM-2.5'] : '-' ?></td>
        <td class="val-pm10"><?php echo !empty($r['PM-10.0']) ? $r['PM-10.0'] : '-' ?></td>
        <td class="val-so2"><?php echo !empty($r['SO2']) ? $r['SO2'] : '-' ?></td>
        <td class="val-no2"><?php echo !empty($r['NO2']) ? $r['NO2'] : '-' ?></td>
        <td class="val-co"><?php echo !empty($r['CO']) ? $r['CO'] : '-' ?></td>
        <td class="val-o3"><?php echo !empty($r['O3']) ? $r['O3'] : '-' ?></td>
        <td class="val-hc"><?php echo !empty($r['VOC']) ? $r['VOC'] : '-' ?></td>
        <td class="val-t"><?php echo !empty($r['temperature']) ? $r['temperature'] : '-' ?></td>
        <td class="val-hum"><?php echo !empty($r['humidity']) ? $r['humidity'] : '-' ?></td>
        <td class="val-bp"><?php echo !empty($r['barometric-pressure']) ? $r['barometric-pressure'] : '-' ?></td>
        <td class="val-ws"><?php echo !empty($r['Wind Speed']) ? $r['Wind Speed'] : '-' ?></td>
        <td class="val-ri"><?php echo !empty($r['Rain Volume mm']) ? $r['Rain Volume mm'] : '-' ?></td>
    </tr>
<?php } ?>