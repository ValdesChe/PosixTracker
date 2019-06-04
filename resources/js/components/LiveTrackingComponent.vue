<template>
  <div class="container">
    <v-map :zoom="zoom" :center="center">
      <v-tilelayer :url="mapData.url" :attribution="mapData.attribution"></v-tilelayer>

       <l-polyline
      :lat-lngs="polylinesElts"
      :color="polyline_color">
      </l-polyline>
      <l-moving-marker
        v-for="l in edited_locations"
        :key="l.id"
        :lat-lng="l.latlng"
        :duration="2000"
        :icon="l.icon != null ? l.icon : icon"
      >
        <l-popup :content="l.text"></l-popup>
      </l-moving-marker>
    </v-map>
  </div>
</template>

<script>
import { LMap, LTileLayer, LIconDefault, LPolyline, LPopup } from "vue2-leaflet";
import Vue2LeafletMarkercluster from "vue2-leaflet-markercluster";
import axios from "axios";
import L from "leaflet";
import LMovingMarker from "vue2-leaflet-movingmarker";

export default {
  components: {
    "v-map": LMap,
    "v-tilelayer": LTileLayer,
    LIconDefault,
    LPopup,
    LMovingMarker,
    LPolyline
  },
  computed: {
    edited_locations() {
      return this.locations.map((location, index) => {
        let iconeMarker = null;

        // Si c est la première position du robot /
        if (index === 0) {
            // On  centre la carte sur ce point 
          this.center = L.latLng(location.latitude, location.longitude);

          // On change l'icon de cette position là
          iconeMarker = L.icon({
                iconUrl: "./../images/marker_start.png",
                iconSize: [21, 31],
                iconAnchor: [10.5, 31],
                popupAnchor: [4, -25]
              });
        }
       
        // Si c est la dernière position du robot /
        if (index === this.locations.length - 1) {
            // On  centre la carte sur ce point 
          this.center = L.latLng(location.latitude, location.longitude);

          // On change l'icon de cette position là
          iconeMarker = L.icon({
                iconUrl: "./../images/marker_actual.png",
                iconSize: [21, 31],
                iconAnchor: [10.5, 31],
                popupAnchor: [4, -25]
              });
        }

        return {
          id: location.id,
          latlng: L.latLng(location.latitude, location.longitude),
          icon: iconeMarker,
          text: `Position { ${location.latitude}  /  ${location.longitude} }`
        };
      });
    },
    polylinesElts() {
      return this.locations.map((location, index) => {
        return [location.latitude , location.longitude];
      });
    }
  },
  data() {
    let locations = [];

    let icon = L.icon({
      iconUrl: "./../images/marker.png",
      iconSize: [21, 31],
      iconAnchor: [10.5, 31],
      popupAnchor: [4, -25]
    });
    return {
      zoom: 14,
      locations,
      icon,
      center: L.latLng(48.8399515, 2.3927873),
      mapData: {
        attribution: `&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attribution">CARTO</a>`,
        url:
          "https://cartodb-basemaps-{s}.global.ssl.fastly.net/rastertiles/voyager/{z}/{x}/{y}.png"
      },

      // Couleur de la ligne
      polyline_color: "orange"
    };
  },
  mounted() {
    axios.post(server_api + "/all").then(success => {
      this.locations = success.data.all_locations;
      console.log(success);
    });
    /*setInterval(() => {
        this.locations.forEach(location => {
          location.latlng = L.latLng(rand(48.8399515), rand(2.3927873))
        })
      }, 2000);*/
  },
  created() {
    Echo.channel("location")
      // SendPosition event listener
      .listen("SendPosition", e => {
        console.log(e);
        this.locations.push(e.location);
      });
  }
};
</script>

<style scoped>
@import "https://unpkg.com/leaflet@1.4.0/dist/leaflet.css";
@import "https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css";
.leaflet-container {
  height: 97vh;
}
</style>