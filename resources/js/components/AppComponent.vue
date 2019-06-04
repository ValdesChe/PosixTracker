<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <router-link  :to="{name:'home'}" class="navbar-brand">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="64"
            height="64"
            viewBox="0 0 64.000001 64.000001"
          >
            <path
              d="M.044 24.19l3.984 1.077 19.51 33.648-1.078 3.937zM63.875 39.283l-3.984-1.078L40.383 4.558 41.46.62zM.9 22.446l3.992 1.05 33.796-19.43L39.732.12z"
              fill="#2b2a30"
              fill-rule="evenodd"
            ></path>
            <path
              d="M510.785 347.705l-29.636-7.826L230.22 484.79l-7.758 29.436z"
              fill="#2b2a30"
              fill-rule="evenodd"
              stroke="#2b2a30"
              transform="matrix(.13468 0 0 .13407 -5.013 -5.203)"
            ></path>
            <path
              d="M207.565 491.087L54.162 224.57M495.34 344.147L229.233 498.255"
              fill="#2b2a30"
              fill-rule="evenodd"
              stroke="#f60"
              transform="matrix(.13468 0 0 .13407 -5.013 -5.203)"
            ></path>
            <g fill="#f60" fill-rule="evenodd">
              <path
                d="M3.075 23.01l1.817.485L38.687 4.067l.504-1.91zM61.876 38.755l-1.365-.373L40.558 3.91l.33-1.31zM2.077 24.737l1.856.498 19.58 33.81-.502 1.845zM61.963 40.87l-1.92-.505-34.187 19.608-.504 1.972z"
              ></path>
            </g>
            <path
              d="M3.28 24.195L40.067 3.052l21.24 36.62L24.52 60.817 3.28 24.196z"
              fill="#2b2a30"
            ></path>
            <path
              d="M30.575 9.407c-.458.003-.917.027-1.373.074v6.623h2.36l.2-.01.17.01h.213v.012c3.693.222 6.584 3.567 6.59 7.62 0 4.22-3.122 7.642-6.972 7.642-.877-.002-1.746-.187-2.56-.543V43.47l5.926 11.256 6.65-3.82-6.078-11.81c5.868-2.207 9.774-7.944 9.782-14.367 0-8.463-6.675-15.323-14.91-15.323z"
              fill="#d45500"
            ></path>
            <path
              d="M29.283 9.244l-9.846 4.964v1.897h9.855zm-9.67 8.51V52.17h9.677V17.754z"
              fill="#f60"
            ></path>
          </svg>
        </router-link >
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarTogglerDemo02"
          aria-controls="navbarTogglerDemo02"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <router-link class="nav-link" :to="{name:'home'}">Accueil</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{name:'livetracking'}">
                <span class="live-stream"></span>
                Tracking Live</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{name:'statistics'}">Statistiques</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{name:'about'}" >A propos de nous !</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{name:'statistics'}" >Aide</router-link>
            </li>
          </ul>
        </div>
      </nav>
    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    var linkClicked = document.getElementsByClassName("nav-link");
    var numClass = linkClicked.length;

    for (var i = 0; i < numClass; i++) {
      linkClicked[i].addEventListener(
        "click",
        function() {
          var onTheMoment = document.getElementsByClassName("router-link-exact-active");
          onTheMoment[0].className = onTheMoment[0].className.replace(
            " router-link-exact-active",
            ""
          );
          this.className += " router-link-exact-active";
        },
        false
      );
    }
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
body {
  font-family: "Open Sans", sans-serif;
  background-color: #000;
}
ul a:hover {
  color: #fbc02d !important;
}
nav li {
  text-align: center;
  text-transform: uppercase;
}
li > a:after {
  content: "";
  display: block;
  height: 1.5px;
  background: #fbc02d;
  transform: scaleX(0);
  transition: transform 0.3s;
}
li > a:hover:after {
  transform: scaleX(1);
  transition: transform 0.3s;
}
.router-link-exact-active {
  color: #fbc02d !important;
}

.live-stream {
  height: 10px;
  width: 10px;
  border-radius: 50%;
  background: red;
  display: inline-block;
-webkit-animation-name: blinker;
-webkit-animation-duration: 2s;
-webkit-animation-timing-function: linear;
-webkit-animation-iteration-count: infinite;

-moz-animation-name: blinker;
-moz-animation-duration: 2s;
-moz-animation-timing-function: linear;
-moz-animation-iteration-count: infinite;

 animation-name: blinker;
 animation-duration: 2s;
 animation-timing-function: linear;
 animation-iteration-count: infinite;
}

@-moz-keyframes blinker {  
 0% { opacity: 1.0; }
 50% { opacity: 0.0; }
 100% { opacity: 1.0; }
 }

@-webkit-keyframes blinker {  
 0% { opacity: 1.0; }
 50% { opacity: 0.0; }
 100% { opacity: 1.0; }
 }

@keyframes blinker {  
 0% { opacity: 1.0; }
 50% { opacity: 0.0; }
 100% { opacity: 1.0; }
 }
</style>
