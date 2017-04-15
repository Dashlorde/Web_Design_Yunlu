<!DOCTYPE html>
<html>
<?php 
include "navBar.php";

 $friendId=$_GET["friendId"];
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>my photo</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/imagesloaded@4.1/imagesloaded.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.js"></script>
     <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
     <script src="script/photo.js"></script>
    <title>my photo</title>

    <style>
         body{z-index: 1;}

    body:before{
            content: "";
            position: fixed;
            background-image: url("img/background3.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;            
            width: 100%;
            height: 100%;
            opacity: 0.8;
            z-index:-1;
            
        }
        .container{
            /*background-color: white;*/
            padding: 30px;
        }

        #photonav a{
            color: white;
        }
        
        #photonav {
            font-family: Papyrus;
        }

        
        .grid {
            margin-top: 40px;
        }
        
        .thumbnail:hover .image {
            opacity: 0.8;
        }

        .thumbnail:hover .over {
            opacity: 1;
        }

        #addnew:hover {
            color: black;
        }
        
        .over {
            opacity: 0;
            position: absolute;
            top: 30px;
            right: 10px;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%)
        }

        .userlike{
            color: red;
        }
    </style>
</head>
<?php include "db.php"; ?>

<body>
    <main>

        <div class="container">
        <div id="tabs">
            <ul class="nav nav-tabs" id="photonav">
                <li class="active"><a data-toggle="tab" href="#photowall" id="nav1">Photo Wall</a></li>
                <li><a data-toggle="tab" href="#like" id="nav2">Friend Like</a></li>
                
            </ul>
        </div>
        

            <div class="tab-content">
                <div id="photowall" class="tab-pane fade in active" role="tabpanel">
                    <div class="modal fade text-center" id="myModel" tabindex="-1" aria-labelledby="myModelLabel" area-hidden="true">
                        <div class="modal-dialog modal-lg" style="display: inline-block; width: auto;">
                            <div class="modal-content">

                                <img src="" class="showPic" width=700px>
                                <div class="modal-footer">     
                                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row grid">
                        <?php
                                    //get all the user liked post
                                    $postquery="SELECT Post_Id FROM UserLike WHERE User_Id='$currentId'";
                                    $likedresult=mysqli_query($conn, $postquery);
                                    $likedPost=Array();
                                    while($row = mysqli_fetch_assoc($likedresult)){
                                        array_push($likedPost, $row['Post_Id']);
                                    }

                                    //get all user's posts
                                    $sql="SELECT Photo_Path, Post_Id FROM Post WHERE User_Id='$friendId' ";
                                    $result=mysqli_query($conn, $sql);

                                    
                                    //display all post
                                    while($row = mysqli_fetch_assoc($result)){
                                        $image = $row['Photo_Path'];
                                        $id = $row['Post_Id'];
                                        
                         ?>
                            
                               
                                    <div class='col-md-4 col-sm-6 col-lg-3 item'>
                                   
                                        <div class='thumbnail'>
                                             <a data-toggle="modal" data-target="#myModel"><img src='<?php echo $image; ?>' id='<?php echo $id; ?>' class='image getSrc'/></a>
                                            
                                             <div class="over">
                                              <?php 
                                              //if user liked the post, then display remove-like button
                                              if(in_array($id, $likedPost)){ ?>
                                              <a href="controller/photo-action.php?friendRemoveLike=<?php echo $id; ?>&friendId=<?php echo $friendId; ?>" class="btn btn-default"><span class="glyphicon glyphicon-heart userlike"></span></a>

                                               <?php }

                                               //if user does not add post to like, then display add-to-like button
                                                else{ ?>
                                                    <a href="controller/photo-action.php?friendAddToLike=<?php echo $id; ?>&friendId=<?php echo $friendId; ?>" class="btn btn-default"><span class="glyphicon glyphicon-heart-empty"></span></a>
                                               <?php } ?>
                                                
                                             </div>
                                             
                                        </div>
                                    </div>

                                <?php

                                    }
                                ?>                            
                        </div>
                </div>

                <div id="like" class="tab-pane fade" role="tabpanel">


                <div class="modal fade text-center" id="tabModel" tabindex="-1" aria-labelledby="myModelLabel" area-hidden="true">
                        <div class="modal-dialog modal-lg" style="display: inline-block; width: auto;">
                            <div class="modal-content">

                                <img src="" class="showPic" width=700px>
                                <div class="modal-footer">
                                    <!--button class="btn btn-danger deletePic" type="button" id="" onclick="return Deleteqry();" style="float: left;">Delete</button-->
                                   
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                </div>

                <div class="row grid">
                    <?php 

                        $sql="SELECT Photo_Path, Post_Id FROM Post WHERE Post_Id in (SELECT Post_Id FROM UserLike WHERE User_Id='$friendId')";
                        $result=mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)){
                            $image = $row['Photo_Path'];
                            $id= $row['Post_Id'];

                            ?>
                                    <div class='col-md-4 col-sm-6 col-lg-3 item'>
                                   
                                        <div class='thumbnail'>
                                             <a data-toggle="modal" data-target="#tabModel"><img src='<?php echo $image; ?>' id='<?php echo $id; ?>' class='image getSrc'/></a>
                                             <div class="over">
                                               <?php 
                                              //if user liked the post, then display remove-like button
                                              if(in_array($id, $likedPost)){ ?>
                                              <a href="controller/photo-action.php?friendRemoveLikeTab=<?php echo $id; ?>&friendId=<?php echo $friendId; ?>" class="btn btn-default"><span class="glyphicon glyphicon-heart userlike"></span></a>

                                               <?php }

                                               //if user does not add post to like, then display add-to-like button
                                                else{ ?>
                                                    <a href="controller/photo-action.php?friendAddToLikeTab=<?php echo $id; ?>&friendId=<?php echo $friendId; ?>" class="btn btn-default"><span class="glyphicon glyphicon-heart-empty"></span></a>
                                               <?php } ?>
                                                
                                            
                                             </div>
                                             
                                        </div>
                                    </div>

                                <?php
                                    }
                                ?>             
                    
                </div>
                       
                </div>
            </div>
        </div>

    </main>

    <footer class="text-center">
        <a class="up-arrow" href="#" title="TO TOP"> <span class="glyphicon glyphicon-chevron-up"></span></a><br> <br>
        <p>&copy;Web Design Final</p>
    </footer>

    <script>

    //get the src in each pic and pass src to the modal panel
    $('.getSrc').click(function(){
        var src = $(this).attr('src'); 
        $('.showPic').attr('src', src);
        var id = $(this).attr('id');
        $('.deletePic').attr('id', id);
        
    });
    </script>
</body>

</html>