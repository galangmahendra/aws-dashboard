<?php
session_start();
if(empty($_SESSION["nickname"])) {
  header("Location: login");
}
$nickname = $_SESSION["nickname"];
include('data.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/png" href="assets/favicon.ico">
  <title>Enygma DMS</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.staticfile.org/datepicker/0.6.5/datepicker.min.css">
  <link rel=stylesheet href=https://cdn.staticfile.org/font-awesome/5.7.2/css/all.min.css>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div id="map-container"></div>
  <nav class="navbar navbar-expand-lg navbar-light bg-light header--fixed" data-headroom>
    <img src="assets/logo.png" alt="" height="30" style="margin:15px 30px 15px 0">
    <h1 class="navbar-brand d-none d-sm-block">DATA MANAGEMENT SYSTEM</h1>
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
            <a class=dropdown-item href="logout"> <i class="fas fa-sign-out-alt fa-fw"></i>Sign out</a>
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
              <h2 class=display-5>Data Management</h2>
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
              <tr>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val ">-</h1>
                  <small class="text-param">PM2.5(ug/m3)</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val ">-</h1>
                  <small class="text-param">PM10(ug/m3)</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val ">-</h1>
                  <small class="text-param">SO2(PPB)</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val ">-</h1>
                  <small class="text-param">NO2(PPB)</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val ">-</h1>
                  <small class="text-param">CO(PPM)</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val ">-</h1>
                  <small class="text-param">O3(PPB)</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val ">-</h1>
                  <small class="text-param">ISPU</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val ">-</h1>
                  <small class="text-param">Rem</small>
                </td>
              </tr>
              <tr>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val">-</h1>
                  <small class="text-param">temp(℃)</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val">-</h1>
                  <small class="text-param">RH(%)</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val">-</h1>
                  <small class="text-param">NOISE(dB)</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val">-</h1>
                  <small class="text-param">ATM(kPa)</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val">-</h1>
                  <small class="text-param">WS(m/s)</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val">-</h1>
                  <small class="text-param">WD(°)</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class="data-val">-</h1>
                  <small class="text-param">PRCP(mm)</small>
                </td>
                <td class="text-center" width="12.5%">
                  <h1 class=""></h1>
                  <small class="text-param"></small>
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
                <a href="#" class="btn btn-warning show-dataview" data-toggle="modal" data-target="#dataview" onclick="setData('<?php echo $d['name'] ?>','<?php echo $d['lat'] ?>','<?php echo $d['lon'] ?>')">
                  <i class="far fa-chart-bar fa-fw"></i>Data View
                </a>
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
    <div class="modal-dialog modal-xl">
      <div class="modal-content scroll-out">
        <div class="modal-header">
          <div class="modal-title">
            <h5>Data View</h5>
            <p class="modal-equipment-name">Equipment name: <span class="equipment-name"></span></p>
            <button class="btn btn-outline-secondary btn-datalist active" type="button" onclick="unsetChart()">Data List</button>
            <div class="dropdown d-inline">
              <button class="btn btn-outline-secondary btn-datachart dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                Data Chart
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="setChart('PM2.5(ug/m3)','pm2')">PM2.5(ug/m3)</a>
                <a class="dropdown-item" href="#" onclick="setChart('PM10(ug/m3)','pm10')">PM10(ug/m3)</a>
                <a class="dropdown-item" href="#" onclick="setChart('SO2(PPB)','so2')">SO2(PPB)</a>
                <a class="dropdown-item" href="#" onclick="setChart('NO2(PPB)','no2')">NO2(PPB)</a>
                <a class="dropdown-item" href="#" onclick="setChart('CO(PPM)','co')">CO(PPM)</a>
                <a class="dropdown-item" href="#" onclick="setChart('O3(PPB)','o3')">O3(PPB)</a>
                <a class="dropdown-item" href="#" onclick="setChart('ISPU','ispu')">ISPU</a>
                <!-- <a class="dropdown-item" href="#">Rem</a> -->
                <a class="dropdown-item" href="#" onclick="setChart('T(℃)','t')">T(℃)</a>
                <a class="dropdown-item" href="#" onclick="setChart('RH(%)','rh')">RH(%)</a>
                <a class="dropdown-item" href="#" onclick="setChart('NOISE(dB)','noise')">NOISE(dB)</a>
                <a class="dropdown-item" href="#" onclick="setChart('ATM(kPa)','atm')">ATM(kPa)</a>
                <!-- <a class="dropdown-item" href="#">WS(m/s)</a>
                <a class="dropdown-item" href="#">WD(°)</a>
                <a class="dropdown-item" href="#">PRCP(mm)</a> -->
              </div>
            </div>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body scroll-wrap text-center dataview-container">
          <div id="dataview-chart" style="height:400px;min-width:400px;display:none"></div>
          <table class="table big-table mr-20 dataview-list">
            <thead class="thead-dark">
              <tr>
                <th scope="col" class="time">Time</th>
                <th scope="col" class="c1">PM2.5(ug/m3)</th>
                <th scope="col" class="c2">PM10(ug/m3)</th>
                <th scope="col" class="c3">SO2(PPB)</th>
                <th scope="col" class="c4">NO2(PPB)</th>
                <th scope="col" class="c5">CO(PPM)</th>
                <th scope="col" class="c6">O3(PPB)</th>
                <th scope="col" class="c7">ISPU</th>
                <th scope="col" class="c8">Rem</th>
                <th scope="col" class="c9">T(℃)</th>
                <th scope="col" class="c10">RH(%)</th>
                <th scope="col" class="c11">NOISE(dB)</th>
                <th scope="col" class="c12">ATM(kPa)</th>
                <th scope="col" class="c13">WS(m/s)</th>
                <th scope="col" class="c14">WD(°)</th>
                <th scope="col" class="c15">PRCP(mm)</th>
              </tr>
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
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.staticfile.org/datepicker/0.6.5/datepicker.min.js"></script>
  <script src="https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts.min.js"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu9-9wDg-qNZJ1pyhIMzF306E6roCoKMw&callback=initMap"></script>
  <script src="assets/main.js"></script>
  
</body>
</html>