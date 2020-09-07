<?php 
$url_api = "https://www.enygma.id/aws/iotdevice/data/3";
$data = file_get_contents($url_api);
$dataview = json_decode($data, true);

foreach($dataview['data'] as $r) { ?>
    <tr>
        <td class="val-time"><?php echo $r['time'] ?></td>
        <td class="val-i-pm1"><?php echo $r['PM-1.0'] ?></td>
        <td class="val-i-pm2"><?php echo $r['PM-2.5'] ?></td>
        <td class="val-i-pm10"><?php echo $r['PM-10.0'] ?></td>
        <td class="val-i-temp"><?php echo $r['temperature'] ?></td>
        <td class="val-i-hum"><?php echo $r['humidity'] ?></td>
        <td class="val-i-bp"><?php echo $r['barometric-pressure'] ?></td>
        <td class="val-i-tvoc"><?php echo $r['tVOC-gas-CCS811'] ?></td>
        <td class="val-i-eco2"><?php echo $r['eCO2-gas-CCS811'] ?></td>
    </tr>
<?php } ?>