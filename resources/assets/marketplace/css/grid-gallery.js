const root = document.querySelector("body, html");
const container = document.querySelector('.gg-container');
const images = document.querySelectorAll(".gg-box > img");
const l = images.length;

for(var i = 0; i < l; i++) {
  images[i].addEventListener("click", function(i) {
    var currentImg = this;
    const parentItem = currentImg.parentElement, screenItem = document.createElement('div');
    screenItem.id = "gg-screen";
    container.prepend(screenItem);
    if (parentItem.hasAttribute('data-theme')) screenItem.setAttribute("data-theme", "dark");
    var route = currentImg.src;
    root.style.overflow = 'hidden';
    screenItem.innerHTML = '<div class="gg-image" style="width:72%;float:left;left:0;height:97vh"></div><div class="gg-close gg-btn" style="z-index:99999">&times</div><div class="gg-next gg-btn" style="z-index:99999">&rarr;</div><div class="gg-prev gg-btn" style="z-index:99999">&larr;</div><div class="gg-image-right" style="background-color:white;padding:20px;position:absolute;width:27%;float:right;right:0;height:97vh;color:red;font-size:24px;overflow-y:scroll;text-align:left"><div class=""> <div class="timeline-details"> <div class="chat-header">Josephin Doe posted on your timeline</div><p class="text-muted">lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea </p></div></div><div class="b-t-theme social-msg"> <a href="#"> <i class="icofont icofont-heart-alt text-muted"> </i> <span class="b-r-theme">Like (20)</span> </a> <a href="#"> <i class="icofont icofont-comment text-muted"> </i> <span class="b-r-theme">Comments (25)</span> </a> <a href="#"> <i class="icofont icofont-share text-muted"> </i> <span>Share (10)</span> </a> </div><div class="card-block user-box"><hr><div class="media"> <a class="" href="#"> <img class="media-object img-radius m-r-20" src="../files/assets/images/avatar-1.jpg" alt="Generic placeholder image"> </a> <div class="media-body b-b-theme social-client-description"> <div class="chat-header text-left">About Marta Williams<br><span class="text-muted">Jane 04, 2015</span></div><p class="text-muted text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p></div></div><div class="media"> <a class="" href="#"> <img class="media-object img-radius m-r-20" src="../files/assets/images/avatar-2.jpg" alt="Generic placeholder image"> </a> <div class="media-body b-b-theme social-client-description"> <div class="chat-header text-left">About Marta Williams<br><span class="text-muted">Jane 10, 2015</span></div><p class="text-muted text-left">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p></div></div><div class="media"> <a class="" href="#"> <img class="media-object img-radius m-r-20" src="../files/assets/images/avatar-1.jpg" alt="Generic placeholder image"> </a> <div class="media-body"> <form class="form-material right-icon-control"> <div class="form-group form-default"> <textarea class="form-control" required=""></textarea> <span class="form-bar"></span> <label class="float-label">Write something.....</label> </div><div class="form-icon "> <button class="btn theme-outline-btn btn-icon waves-effect waves-light"> <i class="fa fa-paper-plane "></i> </button> </div></form> </div></div></div></div>';
    const first = images[0].src, last = images[l-1].src;
    const imgItem = document.querySelector(".gg-image"), prevBtn = document.querySelector(".gg-prev"), nextBtn = document.querySelector(".gg-next"), close = document.querySelector(".gg-close");
    imgItem.innerHTML = '<img src="' + route + '">';

    if (l > 1) {
      if (route == first) {
        prevBtn.hidden = true;
        var prevImg = false;
        var nextImg = currentImg.nextElementSibling;
      }
      else if (route == last) {
        nextBtn.hidden = true;
        var nextImg = false;
        var prevImg = currentImg.previousElementSibling;
      }
      else {
        var prevImg = currentImg.previousElementSibling;
        var nextImg = currentImg.nextElementSibling;
      }
    }
    else {
      prevBtn.hidden = true;
      nextBtn.hidden = true;
    }

    screenItem.addEventListener("click", function(e) {
      if (e.target == this || e.target == close) hide();
    });

    root.addEventListener("keydown", function(e) {
      if (e.keyCode == 37 || e.keyCode == 38) prev();
      if (e.keyCode == 39 || e.keyCode == 40) next();
      if (e.keyCode == 27 ) hide();
    });

    prevBtn.addEventListener("click", prev);
    nextBtn.addEventListener("click", next);

    function prev() {
      prevImg = currentImg.previousElementSibling;
      imgItem.innerHTML = '<img src="' + prevImg.src + '">';
      currentImg = currentImg.previousElementSibling;
      var mainImg = document.querySelector(".gg-image > img").src;
      nextBtn.hidden = false;
      prevBtn.hidden = mainImg === first;
    };

    function next() {
      nextImg = currentImg.nextElementSibling;
      imgItem.innerHTML = '<img src="' + nextImg.src + '">';
      currentImg = currentImg.nextElementSibling;
      var mainImg = document.querySelector(".gg-image > img").src;
      prevBtn.hidden = false;
      nextBtn.hidden = mainImg === last;
    };

    function hide() {
      root.style.overflow = 'auto';
      screenItem.remove();
    };
  });
}

function gridGallery (options) {
  if (options.selector) selector = document.querySelector(options.selector);
  if (options.darkMode) selector.setAttribute("data-theme", "dark");
  if (options.layout == "horizontal" || options.layout == "square") selector.setAttribute("data-layout", options.layout);
  if (options.gaplength) selector.style.setProperty('--gap-length', options.gaplength + 'px');
  if (options.rowHeight) selector.style.setProperty('--row-height', options.rowHeight + 'px');
  if (options.columnWidth) selector.style.setProperty('--column-width', options.columnWidth + 'px');
}