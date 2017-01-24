class Map {
  constructor(searchable=true,markable=true,createLngLat=true) {
    this.searchable = searchable;
    this.markable = markable;
    this.createLngLat = createLngLat;
    this.icon = '/images/map/location-pin.png';
  }

  load(geographic) {

    let lat = 13.297587657705135;
    let lng = 100.94727516174316;

    let setMarker = false;

    if (typeof geographic != 'undefined') {
      let _geographic = JSON.parse(geographic);

      if ((typeof _geographic.latitude != 'undefined') && (typeof _geographic.longitude != 'undefined')) {
        lat = _geographic.latitude;
        lng = _geographic.longitude;

        this.createHiddenData(lat,lng);

        setMarker = true;
      }

    }

    this.initialize(new google.maps.LatLng(lat,lng),setMarker);

  }

  initialize(latlng,setMarker) {

    let _this = this;

    let options = {
        zoom: 13,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    let map = new google.maps.Map(document.getElementById("map"), options);

    let marker = new google.maps.Marker();
    if(setMarker) {
      marker = new google.maps.Marker({
              position: latlng,
              icon: this.icon,
              map: map
            });
    }

    if(this.markable){
      this.mapMarker(map,marker);
    }

    if(this.searchable){
      this.searchBox(map,marker);
    }

  }

  mapMarker(map,marker) {

    let _this = this;

    let geocoder = new google.maps.Geocoder();

    google.maps.event.addListener(map, 'click', function(event) {

      marker.setMap(null);

      marker = new google.maps.Marker({
        map: map,
        icon: _this.icon,
        position: {lat: event.latLng.lat(), lng: event.latLng.lng()}
      });

      _this.createHiddenData(event.latLng.lat(),event.latLng.lng())

      geocoder.geocode({
        'latLng': event.latLng
      }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {
            // $("#address").text(results[0].formatted_address);
          }
        }
      });

    });

  }

  searchBox(map,marker) {

    let _this = this;

    // Create the search box and link it to the UI element.
    let input = document.getElementById('pac-input');
    let searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });


    searchBox.addListener('places_changed', function() {
      let places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }

      marker.setMap(null);

      // For each place, get the icon, name and location.
      let bounds = new google.maps.LatLngBounds();
      places.forEach(function(place) {
        if (!place.geometry) {
          console.log("Returned place contains no geometry");
          return;
        }

        // $("#lat").val(place.geometry.location.lat());
        // $("#lng").val(place.geometry.location.lng());
        _this.createHiddenData(place.geometry.location.lat(),place.geometry.location.lng());

        geocoder.geocode({
          'latLng': place.geometry.location
        }, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
              $("#address").text(results[0].formatted_address);
            }
          }
        });

        marker = new google.maps.Marker({
          map: map,
          icon: _this.icon,
          position: place.geometry.location
        });

        if (place.geometry.viewport) {
          // Only geocodes have viewport.
          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }
      });

      map.fitBounds(bounds);

    });

  }

  createHiddenData(latitude,longitude) {

    if(this.createLngLat) {

      this.removeHiddenData();

      let lat = document.createElement('input');
      lat.setAttribute('type','hidden');
      lat.setAttribute('name','Address[latitude]');
      lat.setAttribute('id','lat');
      lat.value = latitude;

      let lng = document.createElement('input');
      lng.setAttribute('type','hidden');
      lng.setAttribute('name','Address[longitude]');
      lng.setAttribute('id','lng');
      lng.value = longitude;

      $('form').append(lat);
      $('form').append(lng);

    }
    
  }

  removeHiddenData() {
    $("#lat").remove();
    $("#lng").remove();
  }

}