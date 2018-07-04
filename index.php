<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>jQuery UI Tabs - Default functionality</title>
      <link rel="stylesheet" href="jquery-ui/jquery-ui.css">
      <script src="jquery-2.1.3.min.js"></script>
      <script src="jquery-ui/jquery-ui.js"></script>

      <!-- Bootstrap -->
      <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="mk.css" rel="stylesheet">
      <script>
      ////////////DATA/////////////////
      var categories ;
      var all_foods;
      var count ;
      var order_now; // เก็บข้อมูล order ของ โต๊ะปัจจุบัน
      //id : 1 , table_no : 5 , status : open , insert_time : 2015-03-12 23:50:53
      //order_now[0].id 

      var OrderDetailWaitConfirm; //เก็บข้อมูล OrderDetail ที่กำลังรอ confirm
      var OrderDetailConfirm;  // อันที่ confirm แล้ว เท่านั้น


      ////////////////POP UP//////////////////
      function showPopUp()
      {
         $(".popupBackground").css("visibility","visible");
         $(".popup").css("visibility","visible");
      }

      function closePopUp()
      {
         $(".popupBackground").css("visibility","hidden");
         $(".popup").css("visibility","hidden");
      }
      ///////////END POP UP///////////////////


      //////////ORDER DETAIL (ORDER FOOD) ///////////////////

      function getOrderDetail()
      {
          setTimeout(
               function()
               { 
                  $(function()
                  {
                        getOrderDetailToShow_wait_confirm();
                        getOrderDetailToShow_confirmed();
                  });
               }, 1000);

          getOrderDetailAuto();
      } 

      function getOrderDetailAuto()
      {
         setInterval(
            function()
               { 
                        getOrderDetailToShow_wait_confirm();
                        getOrderDetailToShow_confirmed();
                 
               }
               , 3000);
      } 

      function orderFood(food_id_x)
      {
         $.post( "create_order_detail.php", 
            { 
               food_id: food_id_x,
               order_id: order_now[0].id 
            })
            .done(function( data ) {
               console.log("POST ORDER DETAIL FINISH " + data );
               getOrderDetailToShow_wait_confirm();
            });
      }
      //"wait_confirm" "confirmed" "cancel" "served" 
      // สามารถมี หลายอันได้ โดยการ คั้นกันด้วย |
      function getOrderDetailToShow_wait_confirm()
      {

         $.post( "get_all_order_detail_by_order_id.php", 
            { 
               status:"wait_confirm" ,
               order_id: order_now[0].id 
            })
            .done(function( data ) {
               console.log("POST ORDER DETAIL FINISH " + data );
               showOrderDetailWaitConfirm(data);

            });
      }


      function getOrderDetailToShow_confirmed()
      {

         $.post( "get_all_order_detail_by_order_id.php", 
            { 
               status:"confirmed|served" ,
               order_id: order_now[0].id 
            })
            .done(function( data ) {
               console.log("POST ORDER DETAIL FINISH " + data );
               showOrderDetailConfirmed(data);

            });
      }

      function confirmOrderDetail(OrderDetailID)
      {
         $.post( "confirm_order_detail.php", 
            { 
               order_detail_id: OrderDetailID
            })
            .done(function( data ) {
               console.log("POST CONFIRM ORDER DETAIL FINISH " + data );
               getOrderDetailToShow_wait_confirm();
               getOrderDetailToShow_confirmed();
            });
      }


      function showOrderDetailWaitConfirm(data)
      {
          OrderDetailWaitConfirm = JSON.parse(data);
          var template = " <tr>      \
               <td>      \
               {{[[--id--]]}}  \
               </td>  \
               <td>   \
               {{[[--food_id--]]}}   \
               </td> \
               <td>   \
               {{[[--order_id--]]}}   \
               </td> \
               <td>   \
               {{[[--qty--]]}}   \
               </td> \
               <td>   \
               {{[[--status--]]}}   \
               </td>  \
               <td>   \
               {{[[--insert_time--]]}}   \
               </td>  \
               <td>   \
               {{[[--food_id_x--]]}}   \
               </td>  \
               <td>   \
               {{[[--food_name--]]}}   \
               </td>  \
               <td>   \
               {{[[--food_description--]]}}   \
               </td>    \
               <td>      \
               {{[[--food_price--]]}}   \
               </td>     \
               <td>   \
               {{[[--food_image--]]}}  \
               </td>  \
               <td>   \
               {{[[--food_cat_id--]]}}   \
               </td>   \
               <td>   \
               <button id = 'food_confirm_{{[[--id--]]}}'  order-detail-id= '{{[[--id--]]}}' >confirm</button>   \
               </td>   \
            </tr>   \
          ";

/*
               "id"=>$id,
               "food_id"=>$food_id,
               "order_id"=>$order_id,
               "qty"=>$qty,
               "status"=>$status,
               "insert_time"=>$insert_time,

               "food_id_x"=>$food_id_x,
               "food_name"=>$food_name,
               "food_description"=>$food_description,
               "food_price"=>$food_price,
               "food_image"=>$food_image,
               "food_cat_id"=>$food_cat_id,


          */

          $("#wait_confirm_table").empty();
         for(var i = 0 ; i < OrderDetailWaitConfirm.length ; i ++)
         {
            var row_now = template;
            row_now = row_now.replace("{{[[--id--]]}}",OrderDetailWaitConfirm[i].id);
            row_now = row_now.replace("{{[[--id--]]}}",OrderDetailWaitConfirm[i].id);
            row_now = row_now.replace("{{[[--id--]]}}",OrderDetailWaitConfirm[i].id);

            row_now = row_now.replace("{{[[--food_id--]]}}",OrderDetailWaitConfirm[i].food_id);
            row_now = row_now.replace("{{[[--order_id--]]}}",OrderDetailWaitConfirm[i].order_id);
            row_now = row_now.replace("{{[[--qty--]]}}",OrderDetailWaitConfirm[i].qty);
            row_now = row_now.replace("{{[[--status--]]}}",OrderDetailWaitConfirm[i].status);
            row_now = row_now.replace("{{[[--insert_time--]]}}",OrderDetailWaitConfirm[i].insert_time);
            row_now = row_now.replace("{{[[--food_id_x--]]}}",OrderDetailWaitConfirm[i].food_id_x);
            row_now = row_now.replace("{{[[--food_name--]]}}",OrderDetailWaitConfirm[i].food_name);
            row_now = row_now.replace("{{[[--food_description--]]}}",OrderDetailWaitConfirm[i].food_description);
            row_now = row_now.replace("{{[[--food_price--]]}}",OrderDetailWaitConfirm[i].food_price);
            row_now = row_now.replace("{{[[--food_image--]]}}",OrderDetailWaitConfirm[i].food_image);
            row_now = row_now.replace("{{[[--food_cat_id--]]}}",OrderDetailWaitConfirm[i].food_cat_id);
            $("#wait_confirm_table").append(row_now);

            //add event to confirm button
            $("#food_confirm_"+OrderDetailWaitConfirm[i].id).click(
               function foodconfirmBtn()
               {

                  var OrderDetailID = $(this).attr('order-detail-id');
                  confirmOrderDetail(OrderDetailID);
               });
            
         }
          //$("#wait_confirm_table")

      }

      function showOrderDetailConfirmed(data)
      {
          OrderDetailConfirm = JSON.parse(data);
          var template = " <tr>      \
               <td>      \
               {{[[--id--]]}}  \
               </td>  \
               <td>   \
               {{[[--food_id--]]}}   \
               </td> \
               <td>   \
               {{[[--order_id--]]}}   \
               </td> \
               <td>   \
               {{[[--qty--]]}}   \
               </td> \
               <td>   \
               {{[[--status--]]}}   \
               </td>  \
               <td>   \
               {{[[--insert_time--]]}}   \
               </td>  \
               <td>   \
               {{[[--food_id_x--]]}}   \
               </td>  \
               <td>   \
               {{[[--food_name--]]}}   \
               </td>  \
               <td>   \
               {{[[--food_description--]]}}   \
               </td>    \
               <td>      \
               {{[[--food_price--]]}}   \
               </td>     \
               <td>   \
               {{[[--food_image--]]}}  \
               </td>  \
               <td>   \
               {{[[--food_cat_id--]]}}   \
               </td>   \
            </tr>   \
          ";

/*
               "id"=>$id,
               "food_id"=>$food_id,
               "order_id"=>$order_id,
               "qty"=>$qty,
               "status"=>$status,
               "insert_time"=>$insert_time,

               "food_id_x"=>$food_id_x,
               "food_name"=>$food_name,
               "food_description"=>$food_description,
               "food_price"=>$food_price,
               "food_image"=>$food_image,
               "food_cat_id"=>$food_cat_id,


          */

          $("#confirmed_table").empty();
         for(var i = 0 ; i < OrderDetailConfirm.length ; i ++)
         {
            var row_now = template;
            row_now = row_now.replace("{{[[--id--]]}}",OrderDetailConfirm[i].id);
            row_now = row_now.replace("{{[[--id--]]}}",OrderDetailConfirm[i].id);
            row_now = row_now.replace("{{[[--id--]]}}",OrderDetailConfirm[i].id);

            row_now = row_now.replace("{{[[--food_id--]]}}",OrderDetailConfirm[i].food_id);
            row_now = row_now.replace("{{[[--order_id--]]}}",OrderDetailConfirm[i].order_id);
            row_now = row_now.replace("{{[[--qty--]]}}",OrderDetailConfirm[i].qty);
            row_now = row_now.replace("{{[[--status--]]}}",OrderDetailConfirm[i].status);
            row_now = row_now.replace("{{[[--insert_time--]]}}",OrderDetailConfirm[i].insert_time);
            row_now = row_now.replace("{{[[--food_id_x--]]}}",OrderDetailConfirm[i].food_id_x);
            row_now = row_now.replace("{{[[--food_name--]]}}",OrderDetailConfirm[i].food_name);
            row_now = row_now.replace("{{[[--food_description--]]}}",OrderDetailConfirm[i].food_description);
            row_now = row_now.replace("{{[[--food_price--]]}}",OrderDetailConfirm[i].food_price);
            row_now = row_now.replace("{{[[--food_image--]]}}",OrderDetailConfirm[i].food_image);
            row_now = row_now.replace("{{[[--food_cat_id--]]}}",OrderDetailConfirm[i].food_cat_id);
            $("#confirmed_table").append(row_now);

            
         }
          //$("#wait_confirm_table")

      }
      //////////END ORDER DETAIL (ORDER FOOD) ///////////////////

      ///////////////LOAD DATA////////////////
      

      function addListenerToFoodTile(id)
      {
         var id_x = "#food_tile_id_"+id;
         $(id_x).css('cursor','pointer');


         $( id_x ).off();

         $(id_x).mouseover(function(){
            $(this).css("background-color","#aaa");
         });

         $(id_x).mouseout(function(){
           $(this).css("background-color","#ddd");
         });

         $(id_x).mousedown(function(){
           $(this).css("background-color","#aaf");
         });

         $(id_x).mouseup(function(){
           $(this).css("background-color","#aaa");
         });

         $(id_x).click(function(){
            //alert("a");
            
            var food_id_x =  $(this).attr('food-id');
            console.log(food_id_x);
            orderFood(food_id_x);
            //alert(link);
            //var full_link = "http://www.youtube.com/embed/"+
            //  link+"?rel=0&wmode=transparent&autoplay=1";
            //alert(full_link);
            //  $(".youtube").attr( 'href', full_link );
            //  $(".youtube").trigger("click");
         });
      }


      function loadCategory()
      {
         console.log("b");
         $.get("category/output/ajax_get_all_category.php", function(data, status){
            console.log("a");
            var categorys = JSON.parse(data);
            categories = categorys;
            for(var i = 0 ; i < categorys.length ; i ++)
            {
               var x = "<li><a href='#food_category_"+categorys[i].id+"'>"+categorys[i].name+"</a></li>";
               $("#category_tab").append(x);

               var y = "<div id='food_category_"+categorys[i].id+"'>    \
                           <div class = 'row' style='height:auto;'>       \
                           </div>     \
                        </div>";
               $("#tabs").append(y);
            }
            
            

            ///

            loadFood();
         });
      }

      function loadFood()
      {
         count = 0;
         all_foods = [];
         for(var i = 0 ; i < categories.length ; i ++)
         {
            /*
            $.get("food/output/ajax_get_all_food.php?cat_id="+categories[i].id
               , function(data, status){
                     var foods =  JSON.parse(data);
                     console.log("food");
                     for(var j =0 ; j < foods.length ; j ++)
                     {
                        var y = "<div>    \
                                    <img src='"+foods[j].image+"'/>   \
                                 </div>";

                        console.log("categories[i].id" + categories[i].id);
                        $("#food_category_"+categories[i].id).append(y);
                     }

            });
            */

            $.ajax({
                    url: "food/output/ajax_get_all_food.php?cat_id="+categories[i].id,
                    context: (i+1)
                  }).done(function(data) 
                  {
                        
                        var foods =  JSON.parse(data);
                        all_foods.push(foods);
                        console.log("food");
                        for(var j =0 ; j < foods.length ; j ++)
                        {
                           //foods[j].image

                           var template_food
                                  = "<div id='food_tile_id_{{[[--ID--]]}}' class = 'foot_tile col-md-6' food-id = '{{[[--ID--]]}}' >    \
                                       <img src='{{[[--IMAGE_PATH--]]}}'/>   \
                                       <div class='headline'> \
                                          {{[[--NAME--]]}} \
                                       </div> \
                                       <div class='description'> \
                                          {{[[--DRESCRIPTION--]]}} \
                                       </div> \
                                       <div class='price'> \
                                          {{[[--PRICE--]]}}  บาท\
                                       </div> \
                                    </div>";

                           var food =  template_food;
                           food = food.replace("{{[[--ID--]]}}",foods[j].id);
                           food = food.replace("{{[[--ID--]]}}",foods[j].id);
                           food = food.replace("{{[[--NAME--]]}}",foods[j].name);
                           food = food.replace("{{[[--DRESCRIPTION--]]}}",foods[j].description);
                           food = food.replace("{{[[--IMAGE_PATH--]]}}",foods[j].image );
                           food = food.replace("{{[[--PRICE--]]}}",foods[j].price );
                           console.log(this-1);
                           console.log("categories[i].id" + categories[this-1].id);

                           $("#food_category_"+categories[this-1].id + ">div").append(food);
                           addListenerToFoodTile(foods[j].id);
                        }

                        count ++;
                        $(function() {
                           $( "#tabs" ).tabs();
                        });

                        //add mouselistener



                        
                  });

         }

         setTimeout(
               function()
               { 
                  $(function()
                  {
                           $( "#tabs" ).tabs();
                  });
               }, 3000);
      }




      $( document ).ready(function() {
            loadCategory();

            showPopUp();

            // ทำให้มันรอ อันอื่น load ให้เสร็จก่อน


            $("#btn_open_table").click(function ()
               {
                  ///validate //////
                  var table_no_x = $("#table_number").val();
                  if(!isNaN(parseInt(table_no_x)))
                  {

                  }
                  else
                  {
                     $("#popup_numberOnly").show();
                     return;
                  }
                  ///end validate //////
                  console.log("post to create_order.php ,table_no : " + table_no_x);
                  //send http POST tO create new table or open exist table
                  $.post( "create_order.php", { table_no: table_no_x})
                     .done(function( data ) {
                        console.log("POST FINISH " + data );
                        order_now = JSON.parse(data);
                        var c  = " id : " + order_now[0].id +
                                 " , table_no : " + order_now[0].table_no +
                                 " , status : " + order_now[0].status +
                                 " , insert_time : " + order_now[0].insert_time ;
                        $("#order_now").html(c);
                        closePopUp();
                        getOrderDetail();


                     });

               });
            
      });

     </script>
   </head>
   <body>
      <div class="container-fluid" style= "margin:0px;padding:0px;">

         <div class= "popupBackground">
            <div class="popup">
               <h1>ยินดีต้อนรับเข้าสู่ ร้าน EPT</h1>
                 <div class="form-group">
                     <label for="table_number">โต๊ะ</label>
                     <input type="text" class="form-control" id="table_number" placeholder="Enter เลขที่โต๊ะ">
                     <div id = "popup_numberOnly" 
                        style= " color:red;
                                 display:none;">
                        กรุณาใส่หมายเลข โต๊ะของท่านด้วย
                     </div>
                 </div>
                 <button  id = "btn_open_table" class="btn btn-default">Submit</button>
            </div>
         </div>



         <div id="tabs">
            <ul id="category_tab">
               <li><a href = "#order_list" >รายการอาหารที่สั่ง</a></li>
            </ul>
            <div id="order_list">
               รายการอาหารที่สั่ง
               <br/>
               <div id="order_now">

               </div>

               <br/>
               <br/>
               <h1>รายการอาหารที่สั่ง รอยืนยัน</h1>
               <br/>

               <div class="wait_confirm">
                  <table  class="table table-bordered table-striped">
                     <tbody id = "wait_confirm_table">
                        <tr>
                           <th>id</th>
                           <th>food_id</th>
                           <th>order_id</th>
                           <th>qty</th>
                           <th>status</th>
                           <th>insert_time</th>
                           <th>food_id_x</th>
                           <th>food_name</th>
                           <th>food_description</th>
                           <th>food_price</th>
                           <th>food_image</th>
                           <th>food_cat_id</th>
                           <th>ยืนยัน</th>
                        </tr>
                     </tbody>
                  </table>
               </div>

               <br/>
               <br/>
               <br/>
               <h1>รายการอาหารที่สั่ง ยืนยันแล้ว</h1>
               <br/>

               <div class="confirmed">
                  <table  class="table table-bordered table-striped">
                     <tbody id = "confirmed_table">
                        <tr>
                           <th>id</th>
                           <th>food_id</th>
                           <th>order_id</th>
                           <th>qty</th>
                           <th>status</th>
                           <th>insert_time</th>
                           <th>food_id_x</th>
                           <th>food_name</th>
                           <th>food_description</th>
                           <th>food_price</th>
                           <th>food_image</th>
                           <th>food_cat_id</th>

                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>

         </div>
      
      </div>
      <script src="bootstrap/js/bootstrap.min.js"></script>
   </body>
</html>