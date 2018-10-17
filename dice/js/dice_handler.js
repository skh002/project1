
function getQueryVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
      return pair[1];
    }
  } 
  return "";
}


function handleForm() {
       // retrieve form contents
       // build URI
       var uri = 'https://suman-api-skh002.c9users.io/diceapi/dice/6';
	   uri = uri + "?github_token=" + getQueryVariable("github_token");
	
       var request = new XMLHttpRequest();
       request.open("GET", uri, true);
       request.onreadystatechange = function(e) {
           if (request.readyState == 4) {
                if (request.status == 200) {
                    var reply_json = JSON.parse(request.responseText);
                    document.getElementById('result').value = reply_json.eyes;
					document.getElementById('greeting').innerHTML = "This result was tailored for " + reply_json.user + ".";
					//save to FireBase
					castId = randomString(32,
					'AIzaSyAMuOhihfMIsJPIrSwi1nPbCebiQRLfBhU');
					writeCast(castId, reply_json.user, reply_json.eyes,
					reply_json.faces);
                }
                else {
                    
                }
           }
           else {
               
           }
	   }; 
	   
	  

       request.onerror = function(e) {
           //alert("onerror");
       }   
    
       request.send();  
       //alert("Sent");


	
}

function createTable(){
    var table = document.querySelector('#table tbody');
      console.log(table)
        const casts = firebase.database().ref().child('casts').orderByChild("added_date").limitToLast(1);




      casts.on('value', snap => {
       

        var cast = snap.val();
        
        for(var i in cast) {
          document.getElementById('retrive_id').value = i;
          console.log(i,"cats")
          for(var j in cast[i]) {
              console.log(cast[i])
              document.getElementById('results').innerHTML = "Eyes:"+cast[i]['eyes']+" Faces: "+cast[i]['faces']+" User "+cast[i]['user']
          }
        }
      });

  }
function writeCast(castId, user, eyes, faces) {
 firebase.database().ref('casts/' + castId).set({
 castId: castId,
 user: user,
 eyes: eyes,
 faces : faces
 });
}	 

function randomString(length, chars) {
 var result = '';
 for (var i = length; i > 0; --i) result +=
chars[Math.floor(Math.random() * chars.length)];
 return result;
}   


