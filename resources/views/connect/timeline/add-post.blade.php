<?php
    if(Auth::user()->picture){
    $photo = Auth::user()->picture;
    }else{
    $photo = 'https://via.placeholder.com/150?text='.Auth::user()->first_name;
    }
?>
<form  id="addPost">
<div class="modal-header">
            <h6 class="modal-title">Create post</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

            <div class="row">
                <div class="col-lg-12">
            <div class="bg-white">
                <div class="post-new-contain row card-block">
                    <div class="col-md-1 col-xs-1 p-0 m-l-20">
                        <img src="{{ $photo }}" class="img-fluid img-radius"
                            alt="">
                    </div >

                        @csrf
                        <div class="col-md-10 col-xs-10">
                            <textarea id="post_content" class="form-control post-input m-b-10" name="post_content" style="border: 1px solid #ccc;"
                                rows="3" cols="10" required=""
                                placeholder="Write something..."></textarea>
                                <span class="hide red post_content">This field is required.</span>
                        </div>

                </div>

                <div class="post-new-footer b-t-muted p-15">
                    <div class="col-sm-11 col-lg-11 m-l-30 hide" id="with">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <label class="input-group-text"><i class="icofont icofont-ui-user text-muted m-0"
                                    title="Tag"></i></label>
                            </span>

                            <select class="form-control" id="mySelect2" name="tag_friends[]" multiple >
                                @if($friends->count() > 0)
                                    @foreach($friends as $fri)
                                    <option value="{{$fri->id}}">{{$fri->first_name}} {{$fri->last_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <span class="hide red mySelect2">This field is required.</span>
                    </div>
                    <div class="col-sm-11 col-lg-11 m-l-30 hide" id="locate">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <label class="input-group-text"> <i class="icofont icofont-location-pin text-muted m-0"
                                    title="Share location"></i></label>
                            </span>
                            <input type="text" id="share_location" class="form-control" name="location" placeholder="Share location">

                        </div>
                        <span class="hide red share_location">This field is required.</span>
                    </div>

                            <span class="image-upload m-r-15"
                                title="Upload image">
                                <input type="file" name="files[]" id="filer_input1" multiple="multiple">
                            </span>

                        <div id="post-buttons">


                        </div>
                </div>

            </div>
            </div>
      </div>
        </div>
        <div class="modal-footer">
            <div class="custom-select">
            <select class="options m-l-20" id="post_privacy" name="post_privacy" style="display:none;">
                <option value="0">Privacy settings</option>
                <option value="public">Public</option>
                <option value="friends" selected="selected"  >Friends</option>
                <option value="followers">Followers</option>
                <option value="only-me" >Only Me</option>
            </select>
            </div>
            <span class="hide red post_privacy">This field is required.</span>
            <button class="btn theme-outline-btn float-right" data-dismiss="modal">Cancel</button>
            <span><button type="button" disabled id="post-new"
                class="btn theme-btn waves-effect waves-light float-right"
                >Post</button></span>
          </div>
          </form>
<!-- jquery file upload js -->
<script src="{{ asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>

<script src="{{ asset('resources/assets/files/assets/pages/filer-modified/jquery.fileuploads.init.js') }}" type="text/javascript"></script>

<style type="text/css">
    .select2-search__field{
        width: 200px !important;
        padding: 3px;
    }
    .select2{
        width: 90% !important;
    }
    .select2-container .select2-selection--multiple{
        min-height: 37px !important;
    }
</style>
<script>
    var x, i, j, selElmnt, a, b, c;
    /*look for any elements with the class "custom-select":*/
    x = document.getElementsByClassName("custom-select");
    for (i = 0; i < x.length; i++) {
      selElmnt = x[i].getElementsByTagName("select")[0];
      /*for each element, create a new DIV that will act as the selected item:*/
      a = document.createElement("DIV");
      a.setAttribute("class", "select-selected");
      a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
      x[i].appendChild(a);
      /*for each element, create a new DIV that will contain the option list:*/
      b = document.createElement("DIV");
      b.setAttribute("class", "select-items select-hide");
      for (j = 1; j < selElmnt.length; j++) {
        /*for each option in the original select element,
        create a new DIV that will act as an option item:*/
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function(e) {
            /*when an item is clicked, update the original select box,
            and the selected item:*/
            var y, i, k, s, h;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            h = this.parentNode.previousSibling;
            for (i = 0; i < s.length; i++) {
              if (s.options[i].innerHTML == this.innerHTML) {
                s.selectedIndex = i;
                h.innerHTML = this.innerHTML;
                y = this.parentNode.getElementsByClassName("same-as-selected");
                for (k = 0; k < y.length; k++) {
                  y[k].removeAttribute("class");
                }
                this.setAttribute("class", "same-as-selected");
                break;
              }
            }
            h.click();
        });
        b.appendChild(c);
      }
      x[i].appendChild(b);
      a.addEventListener("click", function(e) {
          /*when the select box is clicked, close any other select boxes,
          and open/close the current select box:*/
          e.stopPropagation();
          closeAllSelect(this);
          this.nextSibling.classList.toggle("select-hide");
          this.classList.toggle("select-arrow-active");
        });
    }
    function closeAllSelect(elmnt) {
      /*a function that will close all select boxes in the document,
      except the current select box:*/
      var x, y, i, arrNo = [];
      x = document.getElementsByClassName("select-items");
      y = document.getElementsByClassName("select-selected");
      for (i = 0; i < y.length; i++) {
        if (elmnt == y[i]) {
          arrNo.push(i)
        } else {
          y[i].classList.remove("select-arrow-active");
        }
      }
      for (i = 0; i < x.length; i++) {
        if (arrNo.indexOf(i)) {
          x[i].classList.add("select-hide");
        }
      }
    }
</script>
