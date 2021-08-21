<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Html Editor</title>

        <!-- Bootstrap -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.8.0/styles/default.min.css">

        <link rel="stylesheet" href="./css/theme.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap-colorselector.css" />


         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
            <script src="https://cdn.jsdelivr.net/ace/1.2.0/min/ace.js"></script>
            <script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
            <script src="js/bootstrap-colorselector.js"></script>

            <script> var path = '';</script>
            <script  src="./js/app.js"></script>

            <style>
            .lyrow{
                margin-bottom:10px;
            }
            </style>

    </head>
    <body class="edit">
        <div class="navbar navbar-inverse navbar-fixed-top navbar-htmleditor">
            <div class="navbar-header">
                <button data-target="navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                    <span class="glyphicon-bar"></span>
                    <span class="glyphicon-bar"></span>
                    <span class="glyphicon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Htmleditor</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav" id="menu-htmleditor">
                    <li>
                        <div class="btn-group" data-toggle="buttons-radio">
                            <button type="button" id="edit" class="active btn btn-primary"><i class="glyphicon glyphicon-edit "></i> Edit</button>
                            <button type="button" class="btn btn-primary" id="sourcepreview"><i class="glyphicon-eye-open glyphicon"></i> Preview</button>
                            <button type="button" id="save" class="btn btn-warning float-right"><i class="fa fa-save"></i>&nbsp;save</button>
                        </div>
                        &nbsp;
                        <div class="btn-group" data-toggle="buttons-radio" id='add' style='display: none;'>
                            <button type="button" class="active btn btn-default" id="pc"><i class="fa fa-laptop"></i> Desktop</button>
                            <button type="button" class="btn btn-default" id="tablet"><i class="fa fa-tablet"></i> Tablet</button>
                            <button type="button" class="btn btn-default" id="mobile"><i class="fa fa-mobile"></i> Mobile</button>
                        </div>
                    </li>



                </ul>

            </div><!--/.navbar-collapse -->

        </div><!--/.navbar-fixed-top -->

        <div class="container">
            <div class="row">
                <div class="">
                    <div class="sidebar-nav">

                        <ul class="nav nav-list ">
                            <li class="nav-header">
                                <i class="fa fa fa-th"> </i>&nbsp;    Grid System
                            </li>
                            <li class="rows" id="estRows">
                                <div class="lyrow">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon-remove glyphicon"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <a href="#" class="btn btn-info btn-xs clone"><i class="fa fa-clone"></i></a>

                                    <div class="preview"><input type="text" value="12" class="form-control"></div>
                                    <div class="view">
                                        <div class="row clearfix">
                                            <div class="col-md-12 column"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="lyrow">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon-remove glyphicon"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <a href="#" class="btn btn-info btn-xs clone"><i class="fa fa-clone"></i></a>
                                    <div class="preview"><input type="text" value="6 6" class="form-control"></div>
                                    <div class="view">
                                        <div class="row clearfix">
                                            <div class="col-md-6 column"></div>
                                            <div class="col-md-6 column"></div>
                                        </div>
                                    </div>
                                </div>


                                <div class="lyrow">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon-remove glyphicon"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <a href="#" class="btn btn-info btn-xs clone"><i class="fa fa-clone"></i></a>
                                    <div class="preview"><input type="text" value="8 4" class="form-control"></div>
                                    <div class="view">
                                        <div class="row clearfix">
                                            <div class="col-md-8 column"></div>
                                            <div class="col-md-4 column"></div>
                                        </div>
                                        <br>
                                    </div>
                                </div>

                                <div class="lyrow">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon-remove glyphicon"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <a href="#" class="btn btn-info btn-xs clone"><i class="fa fa-clone"></i></a>
                                    <div class="preview"><input type="text" value="4 8" class="form-control"></div>
                                    <div class="view">
                                        <div class="row clearfix">
                                            <div class="col-md-4 column"></div>
                                            <div class="col-md-8 column"></div>
                                        </div>
                                        <br>
                                    </div>
                                </div>


                                <div class="lyrow">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon-remove glyphicon"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <a href="#" class="btn btn-info btn-xs clone"><i class="fa fa-clone"></i></a>
                                    <div class="preview"><input type="text" value="3 9" class="form-control"></div>
                                    <div class="view">
                                        <div class="row clearfix">
                                            <div class="col-md-3 column"></div>
                                            <div class="col-md-9 column"></div>
                                        </div>
                                        <br>
                                    </div>
                                </div>

                                <div class="lyrow">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon-remove glyphicon"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <a href="#" class="btn btn-info btn-xs clone"><i class="fa fa-clone"></i></a>
                                    <div class="preview"><input type="text" value="9 3" class="form-control"></div>
                                    <div class="view">
                                        <div class="row clearfix">
                                            <div class="col-md-9 column"></div>
                                            <div class="col-md-3 column"></div>
                                        </div>
                                        <br>
                                    </div>
                                </div>


                                <div class="lyrow">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon-remove glyphicon"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <a href="#" class="btn btn-info btn-xs clone"><i class="fa fa-clone"></i></a>
                                    <div class="preview"><input type="text" value="4 4 4" class="form-control"></div>
                                    <div class="view">
                                        <div class="row clearfix">
                                            <div class="col-md-4 column"></div>
                                            <div class="col-md-4 column"></div>
                                            <div class="col-md-4 column"></div>
                                        </div>
                                        <br>
                                    </div>
                                </div>

                                <div class="lyrow">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon-remove glyphicon"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <a href="#" class="btn btn-info btn-xs clone"><i class="fa fa-clone"></i></a>
                                    <div class="preview"><input type="text" value="3 3 3 3" class="form-control"></div>
                                    <div class="view">
                                        <div class="row clearfix">
                                            <div class="col-md-3 column"></div>
                                            <div class="col-md-3 column"></div>
                                            <div class="col-md-3 column"></div>
                                            <div class="col-md-3 column"></div>
                                        </div>
                                        <br>
                                    </div>
                                </div>


                            </li>
                        </ul>
                        <br>
                        <ul class="nav nav-list">
                            <li class="nav-header"><i class="fa fa-html5"></i>&nbsp;  Html Elements

                            </li>
                            <li class="boxes" id="elmBase">

                                <!--
                                <div class="box box-element" data-type="header">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <span class="configuration">
                                        <a class="btn btn-xs btn-warning settings"  href="#" ><i class="fa fa-gear"></i></a>
                                    </span>

                                    <div class="preview">
                                        <i class="fa fa-header fa-2x"></i>
                                        <div class="element-desc">header</div>
                                    </div>
                                    <div class="view">
                                        <h2>HEADER TITLE</h2>
                                    </div>
                                </div>
                                -->

                                <!-- elemento paragraph -->
                                <div class="box box-element" data-type="paragraph">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <span class="configuration">
                                        <a class="btn btn-xs btn-warning settings"  href="#" ><i class="fa fa-gear"></i></a>
                                    </span>

                                    <div class="preview">
                                        <i class="fa fa-font fa-2x"></i>
                                        <div class="element-desc">Paragraph</div>
                                    </div>
                                    <div class="view">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisci elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrum exercitationem ullam
                                           corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident,
                                           sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                    </div>
                                </div>
                                <!-- Image -->
                                <div class="box box-element" data-type="image">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <span class="configuration">
                                        <a class="btn btn-xs btn-warning settings"  href="#" ><i class="fa fa-gear"></i></a>
                                    </span>
                                    <div class="preview">
                                        <i class="fa fa-picture-o fa-2x"></i>
                                        <div class="element-desc">Image</div>
                                    </div>
                                    <div class="view">
                                        <img src="http://placehold.it/350x150" class="img-responsive"  title="default title"/>
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="box box-element" data-type="button">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <span class="configuration">
                                        <a class="btn btn-xs btn-warning settings"  href="#" ><i class="fa fa-gear"></i></a>
                                    </span>

                                    <div class="preview">
                                        <i class="fa  fa-hand-pointer-o fa-2x"></i>
                                        <div class="element-desc">Button</div>
                                    </div>
                                    <div class="view">
                                        <a class="btn btn-default" href="#">Click Me !</a>
                                    </div>
                                </div>

                                <!-- Youtube -->
                                <div class="box box-element" data-type="youtube">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <span class="configuration">
                                        <a class="btn btn-xs btn-warning settings"  href="#" ><i class="fa fa-gear"></i></a>
                                    </span>

                                    <div class="preview">
                                        <i class="fa  fa fa-youtube-play  fa-2x"></i>
                                        <div class="element-desc">Youtube</div>
                                    </div>
                                    <div class="view">
                                        <iframe class="img-responsive" src="https://www.youtube.com/embed/WIJaD623dy0" frameborder="0" allowfullscreen data-url=""></iframe>
                                    </div>
                                </div>
                                <!-- Vimeo -->
                                <div class="box box-element" data-type="youtube">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <span class="configuration">
                                        <a class="btn btn-xs btn-warning settings"  href="#" ><i class="fa fa-gear"></i></a>
                                    </span>

                                    <div class="preview">
                                        <i class="fa  fa-vimeo-square fa-2x"></i>
                                        <div class="element-desc">Vimeo</div>
                                    </div>
                                    <div class="view">
                                        <iframe class="img-responsive" src="https://player.vimeo.com/video/137463767?byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                    </div>
                                </div>

                                <!-- map -->
                                <div class="box box-element" data-type="map">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <span class="configuration">
                                        <a class="btn btn-xs btn-warning settings"  href="#" ><i class="fa fa-gear"></i></a>
                                    </span>

                                    <div class="preview">
                                        <i class="fa  fa-map-o fa-2x"></i>
                                        <div class="element-desc">Map</div>
                                    </div>
                                    <div class="view">
                                        <iframe class="img-responsive" src="http://maps.google.com/maps?q=12.927923,77.627108&z=15&output=embed"  frameborder="0" allowfullscreen data-url=""></iframe>
                                    </div>
                                </div>
                                <!-- code -->
                                <div class="box box-element" data-type="code">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <span class="configuration">
                                        <a class="btn btn-xs btn-warning settings" href="#" ><i class="fa fa-gear"></i></a>
                                    </span>
                                    <div class="preview">
                                        <i class="fa">< ></i>
                                        <div class="element-desc">Code</div>
                                    </div>
                                    <div class="view">
                                        i'm html code, change me
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--/span-->
                <div class="htmlpage">

                </div>

                <!--/row-->

            </div><!--/.fluid-container-->



            <div class="modal fade" id="download" tabindex="-1" role="dialog" aria-labelledby="download" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class='fa fa-save'></i>&nbsp;Save as </h4>
                        </div>

                        <div class="modal-body" id='sourceCode'>
                            <textarea id="src" rows="10"></textarea>
                            <textarea id="model" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class='fa fa-close'></i>&nbsp;Close</button>
                            <button type="button" class="btn btn-success" id="srcSave"><i class='fa fa-save'></i>&nbsp;Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="preferences" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="preferencesTitle"></h4>
                        </div>
                        <div class="modal-body" id="preferencesContent">
                           <!--<iframe src="media-popup.php" style="width:100%; height:300px ; display:none;" frameborder="0" ></iframe>-->
                           <div  id="mediagallery"  style="overflow:auto;height:400px; display:none" >
                            <?php include "media-popup.php";?>
                            <a class="btn btn-info" href="javascript:;" onclick="$('#mediagallery').hide();$('#thepref').show();">Return to image settings</a>
                           </div>
                            <div id="thepref">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#Settings" aria-controls="Settings" role="tab" data-toggle="tab">Settings</a></li>
                                    <li role="presentation"><a href="#CellSettings" aria-controls="profile" role="tab" data-toggle="tab">Cell settings</a></li>
                                    <li role="presentation"><a href="#RowSettings" aria-controls="messages" role="tab" data-toggle="tab">Row settings</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="Settings">
                                        <!-- header -->
                                        <div class="panel panel-body">
                                            <div id="ht" style="display: none;">
                                                <textarea id="html5editorLite"></textarea>
                                            </div>
                                            <!-- fine header -->
                                            <!-- text -->
                                            <div id="text" style="display: none;">
                                                <textarea id="html5editor"></textarea>
                                            </div>
                                            <!-- end text -->
                                            <!-- settaggio immagine -->
                                            <div id="image" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-5" >
                                                        <div id="imgContent">

                                                        </div>
                                                        <a class="btn btn-default form-control" href="#" id="gallery"><i class="icon-upload-alt"></i>&nbsp;Browse ...</a>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <label for="img-url">Url :</label>
                                                            <input type="text" value="" id="img-url" class="form-control" />
                                                        </div>
                                                        <!--   <div class="form-group">
                                                               <label for="img-url">Click Url:</label>
                                                               <input type="text" value="" id="img-clickurl" class="form-control" />
                                                           </div>
                                                        -->
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="img-width">Width :</label>
                                                                    <input type="text" value="" id="img-width" class="form-control"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="img-height">Height :</label>
                                                                    <input type="text" value="" id="img-height" class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="img-title">Title : </label>
                                                            <input type="text" value="" id="img-title" class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="img-rel">Rel :</label>
                                                            <input type="text" value="" id="img-rel" class="form-control"/>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                            <!-- fine settaggi immagine -->

                                            <!-- settaggio youtube -->
                                            <div id="youtube"  style="display:none">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div id="youtube-video">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form>
                                                            <div class="form-group">
                                                                <label for="video-url">Video id :</label>
                                                                <input type="text" value="" id="video-url" class="form-control" />
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="video-width">Width :</label>
                                                                        <input type="text" value="" id="video-width" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="video-height">Height :</label>
                                                                        <input type="text" value="" id="video-height" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- fine settagio youtube -->
                                            <!-- settaggio mappa -->
                                            <div id="map" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div id="map-content">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form>
                                                            <div class="form-group">
                                                                <label for="address">Latitude :</label>
                                                                <input type="text" value="" id="latitude" class="form-control" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="address">Longitude :</label>
                                                                <input type="text" value="" id="longitude" class="form-control" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="address">Zoom :</label>
                                                                <input type="text" value="" id="zoom" class="form-control" />
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="img-width">Width :</label>
                                                                        <input type="text" value="" id="map-width" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="img-height">Height :</label>
                                                                        <input type="text" value="" id="map-height" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- settaggio bottone -->
                                            <div id="buttons" style="display:none">
                                                <div id="buttonContainer"></div>
                                                <br>
                                                <div class="form-group">
                                                    <label> Label :  </label>
                                                    <input type="text" class="form-control" id="buttonLabel"/>
                                                </div>

                                                <div class="form-group">
                                                    <label> Href :  </label>
                                                    <input type="text" class="form-control" id="buttonHref"/>
                                                </div>
                                                <span class="btn-group btn-group-xs">
                                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">Styles <span class="caret"></span></a>
                                                    <ul class="dropdown-menu">
                                                        <li class="" ><a href="#" class="btnpropa" rel="btn-default">Default</a></li>
                                                        <li class="" ><a href="#" class="btnpropa" rel="btn-primary">Primary</a></li>
                                                        <li class="" ><a href="#" class="btnpropa" rel="btn-success">Success</a></li>
                                                        <li class="" ><a href="#" class="btnpropa" rel="btn-info">Info</a></li>
                                                        <li class="" ><a href="#" class="btnpropa" rel="btn-warning">Warning</a></li>
                                                        <li class="" ><a href="#" class="btnpropa" rel="btn-danger">Danger</a></li>
                                                        <li class="" ><a href="#" class="btnpropa" rel="btn-link">Link</a></li>
                                                    </ul>
                                                </span>
                                                <span class="btn-group btn-group-xs">
                                                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">Size <span class="caret"></span></a>
                                                    <ul class="dropdown-menu">
                                                        <li class="" ><a href="#" class="btnpropb" rel="btn-lg">Large</a></li>
                                                        <li class="" ><a href="#" class="btnpropb" rel="btn-default">Default</a></li>
                                                        <li class="" ><a href="#" class="btnpropb" rel="btn-sm">Small</a></li>
                                                        <li class="" ><a href="#" class="btnpropb" rel="btn-xs">Mini</a></li>
                                                    </ul>
                                                </span>
                                                <span class="btn-group btn-group-xs">
                                                    <a class="btn btn-xs btn-default btnprop" href="#" rel="btn-block">Block</a>
                                                    <a class="btn btn-xs btn-default btnprop" href="#" rel="active">Active</a>
                                                    <a class="btn btn-xs btn-default btnprop" href="#" rel="disabled">Disabled</a>
                                                </span>


                                                <br><br>
                                                <div class="form-group">
                                                    <label> Custom width / height / font-size / padding top :  </label>
                                                    <br>
                                                    <span class="btn-group">
                                                        <input type="text"  id="custombtnwidth"      style="width:20%"/>
                                                        <input type="text"  id="custombtnheight"     style="width:20%"/>
                                                        <input type="text"  id="custombtnfont"       style="width:20%"/>
                                                        <input type="text"  id="custombtnpaddingtop" style="width:20%"/>
                                                    </span>
                                                </div>
                                                <!--
                                                <div class="form-group">
                                                    <label> Align:  </label>
                                                    <br>
                                                    <span class="btn-group">
                                                        <select id="btnalign">
                                                            <option value="center">center</option>
                                                            <option value="left">left</option>
                                                            <option value="right">right</option>
                                                        </select>
                                                    </span>
                                                </div>
                                                -->

                                                <div class="form-group">
                                                    <label>Custom background color :</label>
                                                    <input type="text" class="form-control" id="colbtn" />

                                                    <select id="colorselectorbtn">
                                                        <option value="1" data-value="1" data-color="#A0522D">sienna</option>
                                                        <option value="2" data-value="2" data-color="#CD5C5C">indianred</option>
                                                        <option value="3" data-value="3" data-color="#FF4500">orangered</option>
                                                        <option value="4" data-value="4" data-color="#008B8B">darkcyan</option>
                                                        <option value="5" data-value="5" data-color="#B8860B">darkgoldenrod</option>
                                                        <option value="6" data-value="6" data-color="#32CD32">limegreen</option>
                                                        <option value="7" data-value="7" data-color="#FFD700">gold</option>
                                                        <option value="8" data-value="8" data-color="#48D1CC">mediumturquoise</option>
                                                        <option value="9" data-value="9" data-color="#87CEEB">skyblue</option>
                                                        <option value="10" data-value="10" data-color="#FF69B4">hotpink</option>
                                                        <option value="11" data-value="11" data-color="#87CEFA">lightskyblue</option>
                                                        <option value="12" data-value="12" data-color="#6495ED">cornflowerblue</option>
                                                        <option value="13" data-value="13" data-color="#DC143C">crimson</option>
                                                        <option value="14" data-value="14" data-color="#FF8C00">darkorange</option>
                                                        <option value="15" data-value="15" data-color="#C71585">mediumvioletred</option>
                                                        <option value="16" data-value="16" data-color="#000000">black</option>

                                                        <option value="17" data-value="17" data-color="#575757">grigio scuro</option>
                                                        <option value="18" data-value="18" data-color="#f2f2f2">grigio chiaro</option>
                                                        <option value="19" data-value="19" data-color="#efefef">marroncino</option>
                                                        <option value="20" data-value="20" data-color="#e7e0d8">marrone</option>
                                                        <option value="21" data-value="21" data-color="#d7d0c6">marrone scuro</option>
                                                        <option value="22" data-value="22" data-color="#263459">blu scuro</option>
                                                        <option value="23" data-value="23" data-color="#ffffff">bianco</option>

                                                    </select>
                                                    <script>
                                                    $('#colorselectorbtn').colorselector({
                                                              callback: function (value, color, title) {
                                                                  $("#colbtn").val(color);
                                                              }
                                                        });
                                                    </script>
                                                </div>

                                                <div class="form-group">
                                                    <label>Custom text color :</label>
                                                    <input type="text" class="form-control" id="colbtncol" />

                                                    <select id="colorselectorbtncol">
                                                        <option value="1" data-value="1" data-color="#A0522D">sienna</option>
                                                        <option value="2" data-value="2" data-color="#CD5C5C">indianred</option>
                                                        <option value="3" data-value="3" data-color="#FF4500">orangered</option>
                                                        <option value="4" data-value="4" data-color="#008B8B">darkcyan</option>
                                                        <option value="5" data-value="5" data-color="#B8860B">darkgoldenrod</option>
                                                        <option value="6" data-value="6" data-color="#32CD32">limegreen</option>
                                                        <option value="7" data-value="7" data-color="#FFD700">gold</option>
                                                        <option value="8" data-value="8" data-color="#48D1CC">mediumturquoise</option>
                                                        <option value="9" data-value="9" data-color="#87CEEB">skyblue</option>
                                                        <option value="10" data-value="10" data-color="#FF69B4">hotpink</option>
                                                        <option value="11" data-value="11" data-color="#87CEFA">lightskyblue</option>
                                                        <option value="12" data-value="12" data-color="#6495ED">cornflowerblue</option>
                                                        <option value="13" data-value="13" data-color="#DC143C">crimson</option>
                                                        <option value="14" data-value="14" data-color="#FF8C00">darkorange</option>
                                                        <option value="15" data-value="15" data-color="#C71585">mediumvioletred</option>
                                                        <option value="16" data-value="16" data-color="#000000">black</option>
                                                        <option value="17" data-value="17" data-color="#575757">grigio scuro</option>
                                                        <option value="18" data-value="18" data-color="#f2f2f2">grigio chiaro</option>
                                                        <option value="19" data-value="19" data-color="#efefef">marroncino</option>
                                                        <option value="20" data-value="20" data-color="#e7e0d8">marrone</option>
                                                        <option value="21" data-value="21" data-color="#d7d0c6">marrone scuro</option>
                                                        <option value="22" data-value="22" data-color="#263459">blu scuro</option>
                                                        <option value="23" data-value="23" data-color="#ffffff">bianco</option>

                                                    </select>
                                                    <script>
                                                    $('#colorselectorbtncol').colorselector({
                                                              callback: function (value, color, title) {
                                                                  $("#colbtncol").val(color);
                                                              }
                                                        });
                                                    </script>
                                                </div>


                                            </div>
                                            <!-- fine bottone-->
                                            <!-- settaggio code -->
                                            <div id="code"  style="display:none">
                                            </div>

                                            <!-- fine code -->
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label> ID :  </label>
                                                        <input type="text" readonly class="form-control" id="id"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">

                                                        <label for="class"> Css class :  </label>
                                                        <input type="text" name="class" id="class" class="form-control" />

                                                    </div>
                                                </div>
                                            </div>
                                             
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="CellSettings">
                                        <div class="panel panel-body">
                                            <table width="100%" cellpadding="5" cellspacing="0" style="border:1px solid #cccccc" id="tabCol">
                                                <tr>
                                                    <td>&nbsp;Margin</td>
                                                    <td></td>
                                                    <td><input type="text" size="4" class="form-control text-center" data-ref="margin-top" /></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td bgcolor="#f2f2f2">Padding</td>
                                                    <td bgcolor="#f2f2f2"><input type="text" size="4"  class="form-control text-center" data-ref="padding-top" /></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" size="4" class="form-control text-center" data-ref="margin-left"></td>
                                                    <td bgcolor="#f2f2f2"><input type="text" size="4"  class="form-control text-center" data-ref="padding-left"></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td bgcolor="#f2f2f2"><input type="text" size="4"  class="form-control text-center" data-ref="padding-right"></td>
                                                    <td><input type="text" size="4" class="form-control text-center" data-ref="margin-right"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td bgcolor="#f2f2f2"><input type="text" size="4"  class="form-control text-center" data-ref="padding-bottom"></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><input type="text" size="4"  class="form-control text-center" data-ref="margin-bottom"></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Background color :</label>
                                                        <input type="text" class="form-control" id="colbg" />

                                                        <select id="colorselectorbg">
                                                            <option value="1" data-value="1" data-color="#A0522D">sienna</option>
                                                            <option value="2" data-value="2" data-color="#CD5C5C">indianred</option>
                                                            <option value="3" data-value="3" data-color="#FF4500">orangered</option>
                                                            <option value="4" data-value="4" data-color="#008B8B">darkcyan</option>
                                                            <option value="5" data-value="5" data-color="#B8860B">darkgoldenrod</option>
                                                            <option value="6" data-value="6" data-color="#32CD32">limegreen</option>
                                                            <option value="7" data-value="7" data-color="#FFD700">gold</option>
                                                            <option value="8" data-value="8" data-color="#48D1CC">mediumturquoise</option>
                                                            <option value="9" data-value="9" data-color="#87CEEB">skyblue</option>
                                                            <option value="10" data-value="10" data-color="#FF69B4">hotpink</option>
                                                            <option value="11" data-value="11" data-color="#87CEFA">lightskyblue</option>
                                                            <option value="12" data-value="12" data-color="#6495ED">cornflowerblue</option>
                                                            <option value="13" data-value="13" data-color="#DC143C">crimson</option>
                                                            <option value="14" data-value="14" data-color="#FF8C00">darkorange</option>
                                                            <option value="15" data-value="15" data-color="#C71585">mediumvioletred</option>
                                                            <option value="16" data-value="16" data-color="#000000">black</option>

                                                            <option value="17" data-value="17" data-color="#575757">grigio scuro</option>
                                                            <option value="18" data-value="18" data-color="#f2f2f2">grigio chiaro</option>
                                                            <option value="19" data-value="19" data-color="#efefef">marroncino</option>
                                                            <option value="20" data-value="20" data-color="#e7e0d8">marrone</option>
                                                            <option value="21" data-value="21" data-color="#d7d0c6">marrone scuro</option>
                                                            <option value="22" data-value="22" data-color="#263459">blu scuro</option>
                                                            <option value="23" data-value="23" data-color="#ffffff">bianco</option>

                                                        </select>
                                                        <script>
                                                        $('#colorselectorbg').colorselector({
                                                                  callback: function (value, color, title) {
                                                                      $("#colbg").val(color);
                                                                  }
                                                            });
                                                        </script>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <!--
                                                    <div class="form-group">
                                                        <label>Css class :</label>
                                                        <input type="text" class="form-control" id="colcss" />
                                                    </div>
                                                -->
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="RowSettings">
                                        <div class="panel panel-body">
                                            <table width="100%" cellpadding="5" cellspacing="0" style="border:1px solid #cccccc" id="tabRow">
                                                <tr>
                                                    <td>&nbsp;Margin</td>
                                                    <td></td>
                                                    <td><input type="text" size="4" class="form-control text-center" data-ref="margin-top" /></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td bgcolor="#f2f2f2">Padding</td>
                                                    <td bgcolor="#f2f2f2"><input type="text" size="4"  class="form-control text-center" data-ref="padding-top" /></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" size="4" class="form-control text-center" data-ref="margin-left"></td>
                                                    <td bgcolor="#f2f2f2"><input type="text" size="4"  class="form-control text-center" data-ref="padding-left"></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td bgcolor="#f2f2f2"><input type="text" size="4"  class="form-control text-center" data-ref="padding-right"></td>
                                                    <td><input type="text" size="4" class="form-control text-center" data-ref="margin-right"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td bgcolor="#f2f2f2"><input type="text" size="4"  class="form-control text-center" data-ref="padding-bottom"></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><input type="text" size="4"  class="form-control text-center" data-ref="margin-bottom"></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Background color :</label>
                                                        <input type="text" class="form-control" id="rowbg" />


                                                        <select id="colorselectorrowbg">
                                                            <option value="1" data-value="1" data-color="#A0522D">sienna</option>
                                                            <option value="2" data-value="2" data-color="#CD5C5C">indianred</option>
                                                            <option value="3" data-value="3" data-color="#FF4500">orangered</option>
                                                            <option value="4" data-value="4" data-color="#008B8B">darkcyan</option>
                                                            <option value="5" data-value="5" data-color="#B8860B">darkgoldenrod</option>
                                                            <option value="6" data-value="6" data-color="#32CD32">limegreen</option>
                                                            <option value="7" data-value="7" data-color="#FFD700">gold</option>
                                                            <option value="8" data-value="8" data-color="#48D1CC">mediumturquoise</option>
                                                            <option value="9" data-value="9" data-color="#87CEEB">skyblue</option>
                                                            <option value="10" data-value="10" data-color="#FF69B4">hotpink</option>
                                                            <option value="11" data-value="11" data-color="#87CEFA">lightskyblue</option>
                                                            <option value="12" data-value="12" data-color="#6495ED">cornflowerblue</option>
                                                            <option value="13" data-value="13" data-color="#DC143C">crimson</option>
                                                            <option value="14" data-value="14" data-color="#FF8C00">darkorange</option>
                                                            <option value="15" data-value="15" data-color="#C71585">mediumvioletred</option>
                                                            <option value="16" data-value="16" data-color="#000000">black</option>

                                                            <option value="17" data-value="17" data-color="#575757">grigio scuro</option>
                                                            <option value="18" data-value="18" data-color="#f2f2f2">grigio chiaro</option>
                                                            <option value="19" data-value="19" data-color="#efefef">marroncino</option>
                                                            <option value="20" data-value="20" data-color="#e7e0d8">marrone</option>
                                                            <option value="21" data-value="21" data-color="#d7d0c6">marrone scuro</option>
                                                            <option value="22" data-value="22" data-color="#263459">blu scuro</option>
                                                            <option value="23" data-value="23" data-color="#ffffff">bianco</option>
                                                        </select>
                                                        <script>
                                                        $('#colorselectorrowbg').colorselector({
                                                                  callback: function (value, color, title) {
                                                                      $("#rowbg").val(color);
                                                                  }
                                                            });
                                                        </script>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label>Css class :</label>
                                                        <input type="text" class="form-control" id="rowcss" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Background image :</label>
                                                <input type="text" class="form-control" id="rowbgimage" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class='fa fa-close'></i>&nbsp;Close</button>
                                <button type="button" class="btn btn-primary" id="applyChanges"><i class='fa fa-check'></i>&nbsp;Apply changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Small modal for alert-->

                <!--/span-->
                <div id="download-layout"><div class="container"></div></div>
            </div>

    </body>
</html>
