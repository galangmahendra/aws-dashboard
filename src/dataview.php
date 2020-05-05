<?php 
date_default_timezone_set('Asia/Jakarta');
$temp = 32; // start value / latest value
$temp_interval = [-0.3,-0.2,-0.1,0,0.1];
$noise = 44; // start value / latest value
$noise_interval = [-1,0,1];

$dataview_total = 50;
$date = date("Y-m-d H:i:s", strtotime("-5 minutes"));
for( $i = 1; $i <= $dataview_total; $i++ ) {
    $date = date("Y-m-d H:i:s", strtotime($date) - 30);
    $temp = sequence($temp,$temp_interval);
    $noise = sequence($noise,$noise_interval);
    $dataview[] = array(
        'time' => $date,
        'pm2' => rand(4,27),
        'pm10' => rand(4,28),
        'so2' => rand(8,22),
        'no2' => rand(19,34),
        'co' => '0.'.rand(730,975),
        'o3' => rand(19,31),
        'ispu' => rand(19,31),
        'rem' => 'Baik',
        't' => $temp,
        'rh' => rand(43,62).'.'.rand(1,10),
        'noise' => $noise,
        'atm' => rand(100,101).'.'.rand(3,9),
        'ws' => 0,
        'wd' => 'NW',
        'prcp' => '0.0',
    );
}

function sequence($num,$interval) { // for sequential intervals
    $count = count($interval) - 1;
    $index = rand(0,$count);
    $number = $num + $interval[$index];
    return $number;
}

foreach($dataview as $r) { ?>
    <tr>
        <td class="val-time"><?php echo $r['time'] ?></td>
        <td class="val-pm10"><?php echo $r['pm10'] ?></td>
        <td class="val-pm2"><?php echo $r['pm2'] ?></td>
        <td class="val-so2"><?php echo $r['so2'] ?></td>
        <td class="val-no2"><?php echo $r['no2'] ?></td>
        <td class="val-co"><?php echo $r['co'] ?></td>
        <td class="val-o3"><?php echo $r['o3'] ?></td>
        <td class="val-ispu"><?php echo $r['ispu'] ?></td>
        <td class="val-rem"><?php echo $r['rem'] ?></td>
        <td class="val-t"><?php echo $r['t'] ?></td>
        <td class="val-rh"><?php echo $r['rh'] ?></td>
        <td class="val-noise"><?php echo $r['noise'] ?></td>
        <td class="val-atm"><?php echo $r['atm'] ?></td>
        <td>0</td>
        <td>NW</td>
        <td>0.0</td>
    </tr>
<?php } ?>