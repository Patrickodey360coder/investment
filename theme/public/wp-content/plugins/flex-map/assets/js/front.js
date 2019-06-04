jQuery(function($) {
    google.maps.event.addDomListener(window, 'load', function () {
        var mapDatas = map_data;

        var map = [];
        var mapDisplay = [];

        for( var mapid in mapDatas ) {
		if(typeof mapDatas[mapid] != 'object') return false;

            mapDisplay[mapid] = {
                init: function () {
                    var mapData         = mapDatas[mapid];

                    mapData.map_id      = mapid;
                    var map_id          = mapid;
                    var general         = mapData.general;
                    var map_style       = false;
                    var markers         = [], polyLines = [],polyGons = [],recTangles = [],circles = [];
                    var mapWrapper      = $('.map-wrapper-' + map_id );
                    var mapArea         = $('.mymaps-area-' + map_id );
                    /* helper */
                    var carousel        = [];

                        if(general.style_default != '') {
                            map_style = JSON.parse(general.style_default);
                            if(map_style.style_json != '') {
                                map_style = JSON.parse(map_style.style_json);
                            }

                        }

                    var isDraggable;
                    if( general.map_type_id != null && general.map_type_id != '' ) {
                        this.typeIdArray = [];
                        this.mapTypeControl = true;
                        for(var key in general.map_type_id) {
                            this.typeIdArray.push( google.maps.MapTypeId[general.map_type_id[key]] );
                        }
                    } else {
                        this.mapTypeControl = false;
                    }

                    /* draggable */
                    if( general.draggable === true ) {
                        isDraggable = true;
                    } else {
                        if( general.dr_mobile === true ) {
                            isDraggable = $(document).width() > 480 ? true : false;
                        } else {
                            isDraggable = true;
                        }
                    }

                    map[map_id] = new google.maps.Map(document.getElementById( 'map-canvas-' + map_id ), {
                        styles                  : map_style,
                        zoom                    : parseInt(general.zoom),
                        center                  : new google.maps.LatLng( parseFloat(general.center.lat), parseFloat(general.center.lng) ),
                        /* map base options */
                        draggable               : isDraggable,
                        scrollwheel             : general.scroll_wheel,
                        disableDoubleClickZoom  : (general.double_click_zoom === true) ? false : true,
                        /* control */
                        disableDefaultUI        : general.df_ui,
                        scaleControl            : general.scale_control,
                        zoomControl             : general.zoom_control,
                        zoomControlOptions: {
                            style : google.maps.ZoomControlStyle[general.zoom_control_size]
                        },
                        panControl              : general.pan_control,
                        overviewMapControl      : general.overview_control,
                        mapTypeControl          : this.mapTypeControl,
                        mapTypeControlOptions   : {
                            style       : google.maps.MapTypeControlStyle[general.type_control_style],
                            mapTypeIds  : this.typeIdArray
                        }
                    });

                    /* Checking for street view */
                    if( general.street_view && general.street_view.pov.heading !== 0 && general.street_view.visible == 1 ) {
                        this.panorama = map[map_id].getStreetView();
                        this.panorama.setPosition(new google.maps.LatLng( parseFloat(general.street_view.position.lat), parseFloat(general.street_view.position.lng) ));
                        this.panorama.setPov(({
                            heading : parseFloat(general.street_view.pov.heading),
                            pitch   : parseFloat(general.street_view.pov.pitch),
                            zoom    : parseFloat(general.street_view.pov.zoom)
                        }));
                        this.panorama.setVisible(true);
                    }

                    var infoWindow = new google.maps.InfoWindow;

                    this.bindResize( general, map_id, mapWrapper );
                    this.generateMarker( mapData, markers, mapWrapper, infoWindow, carousel );
                    this.legendBound( carousel, mapData );
                    this.generatePoly( mapData, infoWindow, polyLines ,polyGons ,recTangles, circles );
                    this.generateLayout( mapData, mapWrapper, mapArea);
                    this.onHoverLegendMarker( markers );
                    this.onClickLegendMarker( markers, infoWindow, map_id);
                    this.generateControl( mapData );

                    if( general.search_box == true ) {
                        this.createSearchBox( mapWrapper, map_id );
                    }
                },
                bindResize          : function ( general, map_id, mapWrapper) {
                    var $this = this;

                    /* responsive mode */
                    if( general.map_layouts == 'res' && general.height_unlimited == false && general.unit_height == 'px') {
                        google.maps.event.addDomListener(window, "resize", function() {
                            $this.center = map[map_id].getCenter();
                            google.maps.event.trigger(map[map_id], "resize");
                            map[map_id].setCenter( $this.center );
                            $this.height = $this.responsivePx( general );
                            mapWrapper.height( $this.height );
                        });
                    }
                },
                createSearchBox     : function ( mapWrapper, map_id ) {
                    mapWrapper.prepend('<input type="text" class="controls" id="pac-input-' + map_id + '" placeholder="Search Box" />');
                    // Create the search box and link it to the UI element.
                    var input = (document.getElementById('pac-input-' + map_id ));
                    var searchBox = new google.maps.places.SearchBox(input);
                    map[map_id].controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                    // Bias the SearchBox results towards current map's viewport.
                    map[map_id].addListener('bounds_changed', function() {
                        searchBox.setBounds(map[map_id].getBounds());
                    });

                    var markers = [];
                    // Listen for the event fired when the user selects a prediction and retrieve
                    // more details for that place.
                    searchBox.addListener('places_changed', function() {
                    var places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }
                    // Clear out the old markers.
                    markers.forEach(function(marker) {
                        marker.setMap(null);
                    });
                    markers = [];

                    // For each place, get the icon, name and location.
                    var bounds = new google.maps.LatLngBounds();
                    places.forEach(function(place) {
                        var icon = {
                            url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(25, 25)
                        };

                        // Create a marker for each place.
                        markers.push(new google.maps.Marker({
                            map: map[map_id],
                            icon: icon,
                            title: place.name,
                            position: place.geometry.location
                        }));

                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);
                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                        map[map_id].fitBounds(bounds);
                });
                },
                /* layouts */
                generateLayout      : function ( mapData, mapWrapper, mapArea ) {
                    var general = mapData.general;
                    this.width  = (general.map_width != '')? 'width:' + ( general.map_width + general.unit_width ) + ';' : '';
                    /* height set */
                    if( general.map_layouts == 'res' && general.height_unlimited == false && general.unit_height == 'px') {
                        this.height = 'height:' + this.responsivePx( general ) + 'px;';
                    } else {
                        this.height = (general.map_height != '')? 'height:' + ( general.map_height + general.unit_height ) + ';' : '';
                    }
                    mapWrapper.attr('style', this.width + this.height + 'position:relative;max-width: 100%;');
                    /* extra class */
                    if( general.extra_class && general.extra_class != '' ) {
                        mapWrapper.parent().addClass( general.extra_class );
                    }
                    /* if unit height is % */
                    if( general.unit_height == '%' ) {
                        mapArea.attr('style',  this.width + this.height + 'position:relative; max-width: 100%;' );
                    }

                },
                responsivePx        : function ( general ) {
                    var height = parseInt( general.map_height );
                    var one_px = ( 1 * height ) / screen.width;
                    var minus_pixel = height - ( ((screen.width - $(window).width()) * one_px) / (1.5) );
                    return minus_pixel;
                },
                generateControl     : function ( mapData ) {
                    var map_id  = mapData.map_id;
                    var general = mapData.general;

                    map[map_id].setOptions({
                        scaleControl        : general.scale_control,
                        zoomControl         : general.zoom_control,
                        streetViewControl   : general.street_view_control,
                        panControl          : general.pan_control,
                        overViewControl     : general.over_view_control,
                        mapTypeId           : google.maps.MapTypeId[general.map_type]
                    });

                    this.typeControl = general.type_control_style;
                    this.mapTypeId = [];
                    this.mapTypeId   = general.map_type_id;
                    if(this.mapTypeId !== null && this.mapTypeId !== ''){
                        if( this.mapTypeId.length > 0 ) {
                            this.typeIdArray = [];
                            for(var key in this.mapTypeId) {
                                this.typeIdArray.push( google.maps.MapTypeId[this.mapTypeId[key]] );
                            }
                            map[map_id].setOptions({
                                mapTypeControl  : true,
                                mapTypeControlOptions: {
                                    style       : google.maps.MapTypeControlStyle[this.typeControl],
                                    mapTypeIds  : this.typeIdArray
                                }
                            });
                        }
                    } else {
                        map[map_id].setOptions({
                            mapTypeControl  : false
                        });
                    }
                },

                /* marker & poly generate */
                generateMarker      : function ( mapData, markers, mapWrapper, infoWindow, carousel ) {
                    var $this       = this;
                    $this.mks       = mapData.markers;
                    $this.map_id    = mapData.map_id;
                    $this.general   = mapData.general;

                    for (var key in $this.mks) {
                        $this.markerCreateCondition( key, mapData, $this.mks[key], markers, infoWindow, carousel );
                    }
                    $this.scrollBottom    = $(window).scrollTop() + $(window).height();
                    $this.obj_height      = mapWrapper.outerHeight();
                    $this.obj_pos_bottom  = mapWrapper.offset().top + ($this.obj_height * 0.7);

                    if ( ($this.scrollBottom > $this.obj_pos_bottom) ) {
                        for( var mk_id in markers ) {
                            $this.setVisible( markers[mk_id] );
                        }
                    } else {
                        $(document).scroll( function() {
                            $this.scrollBottom    = $(window).scrollTop() + $(window).height();
                            $this.obj_height      = mapWrapper.outerHeight();
                            $this.obj_pos_bottom  = mapWrapper.offset().top + ($this.obj_height * 0.7);
                            if ( ($this.scrollBottom > $this.obj_pos_bottom) ) {
                                for( var mk_id in markers ) {
                                    $this.setVisible( markers[mk_id] );
                                }

                            }
                        });
                    }
                     /*scroll event to set visible for marker*/
                },
                setVisible          : function ( curMarker ) {
                    if (curMarker.timeout != '' && parseInt(curMarker.timeout) != null && parseInt(curMarker.timeout) != NaN) {
                        window.setTimeout(function () {
                            curMarker.setVisible(true);
                        }, curMarker.timeout);
                    }
                },
                markerCreateCondition : function ( key, mapData, cur, markers, infoWindow, carousel ) {
                     this.makerCreate( key, mapData, cur, markers, infoWindow, carousel);
                },
                makerCreate         : function ( key, mapData, cur, markers, infoWindow, carousel ) {
                    var $this   = this;
                    var map_id  = mapData.map_id;
                    var general = mapData.general;
                    var visible = (cur.timeout == '' || cur.timeout == null)? true : false;
                    /* Icon */
                    if(typeof cur.icon  === 'string' ) {
                        $this.icon = cur.icon;
                        $this.url  = cur.icon;
                    } else {
                        $this.icon = {
                            url         : cur.icon.url,
                            size        : cur.icon.size,
                            origin      : cur.icon.origin,
                            anchor      : cur.icon.anchor,
                            scaledSize  : cur.icon.scaledSize
                        };
                        $this.url  = cur.icon.url;
                    }
                    /* Find and do shortcode in content */
                    $this.description = cur.description;

                    $this.marker = new google.maps.Marker({
                        map         : map[map_id],
                        position    : new google.maps.LatLng( cur.position.lat, cur.position.lng ),
                        title       : cur.title,
                        description : cur.description,
                        animation   : google.maps.Animation[cur.animation_type],
                        icon        : cur.icon,
                        timeout     : cur.timeout,
                        visible     : visible
                    });
                    if( cur.des_open && cur.des_open == true ) {
                        var spInfoWindow =  new google.maps.InfoWindow;
                        mapDisplay[mapid].showInfor( $this.marker, map_id, spInfoWindow );
                    }
                    google.maps.event.addListener($this.marker, 'click', function(){
                        mapDisplay[mapid].showInfor( this, map_id, infoWindow );
                        mapDisplay[mapid].toggleBounce( this, markers );
                    });
                    markers.push($this.marker);

                    if( general.map_legend == true ) {
                        $this.generateLegend( carousel, 'marker', $this.url, cur.title, cur.description, (markers.length - 1));
                    }
                },
                generatePoly        : function ( mapData, infoWindow, polyLines ,polyGons ,recTangles, circles ) {
                    'use strict';
                    var $this   = this;
                    this.map_id = mapData.map_id;
                    this.plLs   = JSON.parse(mapData.polyLines);
                    this.plGs   = JSON.parse(mapData.polyGons);
                    this.recTs  = JSON.parse(mapData.recTangles);
                    this.cCs    = JSON.parse(mapData.circles);
                    /* Lines */
                    for (var keypll in this.plLs) {
                        $this.path = [];
                        for(var i in this.plLs[keypll].path ) {
                            $this.path.push(new google.maps.LatLng(this.plLs[keypll].path[i].lat, this.plLs[keypll].path[i].lng));
                        }

                        $this.line = new google.maps.Polyline({
                            map             : map[this.map_id],
                            path            : $this.path,
                            title           : $this.plLs[keypll].title,
                            description     : $this.plLs[keypll].description,
                            strokeColor     : $this.plLs[keypll].strokeColor,
                            strokeOpacity   : $this.plLs[keypll].strokeOpacity,
                            strokeWeight    : $this.plLs[keypll].strokeWeight
                        });

                        google.maps.event.addListener( $this.line, 'click', function ( e ) {
                            $this.onPolyClick( e, this, infoWindow, $this.map_id )
                        } );
                        polyLines.push($this.line);
                    }
                    /* Gons */
                    for (var keyplg in this.plGs)  {
                        $this.path = [];
                        for(var i = 0;i < this.plGs[keyplg].path.length; i++ ) {
                            $this.path.push(new google.maps.LatLng(this.plGs[keyplg].path[i].lat, this.plGs[keyplg].path[i].lng));
                        }
                        $this.plg = new google.maps.Polygon({
                            map             : map[this.map_id],
                            path            : $this.path,
                            title           : this.plGs[keyplg].title,
                            description     : this.plGs[keyplg].description,
                            strokeColor     : this.plGs[keyplg].strokeColor,
                            strokeOpacity   : this.plGs[keyplg].strokeOpacity,
                            strokeWeight    : this.plGs[keyplg].strokeWeight,
                            fillColor       : this.plGs[keyplg].fillColor,
                            fillOpacity     : this.plGs[keyplg].fillOpacity
                        });
                        google.maps.event.addListener( $this.plg, 'click', function ( e ) {
                            $this.onPolyClick( e, this, infoWindow, $this.map_id )
                        } );
                    polyGons.push($this.plg);
                    }
                    /* Rec */

                    for (var keyrt in this.recTs) {
                        /* Define */
                        $this.bounds = new google.maps.LatLngBounds(
                            new google.maps.LatLng( this.recTs[keyrt].bounds.SouthWest.lat, this.recTs[keyrt].bounds.SouthWest.lng ),
                            new google.maps.LatLng( this.recTs[keyrt].bounds.NorthEast.lat, this.recTs[keyrt].bounds.NorthEast.lng )
                        );

                        $this.rec = new google.maps.Rectangle({
                            map             : map[this.map_id],
                            bounds          : $this.bounds,
                            title           : this.recTs[keyrt].title,
                            description     : this.recTs[keyrt].description,
                            strokeColor     : this.recTs[keyrt].strokeColor,
                            strokeOpacity   : this.recTs[keyrt].strokeOpacity,
                            strokeWeight    : this.recTs[keyrt].strokeWeight,
                            fillColor       : this.recTs[keyrt].fillColor,
                            fillOpacity     : this.recTs[keyrt].fillOpacity
                        });
                        google.maps.event.addListener( $this.rec, 'click', function ( e ) {
                            $this.onPolyClick( e, this, infoWindow, $this.map_id )
                        } );
                    recTangles.push($this.rec);
                    }

                    for (var keycc in this.cCs) {
                        $this.center = new google.maps.LatLng( this.cCs[keycc].center.lat, this.cCs[keycc].center.lng );
                        $this.circle = new google.maps.Circle({
                            map             : map[this.map_id],
                            center          : $this.center,
                            radius          : this.cCs[keycc].radius,
                            title           : this.cCs[keycc].title,
                            description     : this.cCs[keycc].description,
                            strokeColor     : this.cCs[keycc].strokeColor,
                            strokeOpacity   : this.cCs[keycc].strokeOpacity,
                            strokeWeight    : this.cCs[keycc].strokeWeight,
                            fillColor       : this.cCs[keycc].fillColor,
                            fillOpacity     : this.cCs[keycc].fillOpacity
                        });
                        circles.push($this.circle);
                        google.maps.event.addListener( $this.circle, 'click', function ( e ) {
                            $this.onPolyClick( e, this, infoWindow, $this.map_id )
                        } );
                    }
                },
                /* event  */
                onMarkerClick       : function () {
                    mapDisplay[mapid].showInfor( this );
                    mapDisplay[mapid].toggleBounce( this );
                },
                onPolyClick         : function( e ,cur ,infoWindow, map_id ){
                    if (cur.description.trim() != '' && cur.description.trim() != '<br />'){
                        /* Map click to get position */
                        var latitude    = e.latLng.lat();
                        var longitude   = e.latLng.lng();
                        infoWindow.setContent(cur.description);
                        infoWindow.setPosition({lat: parseFloat(latitude), lng: parseFloat(longitude)});
                        infoWindow.open(map[map_id]);
                    }
                },
                onHoverLegendMarker : function ( markers ) {
                    var $this = this;
                    $( document )
                        .on('mouseenter','.owl-item', function() {
                            if( $(this).find('.marker-lg-item') ) {
                                $this.marker_data = parseInt($(this).find('.marker-lg-item').attr('marker-data'));
                                if( markers[$this.marker_data] ) $this.toggleBounce( markers[$this.marker_data] );
                            }
                        })
                        .on('mouseleave','.owl-item', function() {
                            if( $(this).find('.marker-lg-item') ) {
                                $this.marker_data = parseInt($(this).find('.marker-lg-item').attr('marker-data'));
                                if( markers[$this.marker_data] ) $this.stopEffect( markers[$this.marker_data] );
                            }
                        });
                },
                onClickLegendMarker : function ( markers, infoWindow, map_id ) {
                    var $this = this;
                    $( document ).on('click', '.legend-carousel-' + map_id + ' .owl-item', function() {

                        $this.marker_data = parseInt($(this).find('.marker-lg-item').attr('marker-data'));
                        mapDisplay[mapid].showInfor( markers[$this.marker_data], map_id, infoWindow );
                        if( markers[$this.marker_data] ) $this.toggleBounce(markers[$this.marker_data]);
                        $this.center = markers[$this.marker_data].getPosition();
                        map[map_id].setCenter($this.center);
                    });
                },
                /* helper */
                showInfor           : function( cur, map_id, infoWindow ) {
                    if ( cur.description.trim() != '' && cur.description.trim() != '<br />') {
                        infoWindow.setContent( cur.description.trim() );
                        infoWindow.open( map[map_id], cur );
                    }
                },
                toggleBounce        : function ( cur, markers ) {
                    for(this.marker in markers) {
                        markers[this.marker].setAnimation(null);
                    }
                    cur.setAnimation(google.maps.Animation.BOUNCE);
                },
                stopEffect          : function( obj ) {
                    obj.setAnimation(null);
                },
                generateLegend      : function ( carousel, type, icon, title, des, data ) {
                    this.show = '';
                    this.des = ( des != undefined )? strip_tags(des, '') : '';

                    if(type == 'marker') {
                        this.markerLg = '<div class="marker-lg-item" marker-data="' + data + '" style="background:url(' + icon + ') no-repeat;background-position:1% 50%;background-size:29px 29px;">';
                        this.markerLg +=    '<div class="lg_title">' + title + '</div>';
                        this.markerLg +=    '<div class="lg_des">' + this.des + '</div>';
                        this.markerLg += '</div>';
                    }
                    carousel.push(this.markerLg);
                },
                legendBound         : function ( carousel, mapData ) {
                    var $this = this;
                    this.show = '';
                    var map_id  = mapData.map_id;
                    var general = mapData.general;

                    for( var key in carousel ) {
                        this.show += carousel[key];
                    }
                    if( general.map_legend && general.map_legend == true ) {
                    $( '.legend-carousel-' + map_id ).html(this.show);

                        $(document).ready(function() {
                            $( '.legend-carousel-' + map_id ).owlCarousel({
                                items : 4,
                                autoHeight : false,
                                pagination : true,
                                navigation : false
                            });
                            $this.max = 0;
                            $.each($( '.legend-carousel-' + map_id + ' .owl-item'), function(){
                                $this.max = ( $(this).outerHeight() > $this.max )? $(this).outerHeight() : $this.max;
                            });
                            $( '.legend-carousel-' + map_id + ' .owl-item').css('height', $this.max);
                        });
                    }
                }
            };
            mapDisplay[mapid].init();

        }/* end foreach */
});
function strip_tags(input, allowed) {
    allowed = (((allowed || '') + '')
        .toLowerCase()
        .match(/<[a-z][a-z0-9]*>/g) || [])
        .join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
        commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
    return input.replace(commentsAndPhpTags, '')
        .replace(tags, function($0, $1) {
            return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
        });
}
});