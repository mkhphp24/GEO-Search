$(document).ready(function() {
    var	 vectorLayer;
    var map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        view: new ol.View({
            center: ol.proj.fromLonLat([10.01 ,50.95]),
            zoom: 6
        })
    });

    var styleFunction = function(feature) {

        var styles = {
            'point': [new ol.style.Style({
                image: new ol.style.Icon(({
                    anchor: [0.5, 46],
                    anchorXUnits: 'fraction',
                    anchorYUnits: 'pixels',
                    opacity: 0.75,
                    // rotation: Math.PI / dir,
                    src: '/css/point.png'
                }))
            })],
            'point_center': [new ol.style.Style({
                stroke: new ol.style.Stroke({
                    color: 'rgba(0,0,255,1)',
                    width: 2
                }),
                fill: new ol.style.Fill({
                    color: 'rgba(0,0,255,0.4)'
                }),
                image: new ol.style.Icon(({
                    anchor: [0.5, 46],
                    anchorXUnits: 'fraction',
                    anchorYUnits: 'pixels',
                    opacity: 0.75,
                    // rotation: Math.PI / dir,
                    src: '/css/marker.png'
                }))
            })]

        }

        return styles[feature.get('style')];
    };


    // change mouse cursor when over marker
    map.on('pointermove', evt => {
        if (!evt.dragging) {
            map.getTargetElement().style.cursor = map.hasFeatureAtPixel(map.getEventPixel(evt.originalEvent)) ? 'pointer' : '';
            showdistance(evt)
        }
    });

    showdistance=function (evt) {
        var pixel = map.getEventPixel(evt.originalEvent);

        var feature = map.forEachFeatureAtPixel(pixel, function (feature) {
            return feature;
        });

        if (typeof(feature) != "undefined") {
            var name=feature.get('name');
            var distance=feature.get('distance');
            var thoroughfare=feature.get('thoroughfare');
            $('#distance').html(name+" - "+thoroughfare+"<span class='text-success'>  ( "+parseInt(distance)+" Meter ) </span>");
        }

    }



    getdata=function (evt) {
        var pixel = map.getEventPixel(evt.originalEvent);
        var lonlat = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
        var lon = lonlat[0];
        var lat = lonlat[1];

        var feature = map.forEachFeatureAtPixel(pixel, function (feature) {
            return feature;
        });
        $('#select-ajax').hide();
        $('#modal-header').html('Search With Point on Map ');
        $('#Site-Modal').modal('show');
        $('#form-distance-lat').val(lat);
        $('#form-distance-lng').val(lon);
    }

    $(document).on("click","#menu_postal_code", function() {
        $('#Site-Modal').modal('show');
        $('#modal-header').html('Search With Postal Code');
        $('#form-distance-lat').val('');
        $('#form-distance-lng').val('');
        $('#select-ajax').show();
    })

    $(document).on("click","#send-cordinate", function() {
        var form = $('#form-cordinate');
        map.removeLayer(vectorLayer);
        var lat=$('#form-distance-lat').val();
        var lon= $('#form-distance-lng').val();
        vectorLayer= new ol.layer.Vector({
            source: new ol.source.Vector({
                loader: function() {
                    $.ajax({
                        type: 'POST',
                        url:'/api/cordinate/',
                        data: form.serialize(), // serializes the form's elements.
                        context: this,
                        success: function(data){
                            $('#Site-Modal').modal('hide');
                            map.getView().setCenter(ol.proj.transform([parseFloat(lon),parseFloat(lat) ], 'EPSG:4326', 'EPSG:3857'));
                            map.getView().setZoom(8);

                            var format = new ol.format.GeoJSON();
                            this.addFeatures(format.readFeatures(data, {
                                defaultDataProjection: ol.proj.get('EPSG:3765'),
                                featureProjection: 'EPSG:3857'
                            }));

                        }

                    })
                }

            })
            ,
            style: styleFunction
        });

        map.addLayer(vectorLayer);

    });
    map.on('click',getdata);



    $('.select-ajax').select2({
        ajax: {
            url: '/api/search/postcod/1/',
            data: function (term, page) {
                return {
                    q: term, // search term
                    page_limit: 10
                };
            },
            dataType: 'json',
            processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data.items
                };
            }
        }
    });

    $('#select-ajax').on('select2:select', function (e) {
        var lat = e.params.data.lat;
        var lng = e.params.data.lng;
        $('#form-distance-lat').val(lat);
        $('#form-distance-lng').val(lng);
    });


});
