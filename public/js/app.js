$(document).ready(function () {
  $(".loading-div").fadeOut(2000);
  localStorage.setItem("lang", "en");
  // var btn_top = $("#scroll-top");
  // btn_top.addClass("show");
  // $(".login .card.Teatcher").click(function () {
  //   $(".login .card.Teatcher ").addClass("active");
  //   $(".login .card.Student ").removeClass("active");
  //   $(".login a ").attr("href", "sign-in-teatcher.html");
  // });
  // $(".login .card.Student").click(function () {
  //   $(".login .card.Teatcher ").removeClass("active");
  //   $(".login .card.Student ").addClass("active");
  //   $(".login a ").attr("href", "sign-up-teatcher.html");
  // });
  // $("#Calendar").click(function () {
  //   $("#on").toggle();
  //   $("#off").toggle();
  // });
  // $("#Participants").click(function () {
  //   $("#Apps").removeClass("active");
  //   $("#Participants").addClass("active");
  //   $("#ActiveApps").fadeOut();
  //   $("#Active_Participants").fadeIn();
  // });
  // $("#Apps").click(function () {
  //   $("#Participants").removeClass("active");
  //   $("#Apps").addClass("active");
  //   $("#ActiveApps").fadeIn();
  //   $("#Active_Participants").fadeOut();
  // });
});

// function passwordToggle() {
//   var x = document.getElementById("Password");
//   var slash = document.getElementById("slash");
//   var eye = document.getElementById("eye");
//   if (x.type === "password") {
//     x.type = "text";
//     slash.style.display = "block";
//     eye.style.display = "none";
//   } else {
//     x.type = "password";
//     eye.style.display = "block";
//     slash.style.display = "none";
//   }
// }

// function AddActive(event) {
//   let tabbuttons = document.querySelectorAll(".q_choose");
//   console.log(tabbuttons);
//   tabbuttons.forEach((but) => {
//     console.log(but);
//     but.classList.remove("activeQuestionNew");
//   });
//   event.target.classList.add("activeQuestionNew");
// }
// function onUpload(valuePara, valueicon, event) {
//   document.getElementById(valuePara).innerHTML = event.target.value;
//   document.getElementById(valueicon).style.display = "block";
// }

// document.getElementsByClassName("langButton").innerHTML =
//   localStorage.getItem("lang") == "ar" ? "Ar" : "En";

// if (localStorage.getItem("lang") == "en") {
//   $("html").attr("class", "en");
//   $("html").attr("dir", "ltr");
//   localStorage.getItem("dir", "ltr");
// } else {
//   $("html").attr("class", "ar");
//   $("html").attr("dir", "rtl");
//   localStorage.getItem("dir", "rtl");
// }

// function AddActive(event, nameEffect) {
//   tabbuttons = document.querySelectorAll(nameEffect);
//   tabbuttons.forEach((but) => {
//     console.log(but);
//     but.classList.remove("activeQuestionNew");
//   });
//   event.target.classList.add("activeQuestionNew");
// }
// Change Lang
// function language(value) {
//   if (value == "en") {
//     $("html").attr("class", "en");
//     $("html").attr("dir", "ltr");
//     localStorage.setItem("dir", "ltr");
//     localStorage.setItem("lang", "en");
//     document.getElementsByClassName("langButton").innerHTML = "En";
//   } else {
//     $("html").attr("class", "ar");
//     $("html").attr("dir", "rtl");
//     localStorage.setItem("dir", "rtl");
//     localStorage.setItem("lang", "ar");
//     document.getElementsByClassName("langButton").innerHTML = "Ar";
//   }
// }
AOS.init();
