<?php $this->load->view('adminheader'); ?>

<div class="mt-4">
  <div class="container-fluid h-100 mt-auto">
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
          <ul class="contacts" id="all-contacts">

            <?php for ($i=0; $i < count($allusers); $i++): ?>


            <li class="inactive all" id="<?php echo "active".$allusers[$i]['id'] ?>" data-value="<?php echo $allusers[$i]['id'];?>" data-name="<?php echo $allusers[$i]['name'] ?>" data-status="<?php echo $allusers[$i]['online_status'] ?>">

                <div class="d-flex bd-highlight">
                  <div class="img_cont">
                    <img src="" class="rounded-circle user_img">
                  </div>
                  <div class="user_info">
                    <span><?php echo $allusers[$i]['name'] ?></span>
                  </div>
                </div>
              </li>

            <?php endfor; ?>

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
                <span class="online_icon" id="indicator"></span>

              </div>
              <div class="user_info">
                <span id="display-name"></span>
                <p id="display-status"></p>

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

  // var user_id = $('li.all').attr("data-value");
  var sock = new WebSocket("ws://localhost:5001");
  sock.onopen = function(){
    console.log("connection established.");
  }

  var selected = null;
  var opp_id = null;
  var my_id = $('#my-id').attr('data-value');
  var v = $('#all-contacts').children().on("click", function(){
    selected = true;
    opp_id = $(this).attr('data-value');
    var name = $(this).attr('data-name');
    var status = $(this).attr('data-status');
    $('span#display-name').html(name);

    var data = get_msgs_of_oppid(opp_id);

    sock.send(JSON.stringify({
      type: "cur_user",
      my_id: my_id,
      opp_id: opp_id,
    }));
  });
  function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}
  function get_msgs_of_oppid(opp_id){
    $('#msgs-body').empty();
    $.ajax({
      method: "POST",
      dataType: "JSON",
      data: {opp_id: opp_id},
      url: "<?php echo base_url();?>ChatController/getAllMessage",
    }).done(function(data){
      $('p#display-status').html(data.status[0].status);
      if (data.status[0].status == "online") {
        $('#indicator').removeClass();
        $('#indicator').addClass("online_icon");
      } else if(data.status[0].status == "offline"){
        $('#indicator').removeClass();
        $('#indicator').addClass("offline_icon");
      } else{
        $('#indicator').removeClass();
      }

      for (var i = 0; i < Object.keys(data.all_msgs).length; i++) {

        if(data.all_msgs[i]['receiver_id'] == opp_id && data.all_msgs[i]['sender_id'] == my_id){
          var ele = "<div class='d-flex justify-content-end mb-4'>"+
            "<div class='msg_cotainer_send text-right'>"+
              "<p class='msg-spacing' id='right-msg'>"+data.all_msgs[i]['msg']+"</p>"+
              "<p class='spacing' id='right-time' style='margin-left:120px; color:#000;' class='msg_time'>"+data.all_msgs[i]['show_time']+"</p>"+
            "</div>"+
          "</div>";
          $('#msgs-body').append(ele);
        } else if(data.all_msgs[i]['receiver_id'] == my_id && data.all_msgs[i]['sender_id'] == opp_id){

          var ele = "<div class='d-flex justify-content-start mb-4'>"+
            "<div class='msg_cotainer text-left'>"+
              "<p class='msg-spacing' id='left-msg'>"+data.all_msgs[i]['msg']+"</p>"+
              "<p class='spacing' id='left-time' class='msg_time'>"+data.all_msgs[i]['show_time']+"</p>"+
            "</div>"+
          "</div>";
          $('#msgs-body').append(ele);
        }
      }
      return data.all_msgs;

    }).always(function(e){
      $('#msgs-body').scrollTop($('#msgs-body')[0].scrollHeight);
    });
  }

  $('#submit-btn').on("click", function(){

    if(selected){
      var msg = $('textarea#message').val();
      $('textarea#message').val('');

      if (msg != "") {
        var ele = "<div class='d-flex justify-content-end mb-4'>"+
          "<div class='msg_cotainer_send text-right'>"+
            "<p class='msg-spacing' id='right-msg'>"+msg+"</p>"+
            "<p class='spacing' id='right-time' style='margin-left:120px; color:#000;' class='msg_time'>"+formatAMPM(new Date)+"</p>"+
          "</div>"+
        "</div>";
        $('#msgs-body').append(ele);
        $.ajax({
          method: "POST",
          dataType: "JSON",
          data: {opp_id:opp_id,my_id:my_id,msg:msg},
          url: "<?php echo base_url(); ?>ChatController/UpdateClientMessage",

        }).done(function(data){
          get_msgs_of_oppid(opp_id);
        }).always(function(){
        })

        sock.send(JSON.stringify({
          type: "message",
          from: my_id,
          to: opp_id,
          data: msg
        }));
      } else{
        console.log("enter msg plz.");
      }
    } else {
      console.log("select a chat first");
    }
  });
  sock.onmessage = function(msg){
    msg = JSON.parse(msg.data);
    
    get_msgs_of_oppid(opp_id);
  }

});

</script>

<?php $this->load->view('adminfooter'); ?>
