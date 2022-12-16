const $ = document.querySelector.bind(document);
// const $$ = document.querySelectorAll.bind(document);

const form_groups = $$('.form-group-full input')
const checkboxes = $$('.form-group-checkbox')

form_groups.forEach(element => {
  element.onclick = (e) => {
    var parent = e.target.closest('.form-group')
    var checkbox = parent.querySelectorAll('.form-group-checkbox .form-group-checkbox-element input')
    if (element.checked == true) {
      var group = 4
      checkbox.forEach(input => {
        input.checked = true
        input.onclick = (e) => {
          if (input.checked == true) {
            group++

          } else {
            group--;
          }
          if (group == 4) {
            var parent = e.target.closest('.form-group')
            parent.querySelector('.form-group-full input').checked = true
          } else {
            var parent = e.target.closest('.form-group')
            parent.querySelector('.form-group-full input').checked = false
          }

        }
      })
    } else {
      group = 0
      checkbox.forEach(input => {
        input.checked = false
        input.onclick = (e) => {
          if (input.checked == true) {
            group++

          } else {
            group--;
          }
          if (group == 4) {
            var parent = e.target.closest('.form-group')
            parent.querySelector('.form-group-full input').checked = true
          } else {
            var parent = e.target.closest('.form-group')
            parent.querySelector('.form-group-full input').checked = false
          }

        }
      })
    }
  }
});

checkboxes.forEach(element => {
  var group = 0
  element.querySelectorAll('input').forEach(input => {

    input.onclick = (e) => {

      if (input.checked == true) {
        group++
      } else {
        group--;
      }
      if (group == 4) {
        var parent = e.target.closest('.form-group')
        parent.querySelector('.form-group-full input').checked = true
      } else {
        var parent = e.target.closest('.form-group')
        parent.querySelector('.form-group-full input').checked = false
      }
    }
  })
})

checkboxes.forEach((checkbox) => {
  var element = checkbox.querySelectorAll('input[type="checkbox"]')
  for (i = 0; i < element.length; i++) {
    if (element[i].checked == true) {
      checkbox.parentElement.querySelector('.form-group-full input').checked = true
    } else {
      checkbox.parentElement.querySelector('.form-group-full input').checked = false;
      break
    }
  }
  // element.forEach((element) => {
  //   console.log(element)
  //   

  // })
})
