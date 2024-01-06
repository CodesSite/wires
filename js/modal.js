document.addEventListener('DOMContentLoaded', () => {
	const modalBtn = document.getElementById('modalBtn');
	const closeBtn = document.querySelector('.close-icon');
	const modal = document.querySelector('.modal');

	modalBtn.addEventListener('click', () => {
		modal.classList.add('active-modal');
	})

	closeBtn.addEventListener('click', () => {
		modal.classList.remove('active-modal');
	})

	window.addEventListener('click', event => {
		if (event.target === modal){
			modal.classList.remove('active-modal');
		}
	})
});