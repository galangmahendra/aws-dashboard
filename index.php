<?php
session_start();
if(empty($_SESSION["nickname"])) {
  header("Location: login");
}
$nickname = $_SESSION["nickname"];
include('src/data.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/png" href="assets/favicon.ico">
  <title>Enygma AWS</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.staticfile.org/datepicker/0.6.5/datepicker.min.css">
  <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/5.7.2/css/all.min.css">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body onload="$('.dataview-0000000250').click()">
  <div id="map-container"></div>
  <nav class="navbar navbar-expand-lg navbar-light bg-light header--fixed" data-headroom>
  <img src="assets/logo.png" alt="Enygma" height="30" style="margin:15px 30px 15px 0">
    <h1 class="navbar-brand d-none d-sm-block">Data Acquisition System Station</h1>
    <button class=navbar-toggler type=button data-toggle=collapse data-target=#navbarNavDropdown>
      <span class=navbar-toggler-icon></span>
    </button>
    <div class="collapse navbar-collapse" id=navbarNavDropdown>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item px-2 active">
          <a class=nav-link href="index"> <i class="far fa-chart-bar fa-fw"></i>Data</a>
        </li>
        <li class="nav-item dropdown px-2">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
            <i class="fa fa-user fa-fw"></i><span id=label-usernick><?php echo $nickname ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class=dropdown-item href="#" data-toggle=modal data-target=#alter-usernick>
              <i class="fas fa-wrench fa-fw"></i>Change username</a>
            <a class=dropdown-item href="#" data-toggle=modal data-target=#alter-password>
              <i class="fas fa-eraser fa-fw"></i>Change password</a>
            <a class=dropdown-item href="auth/logout"> <i class="fas fa-sign-out-alt fa-fw"></i>Sign out</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <div class="modal fade modal-form" id=alter-usernick tabindex=-1>
    <div class=modal-dialog>
      <div class=modal-content>
        <div class=modal-header>
          <div class=modal-title>
            <h5>Account settings</h5>
          </div>
          <button type=button class=close data-dismiss=modal>
            <span>&times;</span>
          </button>
        </div>
        <form>
          <div class=modal-body>
            <div class="form-group form-row">
              <div class=col>
                <label for=userid>User ID</label>
                <input type=text readonly=readonly class="form-control form-control-plaintext" id=userid
                  value=99e16d48-2daa-41ad-b4d3-e9ce678750c0>
              </div>
            </div>
            <div class="form-group form-row">
              <div class=col>
                <label for=nickname>Nickname</label>
                <input type=text class=form-control id=nickname name=user[usernick]>
              </div>
            </div>
          </div>
          <div class=modal-footer>
            <i class="fas fa-circle-notch fa-spin loading"></i>
            <button type=button class="btn btn-secondary" data-dismiss=modal>Close</button>
            <button type=submit class="btn btn-primary">OK</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade modal-form" id=alter-password tabindex=-1>
    <div class=modal-dialog>
      <div class=modal-content>
        <div class=modal-header>
          <h5 class=modal-title>Change password</h5>
          <button type=button class=close data-dismiss=modal>
            <span>&times;</span>
          </button>
        </div>
        <form>
          <div class=modal-body>
            <div class="form-group form-row">
              <div class=col>
                <label for=pass-old>Old password</label>
                <input type=password class=form-control id=pass-old name=user[passwordOld]>
              </div>
            </div>
            <div class="form-group form-row">
              <div class=col>
                <label for=pass-new>New password</label>
                <input type=password class=form-control id=pass-new name=user[password]>
              </div>
            </div>
            <div class="form-group form-row">
              <div class=col>
                <label for=pass-new2>Confirm new password</label>
                <input type=password class=form-control id=pass-new2 name=user[password2]>
              </div>
            </div>
          </div>
          <div class=modal-footer>
            <i class="fas fa-circle-notch fa-spin loading"></i>
            <button type=button class="btn btn-secondary" data-dismiss=modal>Close</button>
            <button type=submit class="btn btn-primary">OK</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <main class="container page-data up">
    <div class="row pagetitle">
      <div class="col-12 col-xl-4" style="background-color:#ed3237d1">
        <div class=container>
          <div class="row justify-content-between">
            <div class=col>
              <h2 class=display-5>Data Acquisition</h2>
            </div>
            <div class="col align-self-end">
              <p class="explain text-left">Equipment quantity: <span id=equipment-count><?php echo count($data) ?></span>
              </p>
            </div>
          </div>
          <div class=row>
            <div class=col>
              <p style="color:#fff">View real-time data, historical data, geographic location, and more for all devices, or selectively
                export historical data.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-xl-8">
        <div class="showhide-data" onclick="showHide()"><i class="fa fa-2x fa-chevron-down"></i></div>
        <div style="background-color:#ffffffd1;padding:10px 5px;border-radius:.3rem;margin-right:-15px">
          <table width="100%" border="0">
            <tbody>
              <tr class="data-outdoor">
                <td class="text-center" width="16.6%">
                  <h1 class="data-val-outdoor">-</h1>
                  <small class="text-param">PM2.5 (ug/m3)</small>
                </td>
                <td class="text-center" width="16.6%">
                  <h1 class="data-val-outdoor">-</h1>
                  <small class="text-param">PM10 (ug/m3)</small>
                </td>
                <td class="text-center" width="16.6%">
                  <h1 class="data-val-outdoor">-</h1>
                  <small class="text-param">SO2 (ug/m3)</small>
                </td>
                <td class="text-center" width="16.6%">
                  <h1 class="data-val-outdoor">-</h1>
                  <small class="text-param">NO2 (ug/m3)</small>
                </td>
                <td class="text-center" width="16.6%">
                  <h1 class="data-val-outdoor">-</h1>
                  <small class="text-param">CO (ug/m3)</small>
                </td>
                <td class="text-center" width="16.6%">
                  <h1 class="data-val-outdoor">-</h1>
                  <small class="text-param">O3 (ug/m3)</small>
                </td>
              </tr>
              <tr class="data-outdoor">
                <td class="text-center" width="16.6%">
                  <h1 class="data-val-outdoor">-</h1>
                  <small class="text-param">HC (ug/m3)</small>
                </td>
                <td class="text-center" width="16.6%">
                  <h1 class="data-val-outdoor">-</h1>
                  <small class="text-param">Temp (℃)</small>
                </td>
                <td class="text-center" width="16.6%">
                  <h1 class="data-val-outdoor">-</h1>
                  <small class="text-param">Humidiy %</small>
                </td>
                <td class="text-center" width="16.6%">
                  <h1 class="data-val-indoor">-</h1>
                  <small class="text-param">BaroPress (kPa)</small>
                </td>
                <td class="text-center" width="16.6%">
                  <h1 class="data-val-outdoor">-</h1>
                  <small class="text-param">WindSpeed (m/s)</small>
                </td>
                <td class="text-center" width="16.6%">
                  <h1 class="data-val-outdoor">-</h1>
                  <small class="text-param">RainIntensity (mm)</small>
                </td>
                <td class="text-center" width="16.6%">
                  <h1 class=""></h1>
                  <small class="text-param"></small>
                </td>
              </tr>
              <tr class="data-indoor hide">
                <td class="text-center" width="15%">
                  <h1 class="data-val-indoor">-</h1>
                  <small class="text-param">PM 1.0 (ug/m3)</small>
                </td>
                <td class="text-center" width="15%">
                  <h1 class="data-val-indoor">-</h1>
                  <small class="text-param">PM 2.5 (ug/m3)</small>
                </td>
                <td class="text-center" width="15%">
                  <h1 class="data-val-indoor">-</h1>
                  <small class="text-param">PM 10.0 (ug/m3)</small>
                </td>
                <td class="text-center" width="15%">
                  <h1 class="data-val-indoor">-</h1>
                  <small class="text-param">Temp (℃)</small>
                </td>
              </tr>
              <tr class="data-indoor hide">
                <td class="text-center" width="15%">
                  <h1 class="data-val-indoor">-</h1>
                  <small class="text-param">Hum (%)</small>
                </td>
                <td class="text-center" width="15%">
                  <h1 class="data-val-indoor">-</h1>
                  <small class="text-param">BaroPress (kPa)</small>
                </td>
                <td class="text-center" width="15%">
                  <h1 class="data-val-indoor">-</h1>
                  <small class="text-param">tVOC (ppb)</small>
                </td>
                <td class="text-center" width="15%">
                  <h1 class="data-val-indoor">-</h1>
                  <small class="text-param">eCO2 (ppm)</small>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row data" style="background-color:#ffffffd1">
      <div class=col>
        <div class=container>
          <div class="d-none d-lg-block table-title">
            <div class="row data-title">
              <div class="col-lg-1 col-sm-6">ID</div>
              <div class="col-lg-3 col-sm-6">Equipment name</div>
              <div class="col-lg-2 col-sm-6">Time zone</div>
              <div class="col-lg-1 col-sm-6">State</div>
              <div class="col-lg-5 col-sm-12 text-center">Operating</div>
            </div>
          </div>

          <?php foreach($data as $d) { ?>
            <div class="row"> 
              <div class="col-lg-1 col-sm-6 eid"><?php echo $d['id'] ?></div>
              <div class="col-lg-3 col-sm-6 name"><?php echo $d['name'] ?></div>
              <div class="col-lg-2 col-sm-6 timezone"><?php echo $d['timezone'] ?></div>
              <?php if($d['state']=='Online') $type = 'success'; 
              elseif($d['state']=='Commisioning') $type = 'warning'; 
              else $type = 'muted'; ?>
              <div class="col-lg-1 col-sm-6 text-<?php echo $type; ?> status"><?php echo $d['state'] ?></div>
              <div class="col-lg-5 col-sm-12 text-right">
                <button class="btn btn-warning show-dataview dataview-<?php echo $d['id'] ?>" <?php echo $d['btn-state'] ?> data-toggle="modal" data-target="#dataview" onclick="setData('<?php echo $d['name'] ?>','<?php echo $d['lat'] ?>','<?php echo $d['lon'] ?>','<?php echo $d['scope'] ?>')">
                  <i class="far fa-chart-bar fa-fw"></i>Data View
                </button>
                <a href="#" class="btn btn-info" data-toggle=modal data-target=#datadownload>
                  <i class="fas fa-download fa-fw"></i>Export Data</a>
              </div>
            </div>
          <?php } ?>

        </div>
      </div>
    </div>
  </main>

  <div class="modal fade" id="dataview">
    <div class="modal-dialog modal-xl" style="min-width:1320px">
      <div class="modal-content scroll-out">
        <div class="modal-header">
          <div class="modal-title">
            <h5>Data View</h5>
            <p class="modal-equipment-name">Equipment name: <span class="equipment-name"></span></p>
            <button class="btn btn-outline-secondary btn-datalist active" type="button" onclick="unsetChart()">Data List</button>
            <div class="dropdown d-inline data-outdoor">
              <button class="btn btn-outline-secondary btn-datachart dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                Data Chart
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="setChart('PM2.5 (ug/m3)','pm2')">PM2.5 (ug/m3)</a>
                <a class="dropdown-item" href="#" onclick="setChart('PM10 (ug/m3)','pm10')">PM10 (ug/m3)</a>
                <a class="dropdown-item" href="#" onclick="setChart('SO2 (ug/m3)','so2')">SO2 (ug/m3)</a>
                <a class="dropdown-item" href="#" onclick="setChart('NO2 (ug/m3)','no2')">NO2 (ug/m3)</a>
                <a class="dropdown-item" href="#" onclick="setChart('CO (ug/m3)','co')">CO (ug/m3)</a>
                <a class="dropdown-item" href="#" onclick="setChart('O3 (ug/m3)','o3')">O3 (ug/m3)</a>
                <a class="dropdown-item" href="#" onclick="setChart('HC (ug/m3)','hc')">HC (ug/m3)</a>
                <a class="dropdown-item" href="#" onclick="setChart('Temp (℃)','t')">T (℃)</a>
                <a class="dropdown-item" href="#" onclick="setChart('Humidity (%)','hum')">H (%)</a>
                <a class="dropdown-item" href="#" onclick="setChart('Barometric Pressure (kPa)','bp')">BaroPress (kPa)</a>
                <a class="dropdown-item" href="#" onclick="setChart('Wind Speed (m/s)','ws')">WindSpeed (m/s)</a>
                <a class="dropdown-item" href="#" onclick="setChart('Rain Intensity (mm)','ri')">RainInt (mm)</a>
              </div>
            </div>
            <div class="dropdown d-inline data-indoor hide">
              <button class="btn btn-outline-secondary btn-datachart dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                Data Chart
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="setChart('PM 1.0 (ug/m3)','i-pm1')">PM 1.0 (ug/m3)</a>
                <a class="dropdown-item" href="#" onclick="setChart('PM 2.5 (ug/m3)','i-pm2')">PM 2.5 (ug/m3)</a>
                <a class="dropdown-item" href="#" onclick="setChart('PM 10.0 (ug/m3)','i-pm10')">PM 10.0 (ug/m3)</a>
                <a class="dropdown-item" href="#" onclick="setChart('Temperature (℃)','i-temp')">Temp (℃)</a>
                <a class="dropdown-item" href="#" onclick="setChart('Humidity (%)','i-hum')">Hum (%)</a>
                <a class="dropdown-item" href="#" onclick="setChart('Barometric Pressure (kPa)','i-bp')">BaroPress (kPa)</a>
                <a class="dropdown-item" href="#" onclick="setChart('tVOC gas CCS811 (ppb)','i-tvoc')">tVOC (ppb)</a>
                <a class="dropdown-item" href="#" onclick="setChart('eCO2 gas CCS811 (ppm)','i-eco2')">eCO2 (ppm)</a>
              </div>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body scroll-wrap text-center dataview-container">
          <div id="dataview-chart" style="height:400px;min-width:400px;display:none"></div>
          <table class="table big-table mr-20 dataview-list dtable">
            <thead class="thead-dark">
              <tr class="data-outdoor">
                <th class="time"><small>Time</small></th>
                <th class="c1"><small>PM2.5(ug/m3)</small></th>
                <th class="c2"><small>PM10(ug/m3)</small></th>
                <th class="c3"><small>SO2(ug/m3)</small></th>
                <th class="c4"><small>NO2(ug/m3)</small></th>
                <th class="c5"><small>CO(ug/m3)</small></th>
                <th class="c6"><small>O3(ug/m3)</small></th>
                <th class="c7"><small>HC(ug/m3)</small></th>
                <th class="c8"><small>T(℃)</small></th>
                <th class="c9"><small>Hum(%)</small></th>
                <th class="c10"><small>BaroPress (kPa)</small></th>
                <th class="c11"><small>WindSpeed(m/s)</small></th>
                <th class="c12"><small>RainIntensity(mm)</small></th>
              </tr>
              <!-- <tr class="data-indoor hide">
                <th class="time"><small>Time</small></th>
                <th class="c1"><small>PM 1.0 (ug/m3)</small></th>
                <th class="c2"><small>PM 2.5 (ug/m3)</small></th>
                <th class="c3"><small>PM 10.0 (ug/m3)</small></th>
                <th class="c4"><small>Temp (℃)</small></th>
                <th class="c5"><small>Hum (%)</small></th>
                <th class="c6"><small>BaroPress (kPa)</small></th>
                <th class="c7"><small>tVOC (ppb)</small></th>
                <th class="c8"><small>eCO2 (ppm)</small></th>
              </tr> -->
            </thead>
            <tbody class="table-striped table-hover data-body">
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade modal-form show" id="datadownload">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title">
            <h5>Export Data</h5>
          </div>
          <button type="button" class="close" data-dismiss="modal">
            <span>×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group form-row">
            <div class="col">
              <label for="download-start">Start Date</label>
              <input type="text" class="form-control start-date" id="download-start" value="<?php echo date('Y-m-d') ?>">
            </div>
          </div>
          <div class="form-group form-row">
            <div class="col">
              <label for="download-end">End Date</label>
              <input type="text" class="form-control end-date" id="download-end" value="<?php echo date('Y-m-d') ?>">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-ok" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.staticfile.org/datepicker/0.6.5/datepicker.min.js"></script>
  <script src="https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts.min.js"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu9-9wDg-qNZJ1pyhIMzF306E6roCoKMw&callback=initMap"></script>
  <script src="assets/main.js"></script>
  
</body>
</html>