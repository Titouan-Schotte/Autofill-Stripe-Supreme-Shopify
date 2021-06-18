
const Discord = require("discord.js");
const client = new Discord.Client();
const config = require("./config.json");
const fs = require("fs");
//const { exec } = require('child_process');


//Ready
client.on("ready", () => {
  console.log("Logged as " +client.user.name);
});

//On user join
client.on("guildMemberAdd", member => {
  console.log(`${member.user.tag}`+ " join the server ! ID = " + `${member.id}` + " BOT ? : " + `${member.user.bot}`)
  var worth = true;
  try {
    const data = fs.readFileSync('user.txt', 'UTF-8');
    const lines = data.split(/\r?\n/);
    lines.forEach((line) => {
      if(line == member.id){
        console.log('Already Exist !')
        worth = false;
      }
    });
  } catch (err) {
    console.error(err);
  }
  if(worth){
    console.log('Dont Exist !')
    var content = '\n'+`${member.id}`
    if(!member.user.bot){
      try {
        fs.appendFile("user.txt",content,function (err) {
          if (err) throw err;
          console.log('Saved : ' + `${member.user.tag}`);});
      }
      catch (err) {
        console.error(err);
      }
    }
  }
});

//Login
client.login(config.token);