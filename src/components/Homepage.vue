<template>
  <div>
    <div
      class="row"
      :style="
        'background-image: url(' +
        img_base_url +
        'Img/' +
        image +
        ');transition: background 1s linear;overflow: hidden;-ms-transition: background 1s linear;-o-transition: background 1s linear; opacity: 1.0;-moz-transition: background 1s linear; -webkit-transition: background 1s linear; height: 100vh; min-height: 350px;  background-position: center; background-repeat: no-repeat;background-size: cover;'
      "
    >
      <nav id="tmSidebar" class="tm-bg-black-transparent tm-sidebar">
        <button
          class="navbar-toggler"
          type="button"
          aria-label="Toggle navigation"
        >
          <i class="fas fa-bars"></i>
        </button>
        <div class="container mt-2">
          <h2 style="color: white">Epsilon Arge Yazılım</h2>
          <ul class="nav nav-tabs tabLi">
            <li class="nav-item">
              <a
                class="nav-link active"
                data-toggle="tab"
                href="#tab-1"
                style="font-size: 15px"
                >Ambiance</a
              >
            </li>
            <li class="nav-item">
              <a
                class="nav-link"
                data-toggle="tab"
                href="#tab-2"
                style="font-size: 15px"
                >Colors</a
              >
            </li>
          </ul>
          <br>
          <div class="tab-content tabContainer">
            <div id="tab-1" class="container tab-pane active" >
              <div style="cursor: pointer" v-for="(item, index) in categoryDatas"
                :key="index">
              <img
                
                type="image"
                :src="img_base_url + 'Img/' + categoryImages[index].img_url"
                @click="
                  getByIdCategoryAllDatas(categoryDatas[index].category_id)
                "
                width="100%"
                height="80%"
              />
               <p style="color: #f0f7ff; text-align: center ; text-transform: uppercase;font-size: 12px">
                    {{ categoryDatas[index].category_name }}
                  </p></div>
            </div>
            <div id="tab-2" class="container tab-pane">
              <br />
              <ul class="nav nav-tabs tabLi" style="width: 250px">
                <li class="nav-item">
                  <a
                    class="nav-link active"
                    data-toggle="tab"
                    style="font-size: 15px"
                    href="#tab-3"
                    @click="onChange(0)"
                    >{{ subName1 }}</a
                  >
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link"
                    data-toggle="tab"
                    style="font-size: 15px"
                    href="#tab-4"
                    @click="onChange(1)"
                    >{{ subName2 }}</a
                  >
                </li>
              </ul>
              <div
                v-if="tabNumber == 0"
                class="tab-pane fade row show active"
                id="tab-3"
                role="tabpanel"
                style="float: left; padding: 5px"
              >
                <div
                  v-for="(item, index) in color1ids"
                  :color1_id="item"
                  :key="index"
                  class="col-md-6"
                >
                  <img
                    class="icons"
                    type="image"
                    :src="
                      img_base_url + 'ImgColor/' + color1Datas[item].color1_url
                    "
                    alt=""
                    @click="color1Click(color1Datas[item].color1_id)"
                    width="80px"
                    height="80px"
                    style="border-radius: 50%; margin: 4px; cursor: pointer"
                  />
                  <p style="color: #f0f7ff; text-align: center ; text-transform: uppercase;font-size: 12px">
                    {{ color1Datas[item].color1_name }}
                  </p>
                </div>
              </div>
              <div
                v-if="tabNumber == 1"
                class="tab-pane fade row"
                id="tab-4"
                role="tabpanel"
                style="float: left; padding: 5px"
              >
                <div
                  class="col-md-6"
                  v-for="(item, index) in color2ids"
                  :color2_id="item"
                  :key="index"
                >
                  <img
                    class="icons"
                    type="image"
                    :src="
                      img_base_url + 'ImgColor/' + color2Datas[item].color2_url
                    "
                    alt=""
                    @click="color2Click(color2Datas[item].color2_id)"
                    width="80px"
                    height="80px"
                    style="border-radius: 50%; margin: 4px; cursor: pointer"
                  />
                  <p style="color: #f0f7ff; text-align: center;text-transform: uppercase;font-size: 14px">
                    {{ color2Datas[item].color2_name }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import store from "../store";

export default {
  data() {
    return {
      imagesDatas: {},
      color1_id: [],
      color2_id: [],
      color1Datas: {},
      color2Datas: {},
      categoryDatas: {},
      color1: "",
      color2: "",
      color1ids: [],
      color2ids: [],
      image: "",
      category_id: "",
      subName1: "",
      subName2: "",
      imgColor: [],
      ImgName: "",
      resultCategory: [],
      subCategory: [],
      situation: false,
      tabNumber: "",
      category_id: "",
      img_base_url: store.state.img_base_url,
      imgSrc: store.state.img_base_url,
    };
  },

  mounted: function () {
    let dataUrl = store.state.base_url + "Category/getAllCategory.php?key=123";
    return axios
      .get(dataUrl)
      .then((response) => {
        this.categoryDatas = response.data.categories;
        this.categoryImages = response.data.categoryFirstImage;
        for (var index in this.categoryImages) {
          this.image = this.categoryImages[index].img_url;
          break;
        }
      })
      .catch((err) => {
        console.log(err.response);
      });
  },
  methods: {
    imageChange() {
      for (var index in this.imagesDatas) {
        if (
          this.imagesDatas[index].color1_id == this.color1 &&
          this.imagesDatas[index].color2_id == this.color2
        ) {
          this.image = this.imagesDatas[index].img_url;
          break;
        }
      }
    },
    onChange(number) {
      this.tabNumber = number;
    },

    color1Click(color1_id) {
      this.color1 = color1_id;
      this.imageChange();
      this.color2Changeids();
    },
    color2Click(color2_id) {
      this.color2 = color2_id;
      this.imageChange();
      this.color1Changeids();
    },
    color2Changeids() {
      this.color2ids = [];
      for (var item in this.imagesDatas) {
        if (this.imagesDatas[item].color1_id == this.color1) {
          console.log(this.imagesDatas[item]);
          this.color2ids.push(this.imagesDatas[item].color2_id);
        }
      }
    },
    color1Changeids() {
      this.color1ids = [];
      for (var item in this.imagesDatas) {
        if (this.imagesDatas[item].color2_id == this.color2) {
          this.color1ids.push(this.imagesDatas[item].color1_id);
        }
      }
    },

    getByIdCategoryAllDatas(category_id) {
      this.tabNumber = 0;
      this.category_id = category_id;

      var imageChange = this.imageChange;

      this.color1ids = [];
      this.color2ids = [];

      this.subName1 = this.categoryDatas[this.category_id].sub1_name;
      this.subName2 = this.categoryDatas[this.category_id].sub2_name;

      var url =
        store.state.base_url + "Category/getByIdCategoryAllDatas.php?key=123";
      var datas = {
        category_id: category_id,
      };
      axios
        .post(url, JSON.stringify(datas))
        .then((response) => {
          this.color1Datas = response.data.color1datas;
          this.color2Datas = response.data.color2datas;
          this.imagesDatas = response.data.imagesdatas;

          this.color1 = this.imagesDatas[0].color1_id;
          this.color2 = this.imagesDatas[0].color2_id;

          imageChange();

          for (var item in this.color1Datas) {
            this.color1ids.push(this.color1Datas[item].color1_id);
          }
          for (var item in this.color2Datas) {
            this.color2ids.push(this.color2Datas[item].color2_id);
          }
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
