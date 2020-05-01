<?php 
date_default_timezone_set('Asia/Jakarta');
$temp = 27; // start value
$noise = 44; // start value

$date = date("Y-m-d H:i:s", strtotime("-5 minutes"));
$dataview_total = 50;
for( $i = 1; $i <= $dataview_total; $i++ ) {
    
    $date = date("Y-m-d H:i:s", strtotime($date) - 30);
    $temp = sequence($temp);
    $noise = sequence($noise);

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

function sequence($num) { // for sequential intervals
    $x = [-0.1,0,0.1,0.2];
    $index = rand(0,3);
    $number = $num + $x[$index];
    return $number;
}

foreach($dataview as $r) { ?>
    <tr>
        <td><?php echo $r['time'] ?></td>
        <td><?php echo $r['pm2'] ?></td>
        <td><?php echo $r['pm10'] ?></td>
        <td><?php echo $r['so2'] ?></td>
        <td><?php echo $r['no2'] ?></td>
        <td><?php echo $r['co'] ?></td>
        <td><?php echo $r['o3'] ?></td>
        <td><?php echo $r['ispu'] ?></td>
        <td><?php echo $r['rem'] ?></td>
        <td><?php echo $r['t'] ?></td>
        <td><?php echo $r['rh'] ?></td>
        <td><?php echo $r['noise'] ?></td>
        <td><?php echo $r['atm'] ?></td>
        <td>0</td>
        <td>NW</td>
        <td>0.0</td>
    </tr>
<?php } ?>