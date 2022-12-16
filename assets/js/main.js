// const $ = document.querySelector.bind(document)
const $$ = document.querySelectorAll.bind(document)

function set_active(element_1, element_2) {
  element_1.classList.toggle('active')
  element_2.classList.toggle('active')
}

function activeList() {
  $('.content-header-list-select-page').classList.toggle('active')
}

function getParentElement(element) {
  while (element == 'overlay-form') {

  }
  return element;
}

$$('.link-tab').forEach(element => {
  element.parentElement.closest('.overlay-form')
  element.addEventListener('click', (e) => {
    active = e.target.closest('.active')
    not_active = $('.overlay-form:not(.active)')
    set_active(active, not_active);
  })
});

function showMessageDelete(link) {
  if (confirm('Are you sure?')) {
    doAjax(link.href, "POST");
  }
  return false
}

function logout(link) {
  if (confirm('LOGOUT?')) {
    doAjax(link.href, "POST");
  }
  return false;
}
