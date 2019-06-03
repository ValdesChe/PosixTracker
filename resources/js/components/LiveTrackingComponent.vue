<template>
  <div class="container">
    <v-map :zoom="zoom" :center="center">
      <v-tilelayer :url="mapData.url" :attribution="mapData.attribution"></v-tilelayer>

      <l-moving-marker
        v-for="l in locations"
        :key="l.id"
        :lat-lng="l.latlng"
        :duration="2000"
        :icon="icon"
      >
        <l-popup :content="l.text"></l-popup>
      </l-moving-marker>
    </v-map>
  </div>
</template>

<script>
import { LMap, LTileLayer, LIconDefault, LPopup } from "vue2-leaflet";
import Vue2LeafletMarkercluster from "vue2-leaflet-markercluster";
import axios from "axios";
import L from "leaflet";

import LMovingMarker from "vue2-leaflet-movingmarker";

function rand(n) {
  let max = n + 0.01;
  let min = n - 0.01;
  return Math.random() * (max - min) + min;
}
export default {
  components: {
    "v-map": LMap,
    "v-tilelayer": LTileLayer,
    LIconDefault,
    LPopup,
    LMovingMarker
  },
  data() {
    let locations = [];
    for (let i = 0; i < 10; i++) {
      locations.push({
        id: i,
        latlng: L.latLng(rand(48.8399515), rand(2.3927873)),
        text: "Moving Marker #" + i
      });
    }
    let icon = L.icon({
      iconUrl: "https://s3-eu-west-1.amazonaws.com/ct-documents/emails/A-static.png",
      iconSize: [21, 31],
      iconAnchor: [10.5, 31],
      popupAnchor: [4, -25]
    });
    return {
      zoom: 10,
      locations,
      icon,
      center: L.latLng(48.8399515, 2.3927873),
      mapData: {
        attribution: `&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>, &copy; <a href="https://carto.com/attribution">CARTO</a>`,
        url:
          "https://cartodb-basemaps-{s}.global.ssl.fastly.net/rastertiles/voyager/{z}/{x}/{y}.png"
      }
    };
  },
  mounted() {
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