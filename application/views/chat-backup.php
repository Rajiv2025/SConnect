<?php $this->load->view('adminheader'); ?>
<div class="main-body-content w-100 ets-pt">
  <div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
      <div class="col-md-4 col-xl-3 chat"><div class="card mb-sm-3 mb-md-0 contacts_card">
        <div class="card-header">
          <div class="input-group">
            <input type="text" placeholder="Search..." name="" class="form-control search">
            <div class="input-group-prepend">
              <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
            </div>
          </div>
        </div>
        <input type="hidden" id="my-id" data-value="<?php echo $myid ?>"/>
        <div class="card-body contacts_body">
          <ul class="contacts" id="">
            <?php foreach ($allusers as $user): ?>

            <li class="inactive all" id="<?php echo "active".$user['id'] ?>" data-value="<?php echo $user['id'];?>" data-name="<?php echo $user['firstname'] ?>">

                <div class="d-flex bd-highlight">
                  <div class="img_cont">
                    <img src="" class="rounded-circle user_img">
                    <span class="online_icon"></span>
                  </div>
                  <div class="user_info">
                    <span><?php echo $user['firstname'] ?></span>
                    <!-- <p>Kalid is online</p> -->
                  </div>
                </div>
              </li>

            <?php endforeach; ?>
          </ul>
        </div>
        <div class="card-footer"></div>
      </div></div>
      <div class="col-md-8 col-xl-6 chat">
        <div class="card">
          <div class="card-header msg_head">
            <div class="d-flex bd-highlight">
              <div class="img_cont">
                <img src="" class="rounded-circle user_img">
                <span class="online_icon"></span>
              </div>
              <div class="user_info">
                <span id="display-name"></span>

              </div>
              <div class="video_cam">
                <span><i class="fas fa-video"></i></span>
                <span><i class="fas fa-phone"></i></span>
              </div>
            </div>
            <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
            <div class="action_menu">
              <ul>
                <li><i class="fas fa-user-circle"></i> View profile</li>
                <li><i class="fas fa-users"></i> Add to close friends</li>
                <li><i class="fas fa-plus"></i> Add to group</li>
                <li><i class="fas fa-ban"></i> Block</li>
              </ul>
            </div>
          </div>
          <div id="msgs-body" class="card-body msg_card_body">

            <!-- <div class="d-flex justify-content-start mb-4">
              <div class="msg_cotainer">
                <p id="left-msg"></p>
                <span id="left-time" class="msg_time"></span>
              </div>
            </div>

            <div class="d-flex justify-content-end mb-4">
              <div class="msg_cotainer_send">
                <p id="right-msg"></p>
                <span id="right-time"></span>
              </div>
            </div> -->

          </div>
          <div class="card-footer">
            <div class="input-group">
              <div class="input-group-append">
                <span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
              </div>
                <textarea id="message" name="message" class="form-control type_msg" value="" placeholder="Type your message..."></textarea>


              <div class="input-group-append">
                <span class="input-group-text send_btn" id="submit-btn"><i class="fas fa-location-arrow"></i></span>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<script type="text/javascript">
$(document).ready(function(){
  $('#action_menu_btn').click(function(){
    $('.action_menu').toggle();
  });

var my_id = $('#my-id').attr('data-value');


  $(".all").one("click", function(){
    var opp_id ="";
    opp_id = $(this).attr("data-value");
    var name="";
    name = $(this).attr("data-name");
    $('#display-name').html(name);
    recall_again();
    function recall_again(){
    // all msgs start
    $.ajax({
      method: "POST",
      data: {opp_id: opp_id},
      dataType: "JSON",
      url: "<?php echo base_url(); ?>ChatController/getAllMessage",
    }).done(function(chat_data){
      $('#message').val('');
      $('#msgs-body').empty();
      for (var i = 0; i < Object.keys(chat_data.all_msgs).length; i++) {

        if(chat_data.all_msgs[i]['receiver_id'] == opp_id && chat_data.all_msgs[i]['sender_id'] == my_id){
          var ele = "<div class='d-flex justify-content-end mb-4'>"+
            "<div class='msg_cotainer_send text-right'>"+
              "<p class='msg-spacing' id='right-msg'>"+chat_data.all_msgs[i]['msg']+"</p>"+
              "<p class='spacing' id='right-time' style='margin-left:120px; color:#000;' class='msg_time'>"+chat_data.all_msgs[i]['show_time']+"</p>"+
            "</div>"+
          "</div>";
          $('#msgs-body').append(ele);
        } else if(chat_data.all_msgs[i]['receiver_id'] == my_id && chat_data.all_msgs[i]['sender_id'] == opp_id){

          var ele = "<div class='d-flex justify-content-start mb-4'>"+
            "<div class='msg_cotainer text-left'>"+
              "<p class='msg-spacing' id='left-msg'>"+chat_data.all_msgs[i]['msg']+"</p>"+
              "<p class='spacing' id='left-time' class='msg_time'>"+chat_data.all_msgs[i]['show_time']+"</p>"+
            "</div>"+
          "</div>";
          $('#msgs-body').append(ele);
        }
      }

    }).always(function(){
      console.log("always");
      // recall_again();
    })
    // all msgs ends




    $('#submit-btn').on("click", function(){
      var msg = "";
      msg = $('#message').val();
      $.ajax({
        method: "POST",
        data: {msg: msg, opp_id: opp_id},
        dataType: "JSON",
        url: "<?php echo base_url(); ?>ChatController/message",
      }).done(function(chat_data){
        $('#message').val('');


          if(chat_data.msgs[Object.keys(chat_data.msgs).length-1]['receiver_id'] == opp_id && chat_data.msgs[Object.keys(chat_data.msgs).length-1]['sender_id'] == my_id){
            var ele = "<div class='d-flex justify-content-end mb-4'>"+
              "<div class='msg_cotainer_send text-right'>"+
                "<p class='msg-spacing' id='right-msg'>"+chat_data.msgs[Object.keys(chat_data.msgs).length-1]['msg']+"</p>"+
                "<p class='spacing' id='right-time' style='margin-left:120px; color:#000;' class='msg_time'>"+chat_data.msgs[Object.keys(chat_data.msgs).length-1]['show_time']+"</p>"+
              "</div>"+
            "</div>";
            $('#msgs-body').append(ele);
          } else if(chat_data.msgs[Object.keys(chat_data.msgs).length-1]['receiver_id'] == my_id && chat_data.msgs[Object.keys(chat_data.msgs).length-1]['sender_id'] == opp_id){

            var ele = "<div class='d-flex justify-content-start mb-4'>"+
              "<div class='msg_cotainer text-left'>"+
                "<p class='msg-spacing' id='left-msg'>"+chat_data.msgs[Object.keys(chat_data.msgs).length-1]['msg']+"</p>"+
                "<p class='spacing' id='left-time' class='msg_time'>"+chat_data.msgs[Object.keys(chat_data.msgs).length-1]['show_time']+"</p>"+
              "</div>"+
            "</div>";
            $('#msgs-body').append(ele);
          }
          recall_again();
      }).always(function(){
        console.log("always function");
        // setInterval('location.reload()', 100);
        // recall_again();
      })
    });
}// recall function end
  })



});


</script>

<?php $this->load->view('adminfooter'); ?>
