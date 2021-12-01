// Elements
const wellsDOM = document.querySelector('.wells')
const wellFormContainer = document.querySelector('.well_form_container')
const root = document.querySelector('#oil_wells')
let loading = false;

// Functions
readWells()
async function readWells() {
  if(loading) return
  setLoading(true)

  const req = await fetch('./operations/read.php')
  let res;
  try {
    res = await req.json()
  } catch (error) {
    setLoading(false)
    return
  }

  if(res === null) {
    setLoading(false)
    return
  }

  wellsDOM.innerHTML = ''
  for (let i = 0; i < res.length; i++) {
    const well = res[i];
    
    wellsDOM.innerHTML += `
    <div class="well">
      <span>${well.name} #${well.id}</span>
      <div class="operations">
        <button
          class="read read_btn"
          onClick="displayWellModal({name: '${well.name}', id: ${well.id}})"
        ></button>

        <button
          class="update update_btn"
          onClick="displayUpdateWellForm({name: '${well.name}', id: ${well.id}})"
        ></button>

        <button
          class="delete delete_btn"
          onClick="deleteWell({name: '${well.name}', id: ${well.id}})"
        ></button>
        
        <button
          class="graph graph_btn"
          onClick="displayWellGraphModal({name: '${well.name}', id: ${well.id}})"
        ></button>
      </div>
    </div>`    
  }
  setLoading(false)
}

async function displayWellModal(well) {
  if(loading) return
  setLoading(true)
  
  // Fetch measurements
  const req = await fetch(`./operations/read.php?subject=measurements&id=${well.id}`)
  const res = await req.json()

  // Render
  const measurements = document.createElement('div')
  if(res[0].id === undefined) {
    measurements.innerHTML += `<div class="item center">Sin entradas</div>`
  } else {        
    for (let i = 0; i < res.length; i++) {
      const measurement = res[i];
      measurements.innerHTML += `
      <div class="item">
      <span class="id">#${measurement.id}</span>
      <span>Presión: <b>${measurement.pressure} psi</b></span>
      <span>Fecha: <b>${measurement.date}</b></span>
      <span class="operations">
        <button
          class="update update_btn"
          onClick="displayUpdateMeasurementForm(
            { name: '${well.name}', id: ${well.id}},
            { id: ${measurement.id} })"
        ></button>

        <button
          class="delete delete_btn"
          onClick="deleteMeasurement(
            { id: ${measurement.id} },
            { name: '${well.name}', id: ${well.id}})"
        ></button>
      </span>
      </div>`
    }
  }

  const modal = document.createElement('div')
  modal.classList.add('modal')
  modal.innerHTML = `
  <div>
    <button
      class="delete_btn"
      onClick="removeModal()"
    ></button>
    <h3>${well.name} #${well.id}</h3>

    <div class="measurements">
      ${measurements.innerHTML}
    </div>
    
    <div class="modal_form_container">
      <form onsubmit="submitMeasurement(event)">
        <input type="text" name="name" value="${well.name}" class="hidden">
        <input type="text" name="well_id" value="${well.id}" class="hidden">
        <input type="number" name="pressure" placeholder="Escriba un valor..." required>
        <input type="date" name="date" required>
        <button class="add_btn"></button>
      </form>
    </div>
  </div>`
  removeModal()
  root.appendChild(modal)
  setLoading(false)
}

async function displayWellGraphModal(well) {
  if(loading) return
  setLoading(true)
  
  // Fetch measurements
  const req = await fetch(`./operations/read.php?subject=measurements&id=${well.id}`)
  const res = await req.json()

  // Render
  const canvas = document.createElement('canvas')
  canvas.width = 400
  canvas.height = 400

  const pressures = []
  const dates = []

  for (let i = 0; i < res.length; i++) {
    pressures.push(res[i].pressure);
    dates.push(res[i].date);
  }

  const ctx = canvas.getContext('2d')

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: dates,
      datasets: [{
        label: `Gráfica Pozo "${well.name}"`,
        data: pressures,
        fill: false,
        borderColor: '#91181b',
      }]
    }
  })
  const modal = document.createElement('div')
  const div = document.createElement('div')
  div.innerHTML = `
  <button
    class="delete_btn"
    onClick="removeModal()"
  ></button>`
  modal.classList.add('modal')
  div.appendChild(canvas)
  modal.appendChild(div)
  root.appendChild(modal)
  setLoading(false)
}

function removeModal() {
  document.body.querySelector('.modal') ? document.body.querySelector('.modal').remove() : ''
}

function displayUpdateMeasurementForm(well, measurement) {
  const modalFormContainer = document.querySelector('.modal_form_container')
  
  modalFormContainer.innerHTML = `
  <h3>Actualizar Medición #${measurement.id}</h3>
  <form onsubmit="updateMeasurement(event)">
    <input type="text" name="name" value="${well.name}" class="hidden">
    <input type="text" name="well_id" value="${well.id}" class="hidden">
    <input type="text" name="id" value="${measurement.id}" class="hidden">
    <input type="number" name="pressure" placeholder="Escriba un valor..." required>
    <input type="date" name="date" required>
    <button class="update_btn"></button>
    <button class="return_btn" onClick="displayWellModal({name: '${well.name}', id: ${well.id}})"></button>
  </form>`
}

function displayUpdateWellForm(well) {
  wellFormContainer.innerHTML = `
  <h3 class="title">Actualizar ${well.name}</h3>
  <form onsubmit="updateWell(event)">
    <input type="text" name="id" value="${well.id}" class="hidden">
      <input type="text" name="name" placeholder="Escriba un nombre..." required>
    <button class="update_btn"></button>
    <button class="return_btn" onClick="displayAddWellForm()"></button>
  </form>`
}

function displayAddWellForm() {
  wellFormContainer.innerHTML = `
  <h3 class="title">Añadir Pozo</h3>
  <form onsubmit="submitWell(event)">
    <input type="text" name="name" placeholder="Escriba un nombre..." required>
    <button class="add_btn"></button>
  </form>`
}

// Wells Operations
async function submitWell(e) {
  e.preventDefault()

  if(loading) return
  setLoading(true)

  const formData = new FormData(e.target);
  formData.append('subject', 'wells')

  const req = await fetch('./operations/add.php', {
    method: 'POST',
    body: formData
  })
  const res = await req.text()

  e.target.children[0].value = ""
  setLoading(false)
  readWells()
}

// Mesurements Operations
async function submitMeasurement(e) {
  e.preventDefault()

  if(loading) return
  setLoading(true)

  const formData = new FormData(e.target);
  formData.append('subject', 'measurements')

  const req = await fetch('./operations/add.php', {
    method: 'POST',
    body: formData
  })
  const res = await req.text()

  console.log(res)

  removeModal()
  setLoading(false)
  displayWellModal({id: formData.get('well_id'), name: formData.get('name')})
}

async function updateMeasurement(e) {
  e.preventDefault()

  if(loading) return
  setLoading(true)
  
  const formData = new FormData(e.target);
  formData.append('subject', 'measurements')

  const req = await fetch('./operations/update.php', {
    method: 'POST',
    body: formData
  })
  const res = await req.json()

  setLoading(false)
  if(res.error === false) {
    removeModal()
    displayWellModal({id: formData.get('well_id'), name: formData.get('name')})
  } else {
    alert('Error')
  }
}

async function deleteMeasurement(measurement, well) {
  const confirmResponse = confirm(`¿Desea borrar la medición #${measurement.id}?`)
  if(confirmResponse === false) return
  if(loading) return
  setLoading(true)
  
  const formData = new FormData();
  formData.append('subject', 'measurements')
  formData.append('id', measurement.id)

  const req = await fetch('./operations/delete.php', {
    method: 'POST',
    body: formData
  })
  const res = await req.json()

  setLoading(false)
  if(res.error === false) {
    removeModal()
    displayWellModal({id: well.id, name: well.name})
  } else {
    alert('Error')
  }
}

async function updateWell(e) {
  e.preventDefault()

  if(loading) return
  setLoading(true)
  
  const formData = new FormData(e.target);
  formData.append('subject', 'wells')

  const req = await fetch('./operations/update.php', {
    method: 'POST',
    body: formData
  })
  const res = await req.json()

  setLoading(false)
  if(res.error === false) {
    readWells()
    displayAddWellForm()
  } else {
    alert('Error')
  }
}

async function deleteWell(well) {
  const confirmResponse = confirm(`¿Desea borrar el Pozo ${well.name}?`)
  if(confirmResponse === false) return
  if(loading) return
  setLoading(true)
  
  const formData = new FormData();
  formData.append('subject', 'wells')
  formData.append('id', well.id)

  const req = await fetch('./operations/delete.php', {
    method: 'POST',
    body: formData
  })
  const res = await req.json()

  setLoading(false)
  if(res.error === false) {
    readWells()
  } else {
    alert('Error')
  }

}

async function resetData() {
  const confirmResponse = confirm(`¿Desea restablecer los datos al estado inicial?`)
  if(confirmResponse === false) return
  if(loading) return
  setLoading(true)

  const req = await fetch('./operations/reset.php')
  const res = await req.json()

  setLoading(false)

  if(res.error === false) {
    location.reload()
  } else {
    alert('Error')
  }
}

function setLoading(boolean) {
  boolean ? root.classList.add('loading') : root.classList.remove('loading')
  loading = boolean
}