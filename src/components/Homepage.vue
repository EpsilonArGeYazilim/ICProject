<template>
  <div class="row" style="height:655px">
    <nav id="tmSidebar" class="tm-bg-black-transparent tm-sidebar">
      <button
        class="navbar-toggler"
        type="button"
        aria-label="Toggle navigation"
      >
        <i class="fas fa-bars"></i>
      </button>

      <div class="container mt-2">
        <h2>Epsilon Arge Yazılım</h2>
       
        <!-- Nav tabs -->
        <ul class="nav nav-tabs tabLi">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tab-1"
              >Ambiance</a
            >
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tab-2">Colors</a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content tabContainer">
          <div id="tab-1" class="container tab-pane active">
            
            <img width="100%" />
            <input
              v-for="(item, index) in resultCategory.images"
              :key="index"
              type="image"
              :src="img_base_url + 'Img/' + item.img_url"
              @click="getByIdSubCategory(index)"
              width="100%"
              height="80%"
            />
          </div>

          <!-- üst kısım ambiance kısmı -->
          <div id="tab-2" class="container tab-pane">
            <br />
            <img width="100%" />
            <!-- subcategory isimlerinin çekildiği yer -->
            <ul class="nav nav-tabs tabLi" style="width:250px">
              <li class="nav-item">
                <a
                  class="nav-link"
                  data-toggle="tab"
                  href="#tab-3"
                  @click="onChange(0)"
                  >{{ subName1 }}</a
                >
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  data-toggle="tab"
                  href="#tab-4"
                  @click="onChange(1)"
                  >{{ subName2 }}</a
                >
              </li>
            </ul>
            <!-- subcategory isimlerinin çekildiği yer -->

            <div
              v-for="(item, index) in imgColor[subNumber]"
              :key="index"
              class="tab-pane fade show active"
              id="countertop"
              role="tabpanel"
              style="float:left; padding:5px;"
            >
              <input
                class="icons"
                type="image"
                :src="img_base_url + 'ImgColor/' + item.img_color_url"
                alt=""
                @click="getImage(item.img_url)"
                width="80px"
                height="80px"
                style="border-radius:50%"
              />
            </div>
        
          </div>
        </div>
      </div>
    </nav>

  <div role="main" class="ml-sm-auto col-12">
   <!-- <div
        role="main"
        class="parallax-window"
        data-parallax="scroll"
        :data-image-src="img_base_url + 'Img/' + img"
       >-->
        <img
     style="height : 657px ; width : 100%"
        :src="img_base_url + 'Img/' + img"
       
      />
        
      </div>
      <!-- buraya kadar kalcak-->
    <!-- </div>-->
  </div>
</template>
<script>
import axios from "axios";
import store from "../store";

export default {
  data() {
    return {
      subNumber: 0,
      subName1: "",
      subName2: "",
      imgColor: [],
      resultCategory: [],
      subCategory: [],
      situation: false,
      img: "",
      category_id: "",
      img_base_url: store.state.img_base_url,
      imgSrc: store.state.img_base_url,
    };
  },

  mounted: function () {
    let datas = [];
    let dataUrl = store.state.base_url + "Category/getAllCategory.php?key=123";
    return axios
      .get(dataUrl)
      .then((response) => {
        // console.log(response);
        
        this.resultCategory = response.data;
        
        
        
      })
      .catch((err) => {
        console.log(err.response);
      });
  },
  methods: {
    getImage(img_url) {
      this.img = img_url;
      //console.log(this.img);
    },
    getImage2(img_url) {
      this.img = img_url;
      //console.log(this.img);
    },
    onChange(number) {
      this.subNumber = number;
    },
    getByIdSubCategory(category_id) {
      var subCategory = this.subCategory;
      //console.log(category_id);
      var url =
        store.state.base_url + "Category/getByIdSubCategory.php?key=123";
      var datas = {
        category_id: category_id,
      };
      return axios

        .post(url, JSON.stringify(datas))
        .then((response) => {
          this.subName1 = response.data.sub_categories[0].name;
          this.subName2 = response.data.sub_categories[1].name;
          this.imgColor = response.data.sub_images;
          this.getImage2(this.imgColor[0][0].img_url);
          //console.log(subCategory);
        })
        .catch((error) => {
          console.log(error.response);
        });
    },
  },
  components: {},
};
</script>

<style>
</style>
