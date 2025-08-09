const { createRoot } = wp.element

import APP from './app/app'
import './main.scss'

window.PoeticsoftPartnerAdmin = (id) => {

  const element = document.getElementById(id)

  const root = createRoot(element)

  root.render(<APP />)
}