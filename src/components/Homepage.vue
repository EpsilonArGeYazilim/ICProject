<template>
  <div class="row" style="height: 655px">
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

        <!-- Tab panes BURDA CAT_İD YE GÖRE STANDART BELİRLENECEK-->
        <div class="tab-content tabContainer">
          <div id="tab-1" class="container tab-pane active">
            <img width="100%" />
            <input
              v-for="(item, index) in categoryDatas"
              :key="index"
              type="image"
              :src="img_base_url + 'Img/' + categoryImages[index].img_url"
              @click="getByIdCategoryAllDatas(categoryDatas[index].category_id)"
              width="100%"
              height="80%"
            />
          </div>

          <!-- üst kısım ambiance kısmı -->
          <div id="tab-2" class="container tab-pane">
            <br />
            <img width="100%" />
            <!-- subcategory isimlerinin çekildiği yer BURASI DEĞİŞMEYECEK SUBCATEGORY NAME SABİT-->
            <ul class="nav nav-tabs tabLi" style="width: 250px">
              <li class="nav-item">
                <a
                  class="nav-link active"
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
            <div
              v-if="tabNumber == 0"
              class="tab-pane fade show active"
              id="tab-3"
              role="tabpanel"
              style="float: left; padding: 5px"
            >
              <input
                v-for="(item, index) in color1Datas"
                :key="index"
                class="icons"
                type="image"
                :src="img_base_url + 'ImgColor/' + item.color1_url"
                alt=""
                @click="color1Click(item.color1_id)"
                width="80px"
                height="80px"
                style="border-radius: 50%"
              />
              <!--UFAK RESİMLER ÜSTTEN ÇEKİLİYO-->
            </div>

            <div
              v-if="tabNumber == 1"
              class="tab-pane fade"
              id="tab-4"
              role="tabpanel"
              style="float: left; padding: 5px"
            >
              <input
                v-for="(item, index) in color2ids"
                :key="index"
                class="icons"
                type="image"
                :src="img_base_url + 'ImgColor/' + color2Datas[item].color2_url"
                alt=""
                @click="color2Click(item.color2_id)"
                width="80px"
                height="80px"
                style="border-radius: 50%"
              />
              <!--UFAK RESİMLER ÜSTTEN ÇEKİLİYO 2-->
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div role="main" class="ml-sm-auto col-12">
      <img
        style="height: 657px; width: 100%"
        :src="img_base_url + 'Img/' + img"
      />
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
      img: "",
      tabNumber: "",
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
        this.categoryDatas = response.data.categories;
        this.categoryImages = response.data.categoryFirstImage;
        for (var index in this.categoryImages) {
          this.img = this.categoryImages[index].img_url; // geçici
          break;
        }
       // console.log(this.categoryDatas);
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
    imageChange() {
      this.image =
        this.color1 + "_" + this.color2 + "_" + this.category_id + ".jpg";
    },
    onChange(number) {
      this.tabNumber = number;
    },
    getImage2(img_url) {
      this.img = img_url;
      //console.log(this.img);
    },
    color1Click(color1_id) {
      this.color1 = color1_id;
    
      this.color2Changeids();
      this.imageChange();
    },
    color2Click(color2_id) {
      this.color1 = color2_id;
      
      this.color1Changeids();
      this.imageChange();
    },
    color2Changeids() {
      this.color2ids = [];
      for (var item in this.imagesDatas) {
    
        if (this.imagesDatas[item].color1_id == this.color1) {
            console.log(this.imagesDatas[item])
          this.color2ids.push(this.imagesDatas[item].color2_id);
         // console.log("color2changeids bulundu ");
         
        }
      }
     // console.log(this.color2ids);
    },
    color1Changeids() {
      this.color1ids = [];
      for (item in this.imagesDatas) {
        if (item.color2_id == this.color2) {
          this.color1ids.add.item(item.color1_id);
         
         // console.log("color1changeids bulundu ");
          
        }
      }
    },

    getByIdCategoryAllDatas(category_id) {
      this.tabNumber = 0;
      this.category_id = category_id;
     // console.log(category_id);

      this.subName1 = this.categoryDatas[this.category_id].sub1_name;
      this.subName2 = this.categoryDatas[this.category_id].sub2_name;

      var url =
        store.state.base_url + "Category/getByIdCategoryAllDatas.php?key=123";
      var datas = {
        category_id: category_id,
      };
      return axios
        .post(url, JSON.stringify(datas))
        .then((response) => {
          this.color1Datas = response.data.color1datas;
          this.color2Datas = response.data.color2datas;
          this.imagesDatas = response.data.imagesdatas;
        
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
