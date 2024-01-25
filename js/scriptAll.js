const LINKS = document.querySelectorAll(".link");
//// Index >> mainmenu = (0),lecture = (1),assignments = (2)||,controlpanel = (3),,about = (5),
////////////////////////////////////

const lectureList = document.querySelector(".slidedown");
const listA = document.querySelector(".listA");
lectureList.onclick = () => {
  listA.classList.toggle("BLOCK");
};
LINKS[0].addEventListener("click", () => {
  window.location = "index.html";
});
LINKS[1].addEventListener("click", () => {
  window.location = "lecture.html";
});
LINKS[2].addEventListener("click", () => {
  window.location = "assignments.html";
});
// LINKS[99].addEventListener("click", () => {
//   window.location = "index.html";
// });
