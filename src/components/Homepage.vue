<template>
  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar" class="order-last">
      <div class="custom-menu">
        <button
          type="button"
          id="sidebarCollapse"
          class="btn btn-primary"
        ></button>
      </div>
      <div class="">
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a
                  class="nav-link active"
                  id="home-tab"
                  data-toggle="tab"
                  href="#home"
                  role="tab"
                  aria-controls="home"
                  aria-selected="true"
                  >Colours</a
                >
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  id="profile-tab"
                  data-toggle="tab"
                  href="#profile"
                  role="tab"
                  aria-controls="profile"
                  aria-selected="false"
                  >Ambients</a
                >
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  id="contact-tab"
                  data-toggle="tab"
                  href="#contact"
                  role="tab"
                  aria-controls="contact"
                  aria-selected="false"
                  >Trends</a
                >
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div
                class="tab-pane fade show active"
                id="home"
                role="tabpanel"
                aria-labelledby="home-tab"
              >
                Renk Seçiniz
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      data-toggle="tab"
                      href="#countertop"
                      role="tab"
                      aria-controls="countertop"
                      aria-selected="true"
                      >Masa</a
                    >
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      data-toggle="tab"
                      href="#furniture"
                      role="tab"
                      aria-controls="furniture"
                      aria-selected="true"
                      >Sandalye</a
                    >
                  </li>
                </ul>
                <div
                  v-for="(item, index) in result"
                  :key="index"
                  class="tab-pane fade show active"
                  id="countertop"
                  role="tabpanel"
                >
                  <!--<a slot="img_link" href="deneme" item.logo_url="" target="_blank"><img slot="img" src="https://img.epsilonarge.com/img/1560110315.png" alt="img" style="max-height: 120px; margin-right: 10px;"></a>-->
                  <input
                    class="icons"
                    type="image"
                    :src="img_base_url + 'ImgColor/' + item.img_color_url"
                    alt=""
                    @click="getImage(item.img_url)"
                    width="80px"
                    height="80px"
                  />
                </div>
                <div class="tab-pane fade" id="furniture" role="tabpanel"></div>
              </div>
              <div
                class="tab-pane fade"
                id="profile"
                role="tabpanel"
                aria-labelledby="profile-tab"
              >
                <input
                  class="ambients"
                  type="image"
                  src="images/ambients/1.jpg"
                  onclick="document.getElementById('myImage').src='images/ambients/1.jpg'"
                  width="100%"
                  height="80%"
                />
                <h5 style="text-align: center"></h5>
              </div>
              <div
                class="tab-pane fade"
                id="contact"
                role="tabpanel"
                aria-labelledby="contact-tab"
              ></div>
            </div>
          </div>
        </nav>
      </div>
    </nav>



    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
      <img id="myImage" :src="img_base_url + 'Img/' + img" style="width: 100%" />
      <button onclick="document.getElementById('myImage').src='images/2.jpg'">
        2
      </button>



    </div>
  </div>
</template>
<script>
import axios from "axios";
import store from "../store";

export default {
  data() {
    return {
      result: [],
      situation: false,
      img : "",
      img_base_url: store.state.img_base_url,
      imgSrc: store.state.img_base_url,
    };
  },
  
  mounted: function () {
    let datas = [];
    let dataUrl = store.state.base_url + "Category/getAllImages.php?key=123";
    return axios
      .get(dataUrl)
      .then((response) => {
        //console.log(response);
        this.result = response.data.data;
      })
      .catch((err) => {
        console.log(err.response);
      });
  },
  methods : {

   getImage(img_url) {
   this.img = img_url;
   console.log(this.img);
   }

  },
  components: {},
};
</script>

<style>
</style>