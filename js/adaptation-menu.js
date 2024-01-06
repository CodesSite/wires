//Toggle Button
const navTogglerBtn = document.querySelector(".nav-toggler");
const wrapper = document.querySelector(".wrapper");

if (navTogglerBtn) {
    navTogglerBtn.addEventListener("click", () =>{
    wrapperSectionTogglerBtn();
  });
}

function wrapperSectionTogglerBtn() {
  wrapper.classList.toggle("open");
  navTogglerBtn.classList.toggle("open");
  for(let i=0; i<totalSection; i++){
    allSection[i].classList.toggle("open");
  }
} 

//Section Page Animation
const nav = document.querySelector('nav'),
  navList = nav.querySelectorAll('li'),
  totalNavList = navList.length,
  allSection = document.querySelectorAll('.section'),
  totalSection = allSection.length;

for(let i=0; i<totalNavList; i++){
    const a = navList[i].querySelector('a');
    a.addEventListener('click', function() {
      //remove back section Class
      for(let i=0; i<totalSection; i++){
        allSection[i].classList.remove('back-section');
      }

      for(let j=0; j<totalNavList; j++){
        if (navList[j].querySelector('a').classList.contains('active')) {
          //add back section Class
        }

        navList[j].querySelector('a').classList.remove('active');
      }

      this.classList.add('active');

      showSection(this);
    })
  };

function showSection(element) {
  for(let i=0; i<totalSection; i++){
    allSection[i].classList.remove("active");
  }
  const target = element.getAttribute('href').split('#')[1];
  document.querySelector('#' + target).classList.add('active');
}