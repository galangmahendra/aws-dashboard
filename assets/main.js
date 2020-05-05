
var map;
var default_data = '<tr><td class="time">0000-00-00 00:00:00</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'
        + '<tr><td class="time">0000-00-00 00:00:00</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'
        + '<tr><td class="time">0000-00-00 00:00:00</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'
        + '<tr><td class="time">0000-00-00 00:00:00</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'
        + '<tr><td class="time">0000-00-00 00:00:00</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'
        + '<tr><td class="time">0000-00-00 00:00:00</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'
        + '<tr><td class="time">0000-00-00 00:00:00</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'
        + '<tr><td class="time">0000-00-00 00:00:00</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'
        + '<tr><td class="time">0000-00-00 00:00:00</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'
        + '<tr><td class="time">0000-00-00 00:00:00</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>'

$(document).ready(function() {
    $('.datatable').DataTable();
    $('.start-date,.end-date').datepicker({
        format: 'yyyy-mm-dd',
        autoHide: true
    });
});

function initMap() {
    map = new google.maps.Map(
    document.getElementById('map-container'),{
    center: new google.maps.LatLng(-7.9463549, 112.6474951), 
    zoom: 12,
    styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#6195a0"}]},{"featureType":"administrative.province","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"weight":"0.5"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"lightness":"0"},{"saturation":"0"},{"color":"#f5f5f2"},{"gamma":"1"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"lightness":"-3"},{"gamma":"1.00"}]},{"featureType":"landscape.natural.terrain","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45},{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#fac9a9"},{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"labels.text","stylers":[{"color":"#4e4e4e"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#787878"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"transit.station.airport","elementType":"labels.icon","stylers":[{"hue":"#0a00ff"},{"saturation":"-77"},{"gamma":"0.57"},{"lightness":"0"}]},{"featureType":"transit.station.rail","elementType":"labels.text.fill","stylers":[{"color":"#43321e"}]},{"featureType":"transit.station.rail","elementType":"labels.icon","stylers":[{"hue":"#ff6c00"},{"lightness":"4"},{"gamma":"0.75"},{"saturation":"-68"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#eaf6f8"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#c7eced"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"lightness":"-49"},{"saturation":"-53"},{"gamma":"0.79"}]}]
    });
}

function showHide() { // show / hide data view table
    $('.showhide-data>i').toggleClass('fa-chevron-down fa-chevron-up')
    $('body').toggleClass('overflow-hidden')
    
    if($('.page-data').hasClass('up')) {
        var total_h = $(window).height();
        var top_h = $('.pagetitle').height() + 90;
        var margin = (total_h - top_h) + 90
        $('.page-data').css('margin-top', margin + 'px')
    } else {
        $('.page-data').css('margin-top', '90px')
    }
    $('.page-data').toggleClass('up down')
}

function setData(location, lat, lon){ // generate data view
    unsetChart();
    $('.equipment-name').html(location);
    $(".data-body").html(default_data);
    setTimeout(function() {
        $(".data-body").load("src/dataview.php");
    }, 1000);
    var i = 0
    var j = 0
    setTimeout(function() {
        $(".data-body tr:first-child td").each(function() {
            const val = $( this ).html()
            if(i!=0) {
                $('.data-val').eq(j).html(val)
                j++
            }
            i++
        });
    }, 1500);

    var infowindow = new google.maps.InfoWindow({content: 'Weather Station ' + location});
    var marker = new google.maps.Marker({
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(lat, lon),
        map: map,
        title: location,
    });
    map.setZoom(15);
    map.setCenter(marker.getPosition());

    marker.addListener('click', function() {
        infowindow.open(this.getMap(), this);
    });
}

function unsetChart() {
    $('#dataview-chart').hide();
    $('.dataview-list').show();
    $('.btn-datalist').addClass('active');
    $('.btn-datachart').removeClass('active');
}

function setChart(param, alias) {
    $('.dataview-list').hide();
    $('#dataview-chart').css('width', $('.dataview-container').width() + 'px').show();
    $('.btn-datalist').removeClass('active');
    $('.btn-datachart').addClass('active');

    var times = [];
    var values = [];
    $( ".val-time" ).each(function( index ) {
        //console.log( index + ": " + $( this ).text() );
        times.push($(this).text())
    });
    $( ".val-" + alias ).each(function( index ) {
        //console.log( index + ": " + $( this ).text() );
        values.push($(this).text())
    });
    var option = {
        title: {
            text: param
        },
        tooltip: {},
        legend: {
            data:['value']
        },
        xAxis: {
            data: times.reverse()
        },
        yAxis: {},
        series: [{
            name: param,
            type: 'line',
            data: values.reverse()
        }]
    };
    var chartDiv = document.getElementById('dataview-chart');
    echarts.init(chartDiv).setOption(option)
}