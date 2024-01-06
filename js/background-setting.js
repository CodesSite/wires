function setBackgroundColor(color) {
      document.body.style.backgroundColor = color;
      localStorage.setItem('backgroundColor', color); // збереження вибору користувача
    }

    // перевірка, чи є збережений вибір користувача
    if (localStorage.getItem('backgroundColor')) {
      document.body.style.backgroundColor = localStorage.getItem('backgroundColor');
    }

const savedColor = localStorage.getItem('textColor');
if (savedColor) {
  document.documentElement.style.setProperty('--dark', savedColor);
}

// Додаємо обробник події для кожної кнопки
const colorBtns = document.querySelectorAll('.color-btn');
colorBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    const color = btn.dataset.color;
    document.documentElement.style.setProperty('--dark', color);
    localStorage.setItem('textColor', color); // Зберігаємо значення кольору в локальному сховищі
  });
});