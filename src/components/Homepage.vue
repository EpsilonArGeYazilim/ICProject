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
                SELECTED COLOUR FOR
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      data-toggle="tab"
                      href="#countertop"
                      role="tab"
                      aria-controls="countertop"
                      aria-selected="true"
                      >Countertop</a
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
                      >Furniture</a
                    >
                  </li>
                </ul>
                <div
                  class="tab-pane fade show active"
                  id="countertop"
                  role="tabpanel"
                >
                  <input
                    class="icons"
                    type="image"
                    src="images/color/1.jpg"
                    onclick="document.getElementById('myImage').src='images/2.jpg'"
                    width="80px"
                    height="80px"
                  />
                </div>
                <div class="tab-pane fade" id="furniture" role="tabpanel">
                  <p>dfghjklsçfdmknkjdsfln</p>
                </div>
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
                <input
                  class="ambients"
                  type="image"
                  src="images/ambients/2.jpg"
                  onclick="document.getElementById('myImage').src='images/ambients/2.jpg'"
                  width="100%"
                  height="80%"
                />
                <h5 style="text-align: center"></h5>
                <input
                  class="ambients"
                  type="image"
                  src="images/ambients/3.jpg"
                  onclick="document.getElementById('myImage').src='images/ambients/3.jpg'"
                  width="100%"
                  height="80%"
                />
                <h5 style="text-align: center"></h5>
                <input
                  class="ambients"
                  type="image"
                  src="images/ambients/4.jpg"
                  onclick="document.getElementById('myImage').src='images/ambients/4.jpg'"
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
              >
                asdfghjklşwertyuıopğüçmnbvcxzasdfghjklşğpoıuytewqasxcvbbnmloıuyt...
              </div>
            </div>
          </div>
        </nav>
      </div>
    </nav>

    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
      <img id="myImage" src="images/1.jpg" style="width: 100%" />

      <button onclick="document.getElementById('myImage').src='images/2.jpg'">
        2
      </button>

      <button onclick="document.getElementById('myImage').src='images/3.jpg'">
        3
      </button>
      <button onclick="document.getElementById('myImage').src='images/4.jpg'">
        4
      </button>

      <button onclick="document.getElementById('myImage').src='images/5.jpg'">
        5
      </button>
      <button onclick="document.getElementById('myImage').src='images/6.jpg'">
        6
      </button>

      <button onclick="document.getElementById('myImage').src='images/7.jpg'">
        7
      </button>
    </div>
  </div>
</template>