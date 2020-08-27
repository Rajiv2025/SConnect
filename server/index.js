var server = require("ws").Server;
var s = new server({port: 5001});

s.on("connection", function(sock){
  var status= JSON.stringify({
    type: "status",
    status_value: "online",
  });
  console.log("server: success");
  sock.on("message", function(msg){
    msg = JSON.parse(msg);
    if (msg.type == "cur_user") {
      sock.my_id = msg.my_id;
      sock.opp_id = msg.opp_id;
      return;
    }
    s.clients.forEach((client, i) => {

      if (client != sock) {
        client.send(status);
        if (client.my_id == msg.to) {
          client.send(JSON.stringify({
            msg_data: msg.data,
          }));

        }
      }
    });
  })
})
s.onclose = function(){
  console.log("connection closed by one client");
  s.send(JSON.stringify({
    type: "status",
    status_value: "offline",
  }))
}
