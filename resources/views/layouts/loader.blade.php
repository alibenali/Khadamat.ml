
      <div class="loading-page" id="loading-page">
        <div class="loading" id="loading"></div>
      </div>
<style type="text/css">


.loading-page {
      background: rgba(0, 0, 0, 0.40);
      width: 100%;
      height: 100vh;
      z-index: 999999999;
      position: absolute;
}
  .loading {
  height: 0;
  width: 0;
  padding: 15px;
  border: 6px solid #ccc;
  border-right-color: #888;
  border-radius: 22px;
  -webkit-animation: rotate 1s infinite linear;
  /* left, top and position just for the demo! */
  position: absolute;
  left: 50%;
  top: 50%;
}


@-webkit-keyframes rotate {
  /* 100% keyframe for  clockwise. 
     use 0% instead for anticlockwise */
  100% {
    -webkit-transform: rotate(360deg);
  }
}
</style>
<script>

    window.onload = function(){
            document.getElementById("loading").style.display = "none";
            document.getElementById("loading-page").style.display = "none";
      };

</script>
