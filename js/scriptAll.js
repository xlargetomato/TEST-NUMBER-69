const LINKS = document.querySelectorAll(".link");
//// Index >> mainmenu = (0),course = (1),leacture = (2)||,assign = (3),,controlpanel = (4),about = (6),
////////////////////////////////////
// const lectureList = document.querySelector(".slidedown");
const listA = document.querySelector(".listA");
const listchilds = document.querySelectorAll(".listA li");
listchilds[0].addEventListener("click", function () {
  window.location = "lectureOrquestions.html";
});
LINKS[2].onclick = () => {
  listA.classList.toggle("BLOCK");
};
LINKS[0].addEventListener("click", () => {
  window.location = "index.html";
});
LINKS[1].addEventListener("click", () => {
  window.location = "course.html";
});
LINKS[3].addEventListener("click", () => {
  window.location = "assignments.html";
});
// LINKS[99].addEventListener("click", () => {
//   window.location = "index.html";
// });
